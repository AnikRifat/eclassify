<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;
use App\Services\ResponseService;
use App\Services\BootstrapTableService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Throwable;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        ResponseService::noAnyPermissionThenRedirect(['faq-create','faq-list','faq-update','faq-delete']);
        return view('faq.create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        ResponseService::noPermissionThenRedirect('faq-create');
        $validator = Validator::make($request->all(), [
            'question' => 'required|string',
            'answer'  => 'required|string',
        ]);
        if ($validator->fails()) {
            ResponseService::validationError($validator->errors()->first());
        }
        try {
            Faq::create([
                'question' => $request->question,
                'answer'   => $request->answer,
            ]);

            ResponseService::successResponse('Faq created successfully');
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, "Faq Controller -> store");
            ResponseService::errorResponse();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {

            ResponseService::noPermissionThenSendJson('faq-list');
            $offset = $request->input('offset', 0);
            $limit = $request->input('limit', 10);
            $sort = $request->input('sort', 'id');
            $order = $request->input('order', 'ASC');

            $sql = Faq::orderBy($sort, $order);

        if (!empty($_GET['search'])) {
            $search = $_GET['search'];
            $sql->where('id', 'LIKE', "%$search%")->orwhere('question', 'LIKE', "%$search%")->orwhere('answer', 'LIKE', "%$search%");
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
                if (Auth::user()->can('faq-update')) {
                    $operate .= BootstrapTableService::editButton(route('faq.update', $row->id), true, '#editModal', 'faqEvents', $row->id);
                }

                if (Auth::user()->can('faq-delete')) {
                    $operate .= BootstrapTableService::deleteButton(route('faq.destroy', $row->id));
                }
                $tempRow['operate'] = $operate;
                $rows[] = $tempRow;
            }

            $bulkData['rows'] = $rows;
            return response()->json($bulkData);

        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, "FaqController --> show");
            ResponseService::errorResponse();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        ResponseService::noPermissionThenSendJson('faq-update');
        $validator = Validator::make($request->all(), [
            'question'       => 'required|string',
            'answer'      => 'required|string',
        ]);
        if ($validator->fails()) {
            ResponseService::validationError($validator->errors()->first());
        }
        try {
            $feature_section = Faq::findOrFail($id);
            $data = $request->all();
            $feature_section->update($data);
            ResponseService::successResponse('FAQ Updated Successfully');
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, "Faq Controller -> update");
            ResponseService::errorResponse();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            ResponseService::noPermissionThenSendJson('faq-delete');
            Faq::findOrFail($id)->delete();
            ResponseService::successResponse('FAQ delete successfully');
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, "Faq Controller -> destroy");
            ResponseService::errorResponse('Something Went Wrong');
        }
    }

}

