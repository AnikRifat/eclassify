@extends('layouts.main')
@section('title')
    {{__("Create Feature Section")}}
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
        @can('feature-section-create')
            <div class="row">
                <form action="{{ route('feature-section.store') }}" class="create-form" method="POST" enctype="multipart/form-data" data-parsley-validate>
                    @csrf
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">{{__("Add Feature Section")}}</div>
                            <div class="card-body">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="col-md-12 form-group mandatory">
                                            <label for="title" class="mandatory form-label">{{ __('Title') }}</label>
                                            <input type="text" name="title" id="title" class="form-control feature-section-name" data-parsley-required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12 form-group mandatory">
                                            <label for="slug" class="mandatory form-label">{{ __('Slug') }}</label>
                                            <input type="text" name="slug" id="slug" class="form-control feature-section-slug" data-parsley-required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-8 form-group mandatory">
                                        <label for="filter" class=" form-label">{{ __('Filters') }}</label>
                                        <select id="filter" name="filter" class="form-control select2">
                                            <option value="most_liked">{{__("Most Liked")}}</option>
                                            <option value="most_viewed">{{__("Most Viewed")}}</option>
                                            <option value="price_criteria">{{__("Price Criteria")}}</option>
                                            <option value="category_criteria">{{__("Category Criteria")}}</option>
                                        </select>
                                    </div>

                                    <div id="price_criteria" style="display:none;">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="col-md-12 form-group mandatory">
                                                    <label for="min_price" class=" form-label">{{ __('Minimum Price') }}</label>
                                                    <input type="number" name="min_price" id="min_price" class="form-control" required min="1">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="col-md-12 form-group mandatory">
                                                    <label for="max_price" class=" form-label">{{ __('Maximum Price') }}</label>
                                                    <input type="number" name="max_price" id="max_price" class="form-control" required min="1" data-parsley-gt="#min_price" data-parsley-error-message="Max Price should be Greater than Min Price">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="row">
                                            <div id="category_criteria" class="col-md-8 form-group mandatory" style="display: none;">
                                                <label for="category_id" class=" form-label">{{ __('Category') }}</label>
                                                <br>
                                                <select name="category_id[]" class="select2" multiple id="category_id" data-placeholder="{{__("Select Category")}}" required>
                                                    @include('category.dropdowntree', ['categories' => $categories])
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group mandatory">
                                    <label for="Field Name" class=" form-label">{{ __('Select Style for APP Section') }}</label>
                                    <div class="col-md-2 col-sm-2">
                                        <label class="radio-img">
                                            <input type="radio" name="style" value="style_1" required/>
                                            <img src="{{asset('/images/app_styles/style_1.png')}}" height="115px" width="130px" alt="style_1" class="style_image">
                                        </label>
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <label class="radio-img">
                                            <input type="radio" name="style" value="style_2"/>
                                            <img src="{{asset('/images/app_styles/style_2.png')}}" height="115px" width="130px" alt="style_2" class="style_image">
                                        </label>
                                    </div>

                                    <div class="col-md-2 col-sm-2">
                                        <label class="radio-img">
                                            <input type="radio" name="style" value="style_3"/>
                                            <img src="{{asset('/images/app_styles/style_3.png')}}" height="115px" width="130px" alt="style_3" class="style_image">
                                        </label>
                                    </div>

                                    <div class="col-md-2 col-sm-2">
                                        <label class="radio-img">
                                            <input type="radio" name="style" value="style_4"/>
                                            <img src="{{asset('/images/app_styles/style_4.png')}}" height="115px" width="130px" alt="style_4" class="style_image">
                                        </label>
                                    </div>

                                </div>

                                <div class="col-md-12 d-flex justify-content-end">
                                    <button class="btn btn-primary" type="submit" name="submit">{{ __('Submit') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        @endcan

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <small class="text-danger">* {{__("To change the order, Drag the Table column Up & Down")}}</small>
                        <table class="table table-borderless table-striped" aria-describedby="mydesc"
                               id="table_list" data-toggle="table" data-url="{{ route('feature-section.show',1) }}"
                               data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                               data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-search-align="right"
                               data-toolbar="#toolbar" data-show-columns="true" data-show-refresh="true"
                               data-fixed-columns="true" data-fixed-number="1" data-fixed-right-number="1"
                               data-trim-on-search="false" data-responsive="true"
                               data-pagination-successively-size="3" data-query-params="queryParams"
                               data-escape="true"
                               data-reorderable-rows="true" data-use-row-attr-func="true" data-table="feature_sections"
                               data-show-export="true" data-export-options='{"fileName": "featured-section-list","ignoreColumn": ["operate"]}' data-export-types="['pdf','json', 'xml', 'csv', 'txt', 'sql', 'doc', 'excel']"
                               data-mobile-responsive="true">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" data-field="id" data-sortable="true">{{ __('ID') }}</th>
                                <th scope="col" data-field="style" data-formatter="styleImageFormatter">{{ __('Style') }}</th>
                                <th scope="col" data-field="title" data-sortable="true">{{ __('Title') }}</th>
                                <th scope="col" data-field="filter" data-sortable="true" data-formatter="filterTextFormatter">{{ __('Filters') }}</th>
                                <th scope="col" data-field="sequence" data-sortable="true">{{ __('Sequence') }}</th>
                                <th scope="col" data-field="min_price" data-sortable="true" data-visible="false">{{ __('Min Price') }}</th>
                                <th scope="col" data-field="max_price" data-sortable="true" data-visible="false">{{ __('Max price') }}</th>
                                <th scope="col" data-field="values_text" data-sortable="false" data-visible="false">{{ __('Value') }}</th>
                                @canany(['feature-section-update', 'feature-section-delete'])
                                    <th scope="col" data-field="operate" data-escape="false" data-sortable="false" data-events="featuredSectionEvents">{{ __('Action') }}</th>
                                @endcanany
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @can('feature-section-update')
        <!-- EDIT MODEL MODEL -->
            <div id="editModal" class="modal fade modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="" class="form-horizontal edit-form" enctype="multipart/form-data" method="POST" novalidate>
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel1">{{ __('Edit feature Section') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="col-md-12 form-group mandatory">
                                            <label for="edit_title" class="mandatory form-label">{{ __('Title') }}</label>
                                            <input type="text" name="title" id="edit_title" class="form-control edit-feature-section-name" data-parsley-required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12 form-group mandatory">
                                            <label for="slug" class="mandatory form-label">{{ __('Slug') }}</label>
                                            <input type="text" name="slug" id="edit_slug" class="form-control edit-feature-section-slug" data-parsley-required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group mandatory">
                                        <label for="edit_filter" class="form-label">{{ __('Filters') }}</label>
                                        <select id="edit_filter" name="filter" class="form-control select2">
                                            <option value="most_liked">{{__("Most Liked")}}</option>
                                            <option value="most_viewed">{{__("Most Viewed")}}</option>
                                            <option value="price_criteria">{{__("Price Criteria")}}</option>
                                            <option value="category_criteria">{{__("Category Criteria")}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="edit_price_criteria" class="row" style="display: none;">
                                    <div class="col-md-4">
                                        <div class="col-md-12 form-group mandatory">
                                            <label for="edit_min_price" class="form-label">{{ __('Minimum Price') }}</label>
                                            <input type="number" name="min_price" id="edit_min_price" class="form-control" required min="1">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="col-md-12 form-group mandatory">
                                            <label for="edit_max_price" class="form-label">{{ __('Maximum Price') }}</label>
                                            <input type="number" name="max_price" id="edit_max_price" class="form-control" required min="1" data-parsley-gt="#edit_min_price" data-parsley-error-message="Max Price should be Greater than Min Price">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div id="edit_category_criteria" class="col-md-12 form-group mandatory" style="display: none;">
                                        <label for="edit_category_id" class="form-label">{{ __('Category') }}</label>
                                        <select name="category_id[]" class="select2" id="edit_category_id" data-placeholder="{{__("Select Category")}}" multiple>
                                            @include('category.dropdowntree', ['categories' => $categories])
                                        </select>

                                    </div>
                                </div>

                                <div class="row form-group mandatory">
                                    <label for="Field Name" class=" form-label">{{ __('Select Style for APP Section') }}</label>
                                    <div class="col-md-3 col-sm-2">
                                        <label class="radio-img">
                                            <input type="radio" name="style" value="style_1" required/>
                                            <img src="{{asset('/images/app_styles/style_1.png')}}" height="115px" width="130px" alt="style_1" class="style_image">
                                        </label>
                                    </div>
                                    <div class="col-md-3 col-sm-2">
                                        <label class="radio-img">
                                            <input type="radio" name="style" value="style_2" required/>
                                            <img src="{{asset('/images/app_styles/style_2.png')}}" height="115px" width="130px" alt="style_2" class="style_image">
                                        </label>
                                    </div>

                                    <div class="col-md-3 col-sm-2">
                                        <label class="radio-img">
                                            <input type="radio" name="style" value="style_3" required/>
                                            <img src="{{asset('/images/app_styles/style_3.png')}}" height="115px" width="130px" alt="style_3" class="style_image">
                                        </label>
                                    </div>

                                    <div class="col-md-3 col-sm-2">
                                        <label class="radio-img">
                                            <input type="radio" name="style" value="style_4" required/>
                                            <img src="{{asset('/images/app_styles/style_4.png')}}" height="115px" width="130px" alt="style_4" class="style_image">
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan
    </section>
@endsection
@section('js')
    <script>
        {{--TODO: @include was not loading data 2nd time. So added this temporary solution here--}}
        let category_options = $('#category_id option').clone();
        $('#edit_category_id').append(category_options);
    </script>
@endsection
