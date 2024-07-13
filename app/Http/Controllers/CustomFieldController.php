<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CustomField;
use App\Models\CustomFieldCategory;
use App\Services\BootstrapTableService;
use App\Services\FileService;
use App\Services\HelperService;
use App\Services\ResponseService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;


class CustomFieldController extends Controller {

    private string $uploadFolder;

    public function __construct() {
        $this->uploadFolder = 'custom-fields';
    }

    public function index() {
        ResponseService::noAnyPermissionThenRedirect(['custom-field-list', 'custom-field-create', 'custom-field-update', 'custom-field-delete']);
        $categories = Category::get();
        return view('custom-fields.index', compact('categories'));
    }

    public function create(Request $request) {
        ResponseService::noPermissionThenRedirect('custom-field-create');
        $cat_id = $request->id ?? 0;
        $categories = HelperService::buildNestedChildSubcategoryObject(Category::get());
        return view("custom-fields.create", compact('categories', 'cat_id'));
    }

    public function store(Request $request) {
        ResponseService::noPermissionThenSendJson('custom-field-create');
        $validator = Validator::make($request->all(), [
            'name'       => 'required',
            'type'       => 'required|in:number,textbox,fileinput,radio,dropdown,checkbox',
            'image'      => 'required',
            'required'   => 'required',
            'status'     => 'required',
            'values'     => 'required_if:type,radio,dropdown,checkbox|array',
            'min_length' => 'required_if:number,textbox',
            'max_length' => 'required_if:number,textbox',
        ]);

        if ($validator->fails()) {
            ResponseService::validationError($validator->errors()->first());
        }

        try {
            DB::beginTransaction();
            $data = [
                ...$request->all(),
                'image' => $request->hasFile('image') ? FileService::compressAndUpload($request->file('image'), $this->uploadFolder) : '',
            ];

            if (in_array($request->type, ["dropdown", "radio", "checkbox"])) {
                $data['values'] = json_encode($request->values, JSON_THROW_ON_ERROR);
            }

            $customField = CustomField::create($data);
            $customFieldCategory = [];
            if (!empty($request->selected_categories)) {
                foreach ($request->selected_categories as $category_id) {
                    $customFieldCategory[] = [
                        'category_id'     => $category_id,
                        'custom_field_id' => $customField->id
                    ];
                }

                CustomFieldCategory::upsert($customFieldCategory, $customFieldCategory);
            }
            DB::commit();
            ResponseService::successResponse('Custom Field Added Successfully');
        } catch (Throwable $th) {
            DB::rollBack();
            ResponseService::logErrorResponse($th);
            ResponseService::errorResponse('Something Went Wrong');
        }
    }

    public function show(Request $request) {
        try {
            ResponseService::noPermissionThenSendJson('custom-field-list');
            $offset = $request->input('offset', 0);
            $limit = $request->input('limit', 15);
            $sort = $request->input('sort', 'id');
            $order = $request->input('order', 'DESC');

            $sql = CustomField::orderBy($sort, $order)->skip($offset)->take($limit);
            $sql->with('categories:id,name');
            if (!empty($request->filter)) {
                $sql = $sql->filter(json_decode($request->filter, false, 512, JSON_THROW_ON_ERROR));
            }

            if (!empty($request->search)) {
                $sql = $sql->search($request->search);
            }
            $total = $sql->count();
            $result = $sql->get();
            $bulkData = array();
            $bulkData['total'] = $total;
            $rows = array();

            foreach ($result as $key => $row) {
                $operate = '';
                if (Auth::user()->can('custom-field-update')) {
                    $operate .= BootstrapTableService::editButton(route('custom-fields.edit', $row->id));
                }

                if (Auth::user()->can('custom-field-delete')) {
                    $operate .= BootstrapTableService::deleteButton(route('custom-fields.destroy', $row->id));
                }
                $tempRow = $row->toArray();
                $tempRow['operate'] = $operate;
                $tempRow['category_names'] = array_column($row->categories->toArray(), 'name');
                $rows[] = $tempRow;
            }
            $bulkData['rows'] = $rows;


            return response()->json($bulkData);
        } catch (Throwable $e) {
            ResponseService::logErrorResponse($e, "CustomFieldController -> show");
            ResponseService::errorResponse('Something Went Wrong');
        }

    }

    public function edit($id) {
        ResponseService::noPermissionThenRedirect('custom-field-update');
        $custom_field = CustomField::with('custom_field_category')->findOrFail($id);
        $selected_categories = $custom_field->custom_field_category->pluck('category_id')->toArray();
        $categories = HelperService::buildNestedChildSubcategoryObject(Category::get());
        return view('custom-fields.edit', compact('custom_field', 'categories', 'selected_categories'));
    }

    public function update(Request $request, $id) {
        ResponseService::noPermissionThenSendJson('custom-field-update');
        $validator = Validator::make($request->all(), [
            'name'       => 'required',
            'type'       => 'required|in:number,textbox,fileinput,radio,dropdown,checkbox',
            'image'      => 'nullable',
            'required'   => 'required',
            'status'     => 'required',
            'values'     => 'required_if:type,radio,dropdown,checkbox|array',
            'min_length' => 'required_if:number,textbox',
            'max_length' => 'required_if:number,textbox',
        ]);
        if ($validator->fails()) {
            ResponseService::validationError($validator->errors()->first());
        }
        try {
            DB::beginTransaction();
            $custom_fields = CustomField::with('custom_field_category')->findOrFail($id);
            $data = $request->all();

            if ($request->hasFile('image')) {
                $data['image'] = FileService::compressAndReplace($request->file('image'), $this->uploadFolder, $custom_fields->getRawOriginal('image'));
            }

            $custom_fields->update($data);

            $old_selected_category = $custom_fields->custom_field_category->pluck('category_id')->toArray();
            $new_selected_category = $request->selected_categories;

            // If category exists in old category array but not in new category array then we need to delete that category
            if ($new_selected_category) {
                foreach (array_diff($old_selected_category, $new_selected_category) as $category_id) {
                    $custom_fields->custom_field_category->first(function ($data) use ($category_id) {
                        return $data->category_id == $category_id;
                    })->delete();
                }

                $newSelectedCategory = [];
                //If category exists in new category array but not existing in old category array then we need to add that category
                foreach (array_diff($new_selected_category, $old_selected_category) as $category_id) {
                    $newSelectedCategory[] = [
                        'category_id'     => $category_id,
                        'custom_field_id' => $id,
                        'created_at'      => time(),
                        'updated_at'      => time(),
                    ];
                }

                if (count($newSelectedCategory) > 0) {
                    CustomFieldCategory::insert($newSelectedCategory);
                }
            }


            DB::commit();
            ResponseService::successResponse("Custom Fields Updated Successfully");
        } catch (Throwable $th) {
            DB::rollBack();
            ResponseService::logErrorResponse($th, "CustomField Controller -> update ");
            ResponseService::errorResponse('Something Went Wrong ');
        }
    }

    public function destroy($id) {
        try {
            ResponseService::noPermissionThenSendJson('custom-field-delete');
            CustomField::find($id)->delete();
            ResponseService::successResponse('Custom Field delete successfully');
        } catch (QueryException $th) {
            ResponseService::logErrorResponse($th, "Custom Field Controller -> destroy");
            ResponseService::errorResponse('Cannot delete custom field! Remove associated subcategories first');
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, "Custom Field Controller -> destroy");
            ResponseService::errorResponse('Something Went Wrong');
        }
    }

    public function getCustomFieldValues(Request $request, $id) {
        ResponseService::noPermissionThenSendJson('custom-field-update');
        $values = CustomField::findOrFail($id)->values;

        if (!empty($request->search)) {
            $matchingElements = [];
            foreach ($values as $element) {
                // Convert the element to a string for easy searching
                $stringElement = (string)$element;

                // Check if the search term is present in the element
                if (str_contains($stringElement, $request->search)) {
                    // If found, add it to the matching elements array
                    $matchingElements[] = $element;
                }
            }
            $values = $matchingElements;
        }


        $bulkData = array();
        $bulkData['total'] = count($values);
        $rows = array();
        foreach ($values as $key => $row) {
            $tempRow['id'] = $key;
            $tempRow['value'] = $row;
            $tempRow['operate'] = BootstrapTableService::editButton(route('custom-fields.value.update', $id), true);
            $tempRow['operate'] .= BootstrapTableService::deleteButton(route('custom-fields.value.delete', [$id, $row]), true);
            $rows[] = $tempRow;
        }
        $bulkData['rows'] = $rows;


        return response()->json($bulkData);
    }

    public function addCustomFieldValue(Request $request, $id) {
        ResponseService::noPermissionThenSendJson('custom-field-create');
        $validator = Validator::make($request->all(), [
            'values' => 'required',
        ]);

        if ($validator->fails()) {
            ResponseService::errorResponse($validator->errors()->first());
        }
        try {
            $customField = CustomField::findOrFail($id);
            $newValues = explode(',', $request->values);
            $values = [
                ...$customField->values,
                ...$newValues,
            ];

            $customField->values = json_encode($values, JSON_THROW_ON_ERROR);
            $customField->save();
            ResponseService::successResponse('Custom Field Value added Successfully');
        } catch (Throwable) {
            ResponseService::errorResponse('Something Went Wrong ');
        }
    }

    public function updateCustomFieldValue(Request $request, $id) {
        ResponseService::noPermissionThenSendJson('custom-field-update');
        $validator = Validator::make($request->all(), [
            'old_custom_field_value' => 'required',
            'new_custom_field_value' => 'required',
        ]);

        if ($validator->fails()) {
            ResponseService::errorResponse($validator->errors()->first());
        }
        try {
            $customField = CustomField::findOrFail($id);
            $values = $customField->values;
            if (is_array($values)) {
                $values[array_search($request->old_custom_field_value, $values, true)] = $request->new_custom_field_value;
            } else {
                $values = $request->new_custom_field_value;
            }
            $customField->values = $values;
            $customField->save();
            ResponseService::successResponse('Custom Field Value Updated Successfully');
        } catch (Throwable) {
            ResponseService::errorResponse('Something Went Wrong ');
        }
    }

    public function deleteCustomFieldValue($id, $deletedValue) {
        try {
            ResponseService::noPermissionThenSendJson('custom-field-delete');
            $customField = CustomField::findOrFail($id);
            $values = $customField->values;
            unset($values[array_search($deletedValue, $values, true)]);
            $customField->values = json_encode($values, JSON_THROW_ON_ERROR);
            $customField->save();
            ResponseService::successResponse('Custom Field Value Deleted Successfully');
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th);
            ResponseService::errorResponse('Something Went Wrong');
        }
    }


}
