@extends('layouts.main')

@section('title')
    {{ __('Change Password') }}
@endsection
@section('content')
    <section class="section col-sm-6 col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="divider">
                    <div class="divider-text">
                        <h4 class="mb-0">{{ __('Change Password') }}</h4>
                    </div>
                </div>
            </div>
            <div class="card-content">
                {!! Form::open(['url' => route('change-password.update'),'data-parsley-validate','class' => 'create-form','data-parsley-validate']) !!}
                <div class="row mt-1">
                    <div class="card-body">
                        <label for="old_password" class="form-label">{{ __('Current Password')}}</label>
                        <div class="form-group position-relative has-icon-right mb-4 mandatory">
                            <input type="password" name="old_password" id="old_password" class="form-control form-control-solid mb-2" value="" placeholder="{{__("Current Password")}}" required/>
                            <div class="form-control-icon lh-1 top-0 mt-2">
                                <i class="bi bi-eye toggle-password"></i>
                            </div>
                        </div>
                        <label for="new_password" class="form-label">{{ __('New Password')}}</label>
                        <div class="form-group position-relative has-icon-right mb-4 mandatory">
                            <input type="password" name="new_password" id="new_password" class="form-control form-control-solid" value="" placeholder="{{__("New Password")}}" data-parsley-minlength="8" data-parsley-uppercase="1" data-parsley-lowercase="1" data-parsley-number="1" data-parsley-special="1" data-parsley-required/>
                            <div class="form-control-icon lh-1 top-0 mt-2">
                                <i class="bi bi-eye toggle-password"></i>
                            </div>
                        </div>
                        <label for="confirm_password" class="form-label">{{ __('Confirm Password')}}</label>
                        <div class="form-group position-relative has-icon-right mb-4 mandatory">
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control form-control-solid" value="" placeholder="{{__("Confirm Password")}}" data-parsley-equalto="#new_password" required/>
                            <div class="form-control-icon lh-1 top-0 mt-2">
                                <i class="bi bi-eye toggle-password"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 text-end">
                                <button type="submit" class="btn btn-primary float-right">{{ __('Change') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection
