<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use App\Services\ResponseService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Throwable;

/*Create Method which are common across the system*/

class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function changeRowOrder(Request $request) {
        try {
            $request->validate([
                'data'   => 'required|array',
                'table'  => 'required|string',
                'column' => 'nullable',
            ]);
            $column = $request->column ?? "sequence";

            $data = [];
            foreach ($request->data as $index => $row) {
                $data[] = [
                    'id'            => $row['id'],
                    (string)$column => $index
                ];
            }
            DB::table($request->table)->upsert($data, ['id'], [(string)$column]);
            ResponseService::successResponse("Order Changed Successfully");
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th);
            ResponseService::errorResponse();
        }
    }

    public function changeStatus(Request $request) {
        try {
            $request->validate([
                'id'     => 'required|numeric',
                'status' => 'required|boolean',
                'table'  => 'required|string',
                'column' => 'nullable',
            ]);
            $column = $request->column ?? "status";

            //Special case for deleted_at column
            if ($column == "deleted_at") {
                //If status is active then deleted_At will be empty otherwise it will have the current time
                $request->status = ($request->status) ? null : now();
            }
            DB::table($request->table)->where('id', $request->id)->update([(string)$column => $request->status]);
            ResponseService::successResponse("Status Updated Successfully");
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th);
            ResponseService::errorResponse();
        }

    }

    public function readLanguageFile() {
        try {
            //    https://medium.com/@serhii.matrunchyk/using-laravel-localization-with-javascript-and-vuejs-23064d0c210e
            header('Content-Type: text/javascript');
//        $labels = Cache::remember('lang.js', 3600, static function () {
//            $lang = app()->getLocale();
            $lang = Session::get('language');
//            $lang = app()->getLocale();
            $test = $lang->code ?? "en";
            $files = resource_path('lang/' . $test . '.json');
//            return File::get($files);
//        });]
            echo('window.languageLabels = ' . File::get($files));
            http_response_code(200);
            exit();
        } catch (Throwable $th) {
            ResponseService::errorResponse($th);
        }
    }

    public function contactUsUIndex() {
        return view('contact-us');
    }

    public function contactUsShow(Request $request) {

        $offset = $request->offset ?? 0;
        $limit = $request->limit ?? 10;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'DESC';

        $sql = ContactUs::orderBy($sort, $order);

        if (!empty($_GET['search'])) {
            $search = $_GET['search'];
            $sql->where('id', 'LIKE', "%$search%")
                ->orwhere('name', 'LIKE', "%$search%")
                ->orwhere('subject', 'LIKE', "%$search%")
                ->orwhere('message', 'LIKE', "%$search%");
        }
        $total = $sql->count();
        $sql->skip($offset)->take($limit);
        $result = $sql->get();
        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        foreach ($result as $row) {
            $rows[] = $row->toArray();
        }

        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }

}
