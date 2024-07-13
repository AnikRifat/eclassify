@extends('layouts.main')
@section('title')
    {{__("Create Blogs")}}
@endsection

@section('page-title')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h4>@yield('title')</h4>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="section">
        <div class="buttons">
            <a class="btn btn-primary" href="{{ route('blog.index') }}">< {{__("Back to Blogs")}} </a>
        </div>
        <div class="row">
            <form action="{{ route('blog.store') }}" class="form-redirection" method="POST" data-parsley-validate enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">{{__("Add Blog")}}</div>
                    <div class="card-body mt-3">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group mandatory">
                                    <label for="title" class="mandatory form-label">{{ __('Title') }}</label>
                                    <input type="text" name="title" id="title" class="form-control" data-parsley-required="true">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group mandatory">
                                    <label for="slug" class="form-label">{{ __('Slug') }} <small>(English Only)</small></label>
                                    <input type="text" name="slug" id="slug" class="form-control" data-parsley-required="true">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group mandatory">
                                    <label for="Field Name" class="mandatory form-label">{{ __('Image') }}</label>
                                    <input type="file" name="image" id="image" class="form-control" data-parsley-required="true" accept=".jpg,.jpeg,.png">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mandatory">
                                    <label for="tags" class="mandatory form-label">{{ __('Tags') }}</label>
                                    <select id="tags" name="tags[]" data-tags="true" data-placeholder="{{__("Tags")}}" data-allow-clear="true" class="select2 col-12 w-100" multiple="multiple" data-parsley-required="true" required></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <label for="tinymce_editor" class="mandatory form-label">{{ __('Description') }}</label>
                            <textarea name="description" id="tinymce_editor" class="form-control" cols="10" rows="5"></textarea>
                        </div>

                    </div>
                </div>
                <div class="col-md-12 text-end">
                    <input type="submit" class="btn btn-primary" value="{{__("Save and Back")}}">
                </div>
            </form>
        </div>
    </section>
@endsection
