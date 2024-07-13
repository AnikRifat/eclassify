<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FeatureSection;
use App\Services\BootstrapTableService;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Throwable;

class FeatureSectionController extends Controller {

    public function index() {
        ResponseService::noAnyPermissionThenRedirect(['feature-section-list', 'feature-section-create', 'feature-section-update', 'feature-section-delete']);
        $categories = Category::get();
        return view('feature_section.index', compact('categories'));
    }

    public function store(Request $request) {
        ResponseService::noPermissionThenSendJson('feature-section-create');
        $validator = Validator::make($request->all(), [
            'title'       => 'required',
            'slug'        => 'required',
            'filter'      => 'required|in:most_liked,most_viewed,price_criteria,category_criteria',
            'style'       => 'required|in:style_1,style_2,style_3,style_4',
            'min_price'   => 'required_if:filter,price_criteria',
            'max_price'   => 'required_if:filter,price_criteria',
            'category_id' => 'required_if:filter,category_criteria',
        ]);
        if ($validator->fails()) {
            ResponseService::validationError($validator->errors()->first());
        }

        try {
            $data = [
                ...$request->all(),
                'sequence' => FeatureSection::max('sequence') + 1
            ];

            if ($request->filter == "price_criteria") {
                $data['min_price'] = $request->min_price;
                $data['max_price'] = $request->max_price;
            }

            if ($request->filter == "category_criteria") {
                $data['value'] = !empty($request->category_id) ? implode(',', $request->category_id) : '';
            }
            FeatureSection::create($data);
            ResponseService::successResponse('Feature Section Added Successfully');
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, "FeaturedSection Controller -> store");
            ResponseService::errorResponse();
        }

    }

    public function show(Request $request) {
        ResponseService::noPermissionThenSendJson('feature-section-list');
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $sort = $request->input('sort', 'sequence');
        $order = $request->input('order', 'ASC');
        $sql = FeatureSection::with('category');
        if (!empty($request->search)) {
            $sql = $sql->search($request->search);
        }

        $total = $sql->count();
        $sql->orderBy($sort, $order)->skip($offset)->take($limit);
        $result = $sql->get();
        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        foreach ($result as $row) {
            $tempRow = $row->toArray();
            $operate = '';
            if (Auth::user()->can('feature-section-update')) {
                $operate .= BootstrapTableService::editButton(route('feature-section.update', $row->id), true);
            }

            if (Auth::user()->can('feature-section-delete')) {
                $operate .= BootstrapTableService::deleteButton(route('feature-section.destroy', $row->id));
            }
            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
        }
        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }

    public function update(Request $request, $id) {
        ResponseService::noPermissionThenSendJson('feature-section-update');
        $validator = Validator::make($request->all(), [
            'title'       => 'required',
            'slug'        => 'required',
            'filter'      => 'required|in:most_liked,most_viewed,price_criteria,category_criteria',
            'style'       => 'required|in:style_1,style_2,style_3,style_4',
            'min_price'   => 'required_if:filter,price_criteria',
            'max_price'   => 'required_if:filter,price_criteria',
            'category_id' => 'required_if:filter,category_criteria',
        ]);
        if ($validator->fails()) {
            ResponseService::validationError($validator->errors()->first());
        }
        try {
            $feature_section = FeatureSection::findOrFail($id);
            $data = $request->all();
            if ($request->filter == "price_criteria") {
                $data['min_price'] = $request->min_price;
                $data['max_price'] = $request->max_price;
            } else {
                $data['min_price'] = null;
                $data['max_price'] = null;
            }

            if ($request->filter == "category_criteria") {
                $data['value'] = !empty($request->category_id) ? implode(',', $request->category_id) : '';
            } else {
                $data['value'] = null;
            }
            $feature_section->update($data);
            ResponseService::successResponse('Feature Section Updated Successfully');
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, "FeaturedSection Controller -> update");
            ResponseService::errorResponse();
        }
    }

    public function destroy($id) {
        try {
            ResponseService::noPermissionThenSendJson('feature-section-delete');
            FeatureSection::findOrFail($id)->delete();
            ResponseService::successResponse('Feature Section delete successfully');
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, "FeaturedSection Controller -> destroy");
            ResponseService::errorResponse('Something Went Wrong');
        }
    }
}
