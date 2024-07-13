@extends('layouts.main')

@section('title')
    {{ __('System Update') }}
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

            <form class="create-form" action="{{ route('system-update.index') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body">
                    <div class="row mt-1">
                        <div class="card-body">
                            <label class="col-sm-12 col-form-label text-center"><b>{{ __('System Version') }} : </b> <span class="text-danger">{{ $system_version['value'] ?? '1.0.0' }}</span></label>
                            <div class="form-group row mt-5">
                                <label for="purchase_code" class="col-sm-2 col-form-label text-center">{{ __('Purchase Code') }}</label>
                                <div class="col-sm-3">
                                    <input id="purchase_code" required name="purchase_code" type="text" class="form-control">
                                </div>

                                <label class="col-sm-2 col-form-label text-center">{{ __('Update File') }}</label>
                                <div class="col-sm-3">
                                    <input required name="file" type="file" class="form-control">
                                </div>
                                <div class="col-sm-2 d-flex justify-content-end">
                                    <button type="submit" name="btnAdd1" value="btnAdd" class="btn btn-primary me-1 mb-1">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
