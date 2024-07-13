@extends('layouts.main')
@section('title')
    {{__("Edit Blogs")}}
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
            <a class="btn btn-primary" href="{{ route('blog.index') }}">< {{__("Back to All Blogs")}} </a>
        </div>
        <div class="row">
            <form action="{{ route('blog.update', $blog->id) }}" method="POST" data-parsley-validate enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <input type="hidden" name="edit_data" value={{ $blog->id }}>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">{{__("Edit Blogs")}}</div>
                        <div class="card-body mt-3">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="title" class="mandatory form-label">{{ __('Title') }}</label>
                                        <input type="text" name="title" id="title" class="form-control" data-parsley-required="true" value="{{ $blog->title }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="slug" class="form-label">{{ __('Slug') }} <small>(English Only)</small></label>
                                        <input type="text" name="slug" id="slug" class="form-control" data-parsley-required="true" value="{{$blog->slug}}">
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="Field Name" class="mandatory form-label">{{ __('Image') }}</label>
                                        <div class="cs_field_img ">
                                            <input type="file" name="image" class="image" style="display: none" accept=" .jpg, .jpeg, .png, .svg">
                                            <img src="{{ empty($blog->image) ? asset('assets/img_placeholder.jpeg') : $blog->image }}" alt="" class="img preview-image" id="">
                                            <div class='img_input'>{{__("Browse File")}}</div>
                                        </div>
                                        <div class="input_hint"> {{__("Icon (use 256 x 256 size for better view)")}}</div>
                                        <div class="img_error" style="color:#DC3545;"></div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group mandatory">
                                        <label for="tags" class="mandatory form-label">{{ __('Tags') }}</label>
                                        <select id="tags" name="tags[]" data-tags="true" data-placeholder="{{__("Tags")}}" data-allow-clear="true" class="select2 col-12 w-100" multiple="multiple" data-parsley-required="true">
                                            @foreach ($blog->tags as $tag)
                                                <option value="{{ $tag }}" selected>{{ $tag }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 col-12">
                                    <label for="tinymce_editor" class="mandatory form-label">{{ __('Description') }}</label>
                                    <textarea name="description" id="tinymce_editor" class="form-control" cols="10" rows="4">{{ $blog->description }}</textarea>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 text-end">
                        <input type="submit" class="btn btn-primary" value="{{__("Save and Back")}}">
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
@section('js')
    <script !src="">
        $('#category_id').val("{{$blog->category_id}}")
    </script>
@endsection
