@extends('layouts.main')

@section('title')
    {{__("Create Staff")}}
@endsection

@section('page-title')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h4>@yield('title')</h4>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first"></div>
        </div>
    </div>
@endsection

@section('content')
    <section class="section">
        <div class="d-flex justify-content-end mb-2">
            <a class="btn btn-primary" href="{{ route('staff.index') }}"> {{ __('Back') }}</a>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <form action="{{ route('staff.store') }}" class="form-horizontal create-form" method="POST" data-parsley-validate>
                        <div class="col-md-12 col-12">
                            <div class="row">
                                <div class="form-group mandatory col-md-6 col-sm-12">
                                    <label for="role" class="form-label col-12 ">{{__("Role")}}</label>
                                    <select name="role" id="role" class="form-control" data-parsley-required="true">
                                        <option value="">--{{__("Select Role")}}--</option>
                                        @foreach ($roles as $role)
                                            <option value="{{$role->name}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mandatory col-md-6 col-sm-12">
                                    <label for="name" class="form-label col-12 ">{{__("Name")}}</label>
                                    <input type="text" id="name" class="form-control col-12" placeholder="Name" name="name" data-parsley-required="true">
                                </div>

                                <div class="form-group mandatory col-md-6 col-sm-12">
                                    <label for="email" class="form-label col-12 ">{{__("Email")}}</label>
                                    <input type="email" id="email" class="form-control col-12" placeholder="Email" name="email" data-parsley-required="true">
                                </div>

                                <div class="form-group mandatory col-md-6 col-sm-12">
                                    <label for="password" class="form-label col-12 ">{{__("Password")}}</label>
                                    <input type="password" id="password" class="form-control col-12" placeholder="Password" name="password" data-parsley-minlength="8" data-parsley-uppercase="1" data-parsley-lowercase="1" data-parsley-number="1" data-parsley-special="1" data-parsley-required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">{{__("Save")}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
