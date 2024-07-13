<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\BootstrapTableService;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Throwable;

class StaffController extends Controller {

    public function index() {
        ResponseService::noAnyPermissionThenRedirect(['staff-list', 'staff-create', 'staff-update', 'staff-delete']);
        $roles = Role::where('custom_role', 1)->get();
        return view('staff.index', compact('roles'));
    }

    public function create() {
        ResponseService::noPermissionThenRedirect('staff-create');
        $roles = Role::where('custom_role', 1)->get();
        return view('staff.create', compact('roles'));
    }

    public function store(Request $request) {
        ResponseService::noPermissionThenRedirect('staff-create');
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required',
            'role'     => 'required'
        ]);

        if ($validator->fails()) {
            ResponseService::validationError($validator->errors()->first());
        }
        try {
            DB::beginTransaction();
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $user->syncRoles($request->role);
            DB::commit();
            ResponseService::successResponse('User created Successfully');
        } catch (Throwable $th) {
            DB::rollBack();
            ResponseService::logErrorResponse($th, "StaffController --> store");
            ResponseService::errorResponse();
        }
    }


    public function update(Request $request, $id) {
        ResponseService::noPermissionThenRedirect('staff-edit');
        $validator = Validator::make($request->all(), [
            'name'    => 'required',
            'email'   => 'required|email|unique:users,email,' . $id,
            'role_id' => 'required'
        ]);
        if ($validator->fails()) {
            ResponseService::validationError($validator->errors()->first());
        }
        try {
            DB::beginTransaction();
            $user = User::withTrashed()->findOrFail($id);
            $user->update([
                ...$request->all()
            ]);

            $oldRole = $user->roles;
            if ($oldRole[0]->id !== $request->role_id) {
                $newRole = Role::findById($request->role_id);
                $user->removeRole($oldRole[0]);
                $user->assignRole($newRole);
            }

            DB::commit();
            ResponseService::successResponse('User Update Successfully');
        } catch (Throwable $th) {
            DB::rollBack();
            ResponseService::logErrorResponse($th, "StaffController --> update");
            ResponseService::errorResponse();
        }
    }

    public function show(Request $request) {
        ResponseService::noPermissionThenRedirect('staff-list');
        $offset = $request->offset ?? 0;
        $limit = $request->limit ?? 10;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'DESC';

        $sql = User::withTrashed()->with('roles')->orderBy($sort, $order)->whereHas('roles', function ($q) {
            $q->where('custom_role', 1);
        });

        if (!empty($request->search)) {
            $sql->search($request->search);
        }
        $total = $sql->count();
        $sql->skip($offset)->take($limit);
        $result = $sql->get();
        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        foreach ($result as $key => $row) {
            $operate = '';
            if (Auth::user()->can('staff-update')) {
                $operate .= BootstrapTableService::editButton(route('staff.update', $row->id), true);
                $operate .= BootstrapTableService::editButton(route('staff.change-password', $row->id), true, '#resetPasswordModel', null, $row->id, 'bi bi-key');
            }

            if (Auth::user()->can('staff-delete')) {
                $operate .= BootstrapTableService::deleteButton(route('staff.destroy', $row->id));
            }

            $tempRow = $row->toArray();
            $tempRow['status'] = empty($row->deleted_at);
            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }

    public function destroy($id) {
        try {
            ResponseService::noPermissionThenSendJson('staff-delete');
            User::withTrashed()->findOrFail($id)->forceDelete();
            ResponseService::successResponse('User Delete Successfully');
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, "StaffController --> delete");
            ResponseService::errorResponse();
        }
    }


    public function changePassword(Request $request, $id) {
        ResponseService::noPermissionThenRedirect('staff-edit');
        $validator = Validator::make($request->all(), [
            'new_password'     => 'required|min:8',
            'confirm_password' => 'required|same:new_password'
        ]);
        if ($validator->fails()) {
            ResponseService::validationError($validator->errors()->first());
        }
        try {
            User::findOrFail($id)->update(['password' => Hash::make($request->confirm_password)]);
            ResponseService::successResponse('Password Reset Successfully');
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, "StaffController -> changePassword");
            ResponseService::errorResponse();
        }

    }
}
