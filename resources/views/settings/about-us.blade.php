@extends('layouts.main')

@section('title')
    {{ __('About Us') }}
@endsection

@section('page-title')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h4>@yield('title')</h4>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">

            </div>
        </div>
    </div>
@endsection
@section('content')
    <section class="section">
        <div class="card">
            <form action="{{ route('settings.store') }}" method="post" class="create-form-without-reset">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <textarea id="tinymce_editor" name="about_us" class="form-control col-md-7 col-xs-12" aria-label="tinymce_editor">{{ $settings["about_us"] ??'' }}</textarea>
                        </div>
                    </div>
                    <div class="col-12 mt-2 d-flex justify-content-end">
                        <button class="btn btn-primary me-1 mb-1" type="submit" name="submit">{{ __('Save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
