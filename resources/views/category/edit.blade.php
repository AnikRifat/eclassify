@extends('layouts.main')
@section('title')
    {{__("Edit Categories")}}
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
            <a class="btn btn-primary" href="{{ route('category.index') }}">< {{__("Back to All Categories")}} </a>
        </div>
        <div class="row">
            <form action="{{ route('category.update', $category_data->id) }}" method="POST" data-parsley-validate enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <input type="hidden" name="edit_data" value={{ $category_data->id }}>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">{{__("Edit Categories")}}</div>
                        <div class="card-body mt-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="col-md-12 form-group mandatory">
                                        <label for="name" class="mandatory form-label">{{ __('Name') }}</label>
                                        <input type="text" name="name" id="name" class="form-control" data-parsley-required="true" value="{{ $category_data->name }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-12 form-group mandatory">
                                        <label for="p_category" class="mandatory form-label">{{ __('Parent Category') }}</label>
                                        <select name="selected_category" class="form-select form-control" id="p_category" data-placeholder="{{__("Select Category")}}">
                                            <option value="{{ $parent_category }}" disabled id="default_opt" selected>{{ $parent_category == '' ? 'Root' : $parent_category }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-12 form-group mandatory">
                                        <label for="slug" class="form-label">{{ __('Slug') }} <small>(English
                                                Only)</small></label>
                                        <input type="text" name="slug" id="slug" class="form-control" data-parsley-required="true" value="{{ $category_data->slug }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="description" class="mandatory form-label">{{ __('Description') }}</label>
                                    <textarea name="description" id="description" class="form-control" cols="10" rows="5">{{ $category_data->description }}</textarea>
                                    <div class="form-check form-switch mt-3">
                                        <input type="hidden" name="status" id="status" value="{{ $category_data->status}}">
                                        <input class="form-check-input status-switch" type="checkbox" role="switch" aria-label="status" name="active" id="required" {{ $category_data->status == 1 ? 'checked' : '' }}>{{ __('Active') }}
                                        <label class="form-check-label" for="status"></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-12 form-group mandatory">
                                        <label for="Field Name" class="mandatory form-label">{{ __('Image') }}</label>
                                        <div class="cs_field_img ">
                                            <input type="file" name="image" class="image" style="display: none" accept=" .jpg, .jpeg, .png, .svg">
                                            <img src="{{ empty($category_data->image) ? asset('assets/img_placeholder.jpeg') : $category_data->image }}" alt="" class="img preview-image" id="">
                                            <div class='img_input'>{{__("Browse File")}}</div>
                                        </div>
                                        <div class="input_hint"> {{__("Icon (use 256 x 256 size for better view)")}}</div>
                                        <div class="img_error" style="color:#DC3545;"></div>
                                    </div>
                                </div>

                            </div>
                            @foreach($languages as $key=>$language)
                                <hr>
                                <h5>{{__("Translation")}}</h5>
                                <div class="row">

                                    <hr>
                                    <h5>{{($key+1).". ".$language->name}}</h5>
                                    <div class="col-md-12 form-group">
                                        <label for="name" class="form-label">{{ __('Name') }} : </label>
                                        <input name="translations[{{$language->id}}]" id="name" class="form-control" value="{{ $translations[$language->id] ?? '' }}" required>
                                    </div>
                                </div>
                            @endforeach
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
