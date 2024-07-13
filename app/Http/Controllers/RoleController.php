<?php

namespace App\Http\Controllers;

use App\Services\BootstrapTableService;
use App\Services\ResponseService;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Throwable;

class RoleController extends Controller {

    /**
     * @var array|string[]
     */
    private array $reserveRole;

    public function __construct() {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);

        $this->reserveRole = [
            'Super Admin',
            'User'
        ];
    }


    public function index() {
        ResponseService::noAnyPermissionThenRedirect(['role-list', 'role-create', 'role-edit', 'role-delete']);
        $roles = Role::orderBy('id', 'DESC')->get();
        return view('roles.index', compact('roles'));
    }

    public function list(Request $request) {
        ResponseService::noPermissionThenRedirect('role-list');
        $offset = request('offset', 0);
        $limit = request('limit', 10);
        $sort = request('sort', 'id');
        $order = request('order', 'DESC');

        $sql = Role::where('custom_role', 1);

        if (!empty($request->search)) {
            $search = $request->search;
            $sql->where(function ($query) use ($search) {
                $query->where('id', 'LIKE', "%$search%")->orwhere('name', 'LIKE', "%$search%");
            });
        }

        $total = $sql->count();

        $sql->orderBy($sort, $order)->skip($offset)->take($limit);
        $res = $sql->get();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $no = 1;
        foreach ($res as $row) {
            $operate = BootstrapTableService::button('fa fa-eye', route('roles.show', $row->id), ['btn-info'], ['title' => 'View']);
            if (Auth::user()->can('role-edit')) {
                $operate .= BootstrapTableService::editButton(route('roles.edit', $row->id), false);
            }
            if ($row->custom_role != 0 && Auth::user()->can('role-delete')) {
                $operate .= BootstrapTableService::deleteButton(route('roles.destroy', $row->id));
            }

            $tempRow = $row->toArray();
            $tempRow['no'] = $no++;
            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }


    public function create() {
        ResponseService::noPermissionThenRedirect('role-create');
        $permission = Permission::get();
        $groupedPermissions = [];

        foreach ($permission as $key => $val) {
            $subArr = substr($val->name, 0, strrpos($val->name, "-"));
            $groupedPermissions[$subArr][] = (object)array(
                ...$val->toArray(),
                'short_name' => str_replace($subArr . "-", "", $val->name)
            );
        }

        $groupedPermissions = (object)$groupedPermissions;
        return view('roles.create', compact('groupedPermissions'));
    }

    public function store(Request $request) {
        ResponseService::noPermissionThenRedirect('role-create');
        $validator = Validator::make($request->all(), [
            'name'       => 'required|unique:roles,name',
            'permission' => 'required|array'
        ]);
        if ($validator->fails()) {
            ResponseService::validationError($validator->errors()->first());
        }
        try {

            if (in_array($request->name, $this->reserveRole, true)) {
                ResponseService::errorResponse($request->name . " " . trans("is not a valid Role name Because it's Reserved Role"));
            }
            DB::beginTransaction();
            $role = Role::create(['name' => $request->input('name'), 'custom_role' => 1]);
            $role->syncPermissions($request->input('permission'));
            DB::commit();
            ResponseService::successResponse(trans('Role created Successfully'));
        } catch (Throwable $e) {
            DB::rollBack();
            ResponseService::logErrorResponse($e, "Role Controller -> store");
            ResponseService::errorResponse();
        }
    }


    public function show($id) {
        ResponseService::noPermissionThenRedirect('role-list');
        $role = Role::findOrFail($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")->where("role_has_permissions.role_id", $id)->get();

        return view('roles.show', compact('role', 'rolePermissions'));

    }


    public function edit($id) {
        ResponseService::noPermissionThenRedirect('role-edit');
        $role = Role::findOrFail($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')->all();
        $groupedPermissions = [];
        foreach ($permission as $key => $val) {
            $subArr = substr($val->name, 0, strrpos($val->name, "-"));
            $groupedPermissions[$subArr][] = (object)array(
                ...$val->toArray(),
                'short_name' => str_replace($subArr . "-", "", $val->name)
            );
        }

        $groupedPermissions = (object)$groupedPermissions;
        return view('roles.edit', compact('role', 'groupedPermissions', 'rolePermissions'));
    }


    public function update(Request $request, $id) {
        ResponseService::noPermissionThenRedirect('role-edit');
        $validator = Validator::make($request->all(), ['name' => 'required', 'permission' => 'required']);
        if ($validator->fails()) {
            ResponseService::validationError($validator->errors()->first());
        }
        try {
            DB::beginTransaction();
            if (in_array($request->name, $this->reserveRole, true)) {
                ResponseService::errorResponse($request->name . " " . trans("is not a valid Role name Because it's Reserved Role"));
            }
            $role = Role::findOrFail($id);
            $role->name = $request->input('name');
            $role->save();

            $role->syncPermissions($request->input('permission'));
            DB::commit();
            ResponseService::successResponse('Data Updated Successfully');
        } catch (Throwable $th) {
            DB::rollBack();
            ResponseService::logErrorResponse($th, "RoleController -> update");
            ResponseService::errorResponse();
        }
    }

    public function destroy($id) {
        try {
            ResponseService::noPermissionThenSendJson('role-delete');
            $role = Role::withCount('users')->findOrFail($id);
            if ($role->users_count) {
                ResponseService::errorResponse('cannot_delete_because_data_is_associated_with_other_data');
            } else {
                Role::findOrFail($id)->delete();
                ResponseService::successResponse('Data Deleted Successfully');
            }
        } catch (Throwable $e) {
            DB::rollBack();
            ResponseService::logErrorResponse($e);
            ResponseService::errorResponse();
        }
    }
}
