<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Notifications;
use App\Models\UserFcmToken;
use App\Services\BootstrapTableService;
use App\Services\CachingService;
use App\Services\FileService;
use App\Services\NotificationService;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Throwable;


class NotificationController extends Controller {

    private string $uploadFolder;

    public function __construct() {
        $this->uploadFolder = "notification";
    }

    public function index() {
        ResponseService::noAnyPermissionThenRedirect(['notification-list', 'notification-create', 'notification-update', 'notification-delete']);
        $item_list = Item::approved()->get();
        return view('notification.index', compact('item_list'));
    }

    public function store(Request $request) {
        ResponseService::noPermissionThenSendJson('notification-create');
        $validator = Validator::make($request->all(), [
            'file'    => 'image|mimes:jpeg,png,jpg',
            'send_to' => 'required|in:all,selected',
            'user_id' => 'required_if:send_to,selected',
            'title'   => 'required',
            'message' => 'required',
        ],
            [
                'user_id' => [
                    'required_if' => __("Please select at least one user")
                ]
            ]
        );

        if ($validator->fails()) {
            ResponseService::validationError($validator->errors()->first());
        }
        try {
            $get_fcm_key = CachingService::getSystemSettings('fcm_key');
            if (!empty($get_fcm_key->data)) {
                ResponseService::errorResponse('Server FCM Key Is Missing');
            }
            $notification = Notifications::create([
                ...$request->all(),
                'image'   => $request->hasFile('file') ? FileService::compressAndUpload($request->file('file'), $this->uploadFolder) : '',
                'user_id' => $request->send_to == "selected" ? $request->user_id : ''
            ]);
            if ($request->send_to == "selected") {
                $fcm_ids = UserFcmToken::select('fcm_token')->whereIn('user_id', explode(',', $request->user_id))->pluck('fcm_token')->toArray();
            } else {
                $fcm_ids = UserFcmToken::whereHas('user', static function ($q) {
                    $q->where('notification', 1);
                })->select('fcm_token')->pluck('fcm_token')->toArray();
            }
            if (!empty($fcm_ids)) {
                $registrationIDs = array_filter($fcm_ids);
                $notification = NotificationService::sendFcmNotification($registrationIDs, $request->title, $request->message, "notification", [
                    "image"   => $notification->image,
                    "item_id" => $notification->item_id,
                ]);

                if (!$notification) {
                    ResponseService::warningResponse('FCM Settings are not configured');
                }
            }
            ResponseService::successResponse('Message Send Successfully', $notification);

        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, 'NotificationController -> store');
            ResponseService::errorResponse('Something Went Wrong');
        }
    }

    public function destroy($id) {
        try {
            ResponseService::noPermissionThenSendJson('notification-delete');
            $notification = Notifications::findOrFail($id);
            $notification->delete();
            FileService::delete($notification->getRawOriginal('image'));
            ResponseService::successResponse('Notification Deleted successfully');
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, 'NotificationController -> destroy');
            ResponseService::errorResponse('Something Went Wrong');
        }
    }

    public function show(Request $request) {
        ResponseService::noPermissionThenSendJson('notification-list');
        $offset = $request->offset ?? 0;
        $limit = $request->limit ?? 10;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'DESC';

        $sql = Notifications::where('id', '!=', 0)->orderBy($sort, $order);

        if (!empty($request->search)) {
            $sql = $sql->search($request->search);
        }

        $total = $sql->count();
        $sql->skip($offset)->take($limit);
        $result = $sql->get();
        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        foreach ($result as $key => $row) {
            $tempRow = $row->toArray();
            $operate = '';

            if (Auth::user()->can('notification-delete')) {
                $operate .= BootstrapTableService::deleteButton(route('notification.destroy', $row->id));
            }
            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }

    public function batchDelete(Request $request) {
        ResponseService::noPermissionThenSendJson('notification-delete');
        try {
            foreach (Notifications::whereIn('id', explode(',', $request->id))->get() as $row) {
                $row->delete();
                FileService::delete($row->getRawOriginal('image'));

            }
            ResponseService::successResponse("Notification deleted successfully");
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, "NotificationController -> batchDelete");
            ResponseService::errorResponse();
        }
    }
}
