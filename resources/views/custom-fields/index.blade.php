@extends('layouts.main')
@section('title')
    {{__("Custom Fields")}}
@endsection

@section('page-title')
    <div class="page-title">
        <div class="row d-flex align-items-center">
            <div class="col-12 col-md-6">
                <h4 class="mb-0">@yield('title')</h4>
            </div>
            <div class="col-12 col-md-6 text-end">
                @can('custom-field-create')
                    <a href="{{ route('custom-fields.create', ['id' => 0]) }}" class="btn btn-primary mb-0">+ {{__("Create Custom Field")}} </a>
                @endcan
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div id="filters">
                            <label for="filter">{{__("Category")}}</label>
                            <select name="category" class="form-control bootstrap-table-filter-control-category_names" aria-label="category">
                                <option value="">{{__("All")}}</option>
                                @include('category.dropdowntree', ['categories' => $categories])
                            </select>
                        </div>
                        <table class="stable-borderless table-striped" aria-describedby="mydesc" id="table_list"
                               data-toggle="table" data-url="{{ route('custom-fields.show',1) }}" data-click-to-select="true"
                               data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]"
                               data-search="true" data-search-align="right" data-toolbar="#filters" data-show-columns="true"
                               data-show-refresh="true" data-fixed-columns="true" data-fixed-number="1" data-fixed-right-number="1"
                               data-trim-on-search="false" data-responsive="true" data-sort-name="id" data-sort-order="desc"
                               data-pagination-successively-size="3"
                               data-escape="true"
                               data-show-export="true" data-export-options='{"fileName": "custom-field-list","ignoreColumn": ["operate"]}' data-export-types="['pdf','json', 'xml', 'csv', 'txt', 'sql', 'doc', 'excel']"
                               data-mobile-responsive="true" data-filter-control="true" data-filter-control-container="#filters">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" data-field="state" data-checkbox="true"></th>
                                <th scope="col" data-field="id" data-align="center" data-sortable="true">{{ __('ID') }}</th>
                                <th scope="col" data-field="image" data-align="center" data-formatter="imageFormatter">{{ __('Image') }}</th>
                                <th scope="col" data-field="name" data-align="center" data-sortable="true">{{ __('Name') }}</th>
                                <th scope="col" data-field="category_names" data-align="center" data-filter-name="category_id" data-filter-control="select" data-filter-data="">{{ __('Category') }}</th>
                                <th scope="col" data-field="type" data-align="center" data-sortable="true">{{ __('Type') }}</th>
                                @canany(['custom-field-update','custom-field-delete'])
                                    <th scope="col" data-field="operate" data-escape="false" data-sortable="false">{{ __('Action') }}</th>
                                @endcanany
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
