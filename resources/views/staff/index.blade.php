@extends('layouts.main')

@section('title')
    {{__("Staff Management")}}
@endsection

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            {{__('Staff Management')}}
        </h3>
        @can('role-create')
            <div class="buttons">
                <a class="btn btn-primary" href="{{ route('staff.create') }}"> {{ __('Create New Staff') }}</a>
            </div>
        @endcan
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-12">
                        <table class="table table-borderless table-striped" aria-describedby="mydesc"
                               id="table_list" data-toggle="table" data-url="{{ route('staff.show',1) }}" data-click-to-select="true"
                               data-side-pagination="server" data-pagination="true"
                               data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-toolbar="#toolbar"
                               data-show-columns="true" data-show-refresh="true" data-fixed-columns="true"
                               data-fixed-number="1" data-fixed-right-number="1" data-trim-on-search="false"
                               data-responsive="true" data-sort-name="id" data-sort-order="desc"
                               data-pagination-successively-size="3" data-query-params="queryParams"
                               data-escape="true"
                               data-show-export="true" data-export-options='{"fileName": "staff-list","ignoreColumn": ["operate"]}' data-export-types="['pdf','json', 'xml', 'csv', 'txt', 'sql', 'doc', 'excel']"
                               data-table="users" data-status-column="deleted_at" data-mobile-responsive="true">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" data-field="id" data-sortable="true" data-align="center">{{__("ID")}}</th>
                                <th scope="col" data-field="name" data-sortable="true" data-align="center">{{__("Name")}}</th>
                                <th scope="col" data-field="email" data-sortable="true" data-align="center">{{__("Email")}}</th>
                                @can('staff-update')
                                    <th scope="col" data-field="status" data-formatter="statusSwitchFormatter" data-sortable="false" data-align="center">{{__("Status")}}</th>
                                @endcan
                                @canany(['staff-update','staff-delete'])
                                    <th scope="col" data-field="operate" data-escape="false" data-sortable="false" data-events="staffEvents" data-align="center">{{__("Action")}}</th>
                                @endcanany
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @can('staff-update')
        <!-- EDIT USER MODEL MODEL -->
        <div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">{{__("Edit Staff")}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="form-horizontal edit-form" method="POST" data-parsley-validate>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group mandatory">
                                        <label for="edit_role" class="form-label col-12 ">{{__("Role")}}</label>
                                        <select name="role_id" id="edit_role" class="form-control" data-parsley-required="true">
                                            <option value="">--{{__("Select Role")}}--</option>
                                            @foreach ($roles as $role)
                                                <option value="{{$role->id}}">{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 col-12">
                                    <div class="form-group mandatory">
                                        <label for="edit_name" class="form-label text-center">{{__("Name")}}</label>
                                        <input type="text" id="edit_name" class="form-control col-12" placeholder="Name" name="name" data-parsley-required="true">
                                    </div>
                                </div>

                                <div class="col-md-12 col-12">
                                    <div class="form-group mandatory">
                                        <label for="edit_email" class="form-label text-center">{{__("Email")}}</label>
                                        <input type="email" id="edit_email" class="form-control col-12" placeholder="email" name="email" data-parsley-required="true">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">{{__("Close")}}</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">{{__("Save")}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- RESET PASSWORD MODEL -->
        <div id="resetPasswordModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">{{__("Password Reset")}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="form-horizontal edit-form" data-parsley-validate role="form" method="post">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group mandatory">
                                    <label for="new_password" class="form-label">{{__("New Password")}}</label>
                                    <input type="password" class="form-control" name="new_password" id="new_password" placeholder="New password" data-parsley-minlength="8" data-parsley-uppercase="1" data-parsley-lowercase="1" data-parsley-number="1" data-parsley-special="1" data-parsley-required="true">
                                </div>
                                <div class="form-group mandatory">
                                    <label for="confirm_password" class="form-label">{{__("Confirm Password")}}</label>
                                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm password" data-parsley-equalto="#new_password" minlength="4" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">{{__("Close")}}</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">{{__("Save")}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
@endsection
