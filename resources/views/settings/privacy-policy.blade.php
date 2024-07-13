@extends('layouts.main')
@section('title')
    {{ __('Privacy Policy') }}
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
            <form action="{{ route('settings.store')}}" method="post" class="create-form-without-reset">
                @csrf
                <div class="card-body">
                    <div class="row form-group">
                        <div class="col-2 d-flex justify-content-end">
                            <a href="{{ route('public.privacy-policy') }}" target="_blank" class="col-sm-12 col-md-12 d-fluid btn icon btn-primary btn-sm rounded-pill" onclick="" title="Enable">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                        </div>
                        <div class="col-md-12 mt-3">
                            <textarea id="tinymce_editor" name="privacy_policy" class="form-control col-md-7 col-xs-12" aria-label="tinymce_editor">{{ $settings['privacy_policy'] }}</textarea>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <button class="btn btn-primary me-1 mb-1" type="submit" name="submit">{{ __('Save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
