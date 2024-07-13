<?php

namespace App\Http\Controllers;

use App\Models\Tip;
use App\Models\TipTranslation;
use App\Services\BootstrapTableService;
use App\Services\CachingService;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class TipController extends Controller {
    public function index() {
        ResponseService::noAnyPermissionThenRedirect(['tip-list', 'tip-create', 'tip-update', 'tip-delete']);
        return view('tip.index');
    }

    public function create() {
        ResponseService::noPermissionThenRedirect('tip-create');
        /*Values function is used to rearrange collection keys*/
        $languages = CachingService::getLanguages()->where('code', '!=', 'en')->values();
        return view('tip.create', compact('languages'));
    }

    public function store(Request $request) {
        ResponseService::noPermissionThenSendJson('tip-create');
        $request->validate([
            'description'    => 'required',
            'translations'   => 'nullable|array',
            'translations.*' => 'nullable|string',
        ]);
        try {
            DB::beginTransaction();
            $tip = Tip::create($request->all());
            if (!empty($request->translations)) {
                $tipTranslations = [];
                foreach ($request->translations as $key => $value) {
                    $tipTranslations[] = [
                        'description' => $value,
                        'language_id' => $key,
                        'tip_id'      => $tip->id,
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ];
                }
                TipTranslation::insert($tipTranslations);
            }
            DB::commit();
            ResponseService::successRedirectResponse("Tip Added Successfully", route('tips.index'));
        } catch (Throwable $th) {
            DB::rollBack();
            ResponseService::logErrorRedirect($th, "TipController->store");
            ResponseService::errorRedirectResponse();
        }
    }

    public function show(Request $request) {
        ResponseService::noPermissionThenSendJson('tip-list');
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $sort = $request->input('sort', 'sequence');
        $order = $request->input('order', 'ASC');
        $sql = Tip::with('translations.language:id,name')->orderBy($sort, $order);
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
        foreach ($result as $key => $row) {
            $operate = '';
            if (Auth::user()->can('tip-update')) {
                $operate .= BootstrapTableService::editButton(route('tips.edit', $row->id));
            }

            if (Auth::user()->can('tip-delete')) {
                $operate .= BootstrapTableService::deleteButton(route('tips.destroy', $row->id));
            }
            $tempRow = $row->toArray();
            $tempRow['no'] = $no++;
            $tempRow['operate'] = $operate;
            $tempRow['status'] = empty($row->deleted_at);
            $rows[] = $tempRow;
        }
        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }

    public function edit($id) {
        ResponseService::noPermissionThenRedirect('tip-update');
        $tip = Tip::with('translations')->findOrFail($id);

        $translations = $tip->translations->pluck('description', 'language_id');
        $languages = CachingService::getLanguages()->where('code', '!=', 'en')->values();
        return view('tip.edit', compact('tip', 'languages', 'translations'));
    }

    public function update(Request $request, $id) {
        ResponseService::noPermissionThenSendJson('tip-update');
        try {
            DB::beginTransaction();
            $request->validate([
                'description'    => 'required',
                'translations'   => 'nullable|array',
                'translations.*' => 'nullable|string',
            ]);
            $tip = Tip::findOrFail($id);
            $tip->update($request->all());
            if (!empty($request->translations)) {
                $tipTranslations = [];
                foreach ($request->translations as $key => $value) {
                    $tipTranslations[] = [
                        'description' => $value,
                        'language_id' => $key,
                        'tip_id'      => $tip->id,
                    ];
                }
                TipTranslation::upsert($tipTranslations, ['tip_id', 'language_id'], ['description']);
            }
            DB::commit();
            ResponseService::successRedirectResponse("Tip Updated Successfully", route('tips.index'));
        } catch (Throwable $th) {
            DB::rollBack();
            ResponseService::logErrorRedirect($th);
            ResponseService::errorRedirectResponse('Something Went Wrong ', route('tips.index'));
        }
    }

    public function destroy($id) {
        ResponseService::noPermissionThenSendJson('tip-delete');
        try {
            Tip::findOrFail($id)->forceDelete();
            ResponseService::successResponse('Tip delete successfully');
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th);
            ResponseService::errorResponse('Something Went Wrong ');
        }
    }
}
