@extends('layouts.main')

@section('title')
    {{__("Custom Fields")}}
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
        <form action="{{ route('custom-fields.store') }}" method="POST" class="create-form" data-success-function="afterCustomFieldCreation" data-parsley-validate enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-header">{{__("Create Custom Field")}}</div>
                        <div class="card-body mt-2">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-12 form-group mandatory">
                                        <label for="name" class="mandatory form-label">{{ __('Field Name') }}</label>
                                        <input type="text" name="name" id="name" class="form-control" data-parsley-required="true">
                                    </div>
                                </div>

                                <div class="col-md-12 form-group mandatory">
                                    <label for="type" class="mandatory form-label">{{ __('Field Type') }}</label>
                                    <select name="type" class="form-select form-control" id="type" data-parsley-required="true">
                                        <option value="number">{{__("Number Input")}}</option>
                                        <option value="textbox">{{__("Text Input")}}</option>
                                        <option value="fileinput">{{__("File Input")}}</option>
                                        <option value="radio">{{__("Radio")}}</option>
                                        <option value="dropdown">{{__("Dropdown")}}</option>
                                        <option value="checkbox">{{__("Checkboxes")}}</option>
                                    </select>
                                </div>

                                <div class="col-md-12" id="field-values-div" style="display: none;">
                                    <label for="values" class="form-label">{{ __('Field Values') }}</label>
                                    <div class="form-group">
                                        <select id="values" name="values[]" data-tags="true" data-placeholder="{{__("Select an option")}}" data-allow-clear="true" class="select2 w-100 full-width-select2" multiple="multiple" data-parsley-required="true"></select>
                                        <div class="input_hint">{{__("This will be applied only for")}}:
                                            <text class="highlighted_text"> {{__("Checkboxes").",".__("Radio")}}</text>
                                            {{__("and")}}
                                            <text class="highlighted_text">{{__("Dropdown")}}</text>
                                            .
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 form-group min-max-fields">
                                    <label for="min_length" class=" form-label">{{ __('Field Length (Min)') }}</label>
                                    <input type="number" name="min_length" id="min_length" class="form-control" min="1">
                                    <div class="input_hint"> {{__("This will be applied only for")}}:
                                        <text class="highlighted_text">{{__("text").",".__("number")}} </text>
                                        {{__("and")}}
                                        <text class="highlighted_text">{{__("textarea")}}</text>
                                        .
                                    </div>
                                </div>
                                <div class="col-md-6 form-group min-max-fields">
                                    <label for="max_length" class=" form-label">{{ __('Field Length (Max)') }}</label>
                                    <input type="number" name="max_length" id="max_length" class="form-control" min="1">
                                    <div class="input_hint"> {{__("This will be applied only for")}}:
                                        <text class="highlighted_text">{{__("text").",".__("number")}}
                                        </text>
                                        {{__("and")}}
                                        <text class="highlighted_text">{{__("textarea")}}</text>
                                        .
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-12 form-group mandatory">
                                        <label for="image" class="form-label">{{ __('Icon ') }}</label>
                                        <input type="file" name="image" id="image" class="form-control" data-parsley-required="true" accept=" .jpg, .jpeg, .png, .svg">
                                        {{__("(use 256 x 256 size for better view)")}}
                                        <div class="img_error" style="color:#DC3545;"></div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group mandatory">
                                    <div class="form-check form-switch  ">
                                        <input type="hidden" name="required" id="required" value="0">
                                        <input class="form-check-input status-switch" type="checkbox" role="switch" aria-label="required">{{ __('Required') }}
                                        <label class="form-check-label" for="required"></label>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group mandatory">
                                    <div class="form-check form-switch  ">
                                        <input type="hidden" name="status" id="status" value="0">
                                        <input class="form-check-input status-switch" type="checkbox" role="switch" aria-label="status">{{ __('Active') }}
                                        <label class="form-check-label" for="status"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($cat_id == 0)
                    <div class="col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-header">{{__("Category")}}</div>
                            <div class="card-body mt-2">
                                <div class="sub_category_lit">
                                    @foreach ($categories as $category)
                                        <div class="category">
                                            <div class="category-header">
                                                <label>
                                                    <input type="checkbox" name="selected_categories[]" value="{{ $category->id }}"> {{ $category->name }}
                                                </label>
                                                @if (!empty($category->subcategories))
                                                    <i style='font-size:24px' class='fas toggle-button'>&#xf0da;</i>
                                                @endif
                                            </div>
                                            <div class="subcategories" style="display: none;">
                                                @if (!empty($category->subcategories))
                                                    @include('category.treeview', ['categories' => $category->subcategories])
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <input type="hidden" name="selected_categories[]" value="{{ $cat_id }}">
                @endif
                <div class="col-md-12 text-end">
                    <input type="submit" class="btn btn-primary" value="{{__("Save and Back")}}">
                </div>
            </div>
        </form>
    </section>
@endsection
@section('script')
    <script>
        function afterCustomFieldCreation() {
            setTimeout(function () {
                window.location.href = "{{route('custom-fields.index')}}";
            }, 1000)
        }
    </script>
@endsection
