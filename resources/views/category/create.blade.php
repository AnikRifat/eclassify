@extends('layouts.main')
@section('title')
    {{__("Create Categories")}}
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
            <form action="{{ route('category.store') }}" method="POST" data-parsley-validate enctype="multipart/form-data">
                @csrf
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">{{__("Add Category")}}</div>

                        <div class="card-body mt-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="col-md-12 form-group mandatory">
                                        <label for="category_name" class="mandatory form-label">{{ __('Name') }}</label>
                                        <input type="text" name="name" id="category_name" class="form-control" data-parsley-required="true">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-12 form-group mandatory">
                                        <label for="category_slug" class="form-label">{{ __('Slug') }} <small>(English Only)</small></label>
                                        <input type="text" name="slug" id="category_slug" class="form-control" data-parsley-required="true">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="col-md-12 form-group">
                                        <label for="p_category" class="form-label">{{ __('Parent Category') }}</label>
                                        <select name="parent_category_id" id="p_category" class="form-select form-control" data-placeholder="{{__("Select Category")}}">
                                            <option value="">{{__("Select a Category")}}</option>
                                            @include('category.dropdowntree', ['categories' => $categories])
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="col-md-12 form-group mandatory">
                                        <label for="Field Name" class="mandatory form-label">{{ __('Image') }}</label>
                                        <input type="file" name="image" id="image" class="form-control" data-parsley-required="true" accept=".jpg,.jpeg,.png">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="description" class="mandatory form-label">{{ __('Description') }}</label>
                                    <textarea name="description" id="description" class="form-control" cols="10" rows="5"></textarea>
                                    <div class="form-check form-switch mt-3">
                                        <input type="hidden" name="status" id="status" value="0">
                                        <input class="form-check-input status-switch" type="checkbox" role="switch" aria-label="status">{{ __('Active') }}
                                        <label class="form-check-label" for="status"></label>
                                    </div>
                                </div>


                                @if($languages->isNotEmpty())
                                    <hr>
                                    <h5>{{__("Translation")}}</h5>
                                    <div class="row">
                                        @foreach($languages as $key=>$language)
                                            <hr>
                                            <h5>{{($key+1).". ".$language->name}}</h5>
                                            <div class="col-md-12 form-group">
                                                <label for="name_{{$language->id}}" class="form-label">{{ __('Name') }} : </label>
                                                <input name="translations[{{$language->id}}]" id="name_{{$language->id}}" class="form-control" value="" required>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
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


