<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PaymentTransaction;
use App\Models\User;
use App\Models\UserPurchasedPackage;
use App\Services\BootstrapTableService;
use App\Services\ResponseService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class CustomersController extends Controller {
    public function index() {
        ResponseService::noAnyPermissionThenRedirect(['customer-list', 'customer-update']);
        $packages = Package::all()->where('status', 1);

        $itemListingPackage = $packages->filter(function ($data) {
            return $data->type == "item_listing";
        });

        $advertisementPackage = $packages->filter(function ($data) {
            return $data->type == "advertisement";
        });

        return view('customer.index', compact('packages', 'itemListingPackage', 'advertisementPackage'));
    }

    public function update(Request $request) {
        try {
            ResponseService::noPermissionThenSendJson('customer-update');
            User::where('id', $request->id)->update(['status' => $request->status]);
            $message = $request->status ? "Customer Activated Successfully" : "Customer Deactivated Successfully";
            ResponseService::successResponse($message);
        } catch (Throwable) {
            ResponseService::errorRedirectResponse('Something Went Wrong ');
        }
    }

    public function show(Request $request) {
        ResponseService::noPermissionThenSendJson('customer-list');
        $offset = $request->offset ?? 0;
        $limit = $request->limit ?? 10;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'DESC';

        if ($request->notification_list) {
            $sql = User::role('User')->orderBy($sort, $order)->has('fcm_tokens')->where('notification', 1);
        } else {
            $sql = User::role('User')->orderBy($sort, $order)->withCount('items')->withTrashed();
        }


        if (!empty($request->search)) {
            $sql = $sql->search($request->search);
        }

        $total = $sql->count();
        $sql->skip($offset)->take($limit);
        $result = $sql->get();
        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $no = 1;
        foreach ($result as $row) {
            $tempRow = $row->toArray();
            $tempRow['no'] = $no++;
            $tempRow['status'] = empty($row->deleted_at);

            if (config('app.demo_mode')) {
                // Get the first two digits, Apply enough asterisks to cover the middle numbers ,  Get the last two digits;
                if (!empty($row->mobile)) {
                    $tempRow['mobile'] = substr($row->mobile, 0, 3) . str_repeat('*', (strlen($row->mobile) - 5)) . substr($row->mobile, -2);
                }

                if (!empty($row->email)) {
                    $tempRow['email'] = substr($row->email, 0, 3) . '****' . substr($row->email, strpos($row->email, "@"));
                }
            }

            $tempRow['operate'] = BootstrapTableService::button(
                'fa fa-cart-plus',
                route('customer.assign.package', $row->id),
                ['btn-outline-danger', 'assign_package'],
                [
                    'title'          => __("Assign Package"),
                    "data-bs-target" => "#assignPackageModal",
                    "data-bs-toggle" => "modal"
                ]
            );
            $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }

    public function assignPackage(Request $request) {
        $validator = Validator::make($request->all(), [
            'package_id'      => 'required',
            'payment_gateway' => 'required|in:cash,cheque',
        ]);
        if ($validator->fails()) {
            ResponseService::validationError($validator->errors()->first());
        }
        try {
            DB::beginTransaction();
            ResponseService::noPermissionThenSendJson('customer-list');
            $user = User::find($request->user_id);
            if (empty($user)) {
                ResponseService::errorResponse('User is not Active');
            }
            $package = Package::findOrFail($request->package_id);
            // Create a new payment transaction
            $paymentTransaction = PaymentTransaction::create([
                'user_id'         => $request->user_id,
                'package_id'      => $request->package_id,
                'amount'          => $package->final_price,
                'order_id'        => null,
                'payment_gateway' => $request->payment_gateway,
                'payment_status'  => 'succeed',
            ]);

            // Create a new user purchased package record
            UserPurchasedPackage::create([
                'user_id'                 => $request->user_id,
                'package_id'              => $request->package_id,
                'start_date'              => Carbon::now(),
                'end_date'                => $package->duration != 0 ? Carbon::now()->addDays($package->duration) : null,
                'total_limit'             => $package->item_limit == "unlimited" ? null : $package->item_limit,
                'used_limit'              => 0,
                'payment_transactions_id' => $paymentTransaction->id,
            ]);
            DB::commit();
            ResponseService::successResponse('Package assigned to user Successfully');
        } catch (Throwable $th) {
            DB::rollback();
            ResponseService::logErrorResponse($th, "CustomersController --> assignPackage");
            ResponseService::errorResponse();
        }
    }
}
