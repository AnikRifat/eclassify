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
        <div class="buttons">
            <a class="btn btn-primary" href="{{ url('custom-fields') }}">< {{__("Back to Custom Fields")}} </a>
            @if(in_array($custom_field->type,['radio','checkbox','dropdown']))
                <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target='#addModal'>+ {{__("Add Options")}}</a>
            @endif
        </div>
        <form action="{{ route('custom-fields.update', $custom_field->id) }}" class="edit-form" data-success-function="afterCustomFieldUpdate" method="POST" data-parsley-validate enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">

                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-header">{{__("Create Custom Field")}}</div>
                        <div class="card-body mt-3">
                            <div class="row">
                                <div class="col-md-12 form-group mandatory">
                                    <label for="name" class="mandatory form-label">{{ __('Field Name') }}</label>
                                    <input type="text" name="name" id="name" class="form-control" data-parsley-required="true" value="{{ $custom_field->name }}">
                                </div>

                                <div class="col-md-12 form-group mandatory">
                                    <label for="type" class="mandatory form-label">{{ __('Field Type') }}</label>
                                    <select name="type" id="type" class="form-select form-control">
                                        <option value="{{ $custom_field->type }}" selected>{{ ucfirst($custom_field->type) }}</option>
                                    </select>
                                </div>

                                @if(in_array($custom_field->type,['radio','checkbox','dropdown']))
                                    <div class="col-md-12">
                                        <label for="values" class="form-label">{{ __('Field Values') }}</label>
                                        <div class="form-group">
                                            <select id="values" name="values[]" data-tags="true" data-placeholder="{{__("Select an option")}}" data-allow-clear="true" class="select2 col-12 w-100" multiple="multiple">
                                                @foreach ($custom_field->values as $value)
                                                    <option value="{{ $value }}" selected>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                            <div class="input_hint">{{__("This will be applied only for")}}:
                                                <text class="highlighted_text">{{__("Checkboxes").",".__("Radio")}}</text>
                                                and
                                                <text class="highlighted_text"> {{__("Dropdown")}}</text>
                                                .
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if(in_array($custom_field->type,['textbox','fileinput','number']))
                                    <div class="col-md-6 form-group ">
                                        <label for="min_length" class=" form-label">{{ __('Field Length (Min)') }}</label>
                                        <input type="text" name="min_length" id="min_length" class="form-control" value="{{ $custom_field->min_length }}">
                                        <div class="input_hint">  {{__("This will be applied only for")}}:
                                            <text class="highlighted_text">{{__("text").",".__("number")}}</text>
                                            {{__("and")}}
                                            <text class="highlighted_text"> {{__("textarea")}}</text>
                                            .
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group ">
                                        <label for="max_length" class=" form-label">{{ __('Field Length (Max)') }}</label>
                                        <input type="text" name="max_length" id="max_length" class="form-control" value="{{ $custom_field->max_length }}">
                                        <div class="input_hint"> {{__("This will be applied only for")}}:
                                            <text class="highlighted_text">{{__("text").",".__("number")}}</text>
                                            {{__("and")}}
                                            <text class="highlighted_text"> {{__("textarea")}}</text>
                                            .
                                        </div>
                                    </div>
                                @endif

                                <div class="col-md-12">
                                    <div class="col-md-12 form-group">
                                        <label for="image" class="form-label">{{ __('Image') }}</label>
                                        <input type="file" name="image" id="image" class="form-control" accept=" .jpg, .jpeg, .png, .svg">
                                        <small>{{__("(use 256 x 256 size for better view)")}}}</small>
                                    </div>
                                    <div class="field_img mt-2">
                                        <img src="{{ empty($custom_field->image) ? asset('assets/img_placeholder.jpeg') : $custom_field->image }}" alt="" id="blah" class="preview-image img w-25">
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6 form-group mandatory">
                                        <div class="form-check form-switch  ">
                                            <input type="hidden" name="required" id="required" value="{{ $custom_field->required ? '1' : '0' }}">
                                            <input class="form-check-input status-switch" type="checkbox" role="switch" aria-label="required" {{ $custom_field->required ? 'checked' : '' }}>{{ __('Required') }}
                                            <label class="form-check-label" for="required"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group mandatory">
                                        <div class="form-check form-switch  ">
                                            <input type="hidden" name="status" id="status" value="{{ $custom_field->status ? '1' : '0' }}">
                                            <input class="form-check-input status-switch" type="checkbox" role="switch" aria-label="status" {{ $custom_field->status ? 'checked' : '' }}>{{ __('Active') }}
                                            <label class="form-check-label" for="status"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-header">{{__("Category")}}</div>
                        <div class="card-body mt-2">
                            <div class="sub_category_lit">
                                @foreach ($categories as $category)
                                    <div class="category">
                                        <div class="category-header">
                                            <label>
                                                <input type="checkbox" name="selected_categories[]" value="{{ $category->id }}" {{in_array($category->id,$selected_categories) ? "checked" : ""}}> {{ $category->name }}
                                            </label>
                                            @if (!empty($category->subcategories))
                                                <i style='font-size:24px' class='fas toggle-button'>&#xf0da;</i>
                                            @endif
                                        </div>
                                        <div class="subcategories" style="display: none;">
                                            @if (!empty($category->subcategories))
                                                @include('category.treeview', ['categories' => $category->subcategories,'selected_categories' => $selected_categories])
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 text-end mb-3">
                    <input type="submit" class="btn btn-primary" value="{{__("Save and Back")}}">
                </div>
            </div>
        </form>
        @if(in_array($custom_field->type,['radio','checkbox','dropdown']))
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-borderless table-striped" id="table_list"
                               data-toggle="table" data-url="{{ route('custom-fields.value.show', $custom_field->id) }}"
                               data-click-to-select="true"
                               data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-search-align="right"
                               data-toolbar="#toolbar" data-show-columns="true" data-show-refresh="true"
                               data-trim-on-search="false" data-responsive="true" data-sort-name="id"
                               data-escape="true"
                               data-sort-order="desc" data-query-params="queryParams"
                               data-reorderable-rows="true" data-table="categories" data-use-row-attr-func="true" data-mobile-responsive="true">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" data-field="id" data-align="center" data-sortable="true">{{ __('ID') }}</th>
                                <th scope="col" data-field="value" data-align="center" data-sortable="true">{{ __('Value') }}</th>
                                <th scope="col" data-field="operate"data-escape="false" data-align="center" data-sortable="false" data-events="customFieldValueEvents">{{ __('Action') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        {{-- add modal --}}
        @if(in_array($custom_field->type,['radio','checkbox','dropdown']))
            <div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel1">{{ __('Add Values') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('custom-fields.value.add',$custom_field->id) }}" class="create-form form-horizontal" enctype="multipart/form-data" method="POST" data-parsley-validate>
                                @csrf
                                <div class="col-md-12 form-group mandatory">
                                    <label for="values" class="mandatory form-label">{{ __('Field Values') }}</label>
                                    <input type="text" name="values" id="values" class="form-control" value="{{ old('values') }}" data-parsley-required="true">
                                </div>

                                <input type="hidden" name="field_id" id="field_id" value="{{ $custom_field->id }}">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('Save') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            {{-- edit modal --}}
            <div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel1">{{ __('Edit Custom Field Values') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('custom-fields.value.update',$custom_field->id) }}" class="edit-form form-horizontal" enctype="multipart/form-data" method="POST" data-parsley-validate>
                                @csrf
                                <input type="hidden" name="old_custom_field_value" id="old_custom_field_value"/>
                                <div class="col-md-12 form-group mandatory">
                                    <label for="new_custom_field_value" class="mandatory form-label">{{ __('Name') }}</label>
                                    <input type="text" name="new_custom_field_value" id="new_custom_field_value" class="form-control" value="" data-parsley-required="true">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('Save') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
                @endif
            </div>
    </section>
@endsection
@section('js')
    <script>
        function afterCustomFieldUpdate() {
            setTimeout(function () {
                window.location.href = "{{route('custom-fields.index')}}"
            }, 1000)
        }
    </script>
@endsection
