@extends('layouts.main')

@section('title')
    {{__("Firebase Settings")}}
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
        <div class="card">
            <form class="create-form-without-reset" action="{{ route('settings.firebase.update') }}" method="POST">
                <div class="card-body">
                    <div class="row mt-1">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="apiKey" class="col-sm-2 col-form-label text-center">{{__("Api Key")}}</label>
                                <div class="col-sm-4">
                                    <input name="apiKey" type="text" class="form-control" placeholder="{{__("Api Key")}}" id="apiKey" value="{{ $settings['apiKey'] ?? '' }}" required="">
                                </div>

                                <label for="authDomain" class="col-sm-2 col-form-label text-center">{{__("Auth Domain")}}</label>
                                <div class="col-sm-4">
                                    <input required name="authDomain" type="text" class="form-control" placeholder="{{__("Auth Domain")}}" id="authDomain" value="{{ $settings['authDomain'] ?? '' }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="projectId" class="col-sm-2 col-form-label text-center">{{__("Project Id")}}</label>
                                <div class="col-sm-4">
                                    <input name="projectId" type="text" class="form-control" placeholder="{{__("Project Id")}}" id="projectId" value="{{ $settings['projectId'] ?? '' }}" required="">
                                </div>
                                <label for="storageBucket" class="col-sm-2 col-form-label text-center">{{__("Storage Bucket")}}</label>
                                <div class="col-sm-4">
                                    <input name="storageBucket" type="text" class="form-control" id="storageBucket" placeholder="{{__("Storage Buckets")}}" value="{{ $settings['storageBucket'] ?? '' }}" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="messagingSenderId" class="col-sm-2 col-form-label text-center">{{__("Messaging Sender Id")}}</label>
                                <div class="col-sm-4">
                                    <input name="messagingSenderId" type="text" class="form-control" placeholder="{{__("Messaging Sender Id")}}" id="messagingSenderId" value="{{ $settings['messagingSenderId'] ?? '' }}" required="">
                                </div>
                                <label for="appId" class="col-sm-2 col-form-label text-center">{{__("App Id")}}</label>
                                <div class="col-sm-4">
                                    <input name="appId" id="appId" type="text" class="form-control" placeholder="{{__("App Id")}}" value="{{ $settings['appId'] ?? '' }}" required="">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label for="measurementId" class="col-sm-2 col-form-label text-center">{{__("Measurement Id")}}</label>
                                <div class="col-sm-4">
                                    <input name="measurementId" type="text" class="form-control" id="measurementId" placeholder="{{__("Measurement Id")}}" value="{{ $settings['measurementId'] ?? '' }}" required="">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" value="btnAdd" class="btn btn-primary me-1 mb-1">{{__("Save")}}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
