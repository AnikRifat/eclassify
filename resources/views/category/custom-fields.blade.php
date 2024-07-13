@extends('layouts.main')

@section('title')
    {{__("Custom Fields")}} / {{__("Sub Category")}}
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
        <div class="row">
            <div class="col-md-10">
                <div class="buttons text-start">
                    <a href="{{ route('category.index', $p_id) }}" class="btn btn-primary">< {{__("Back To Category")}} </a>
                    <a href="{{ route('custom-fields.create', ['id' => $cat_id]) }}" class="btn btn-primary">+ {{__("Create Custom Field")}} / {{ $category_name }}</a>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-borderless table-striped" aria-describedby="mydesc" id="table_list"
                           data-toggle="table" data-url="{{ route('category.custom-fields.show', $cat_id) }}"
                           data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                           data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-search-align="right"
                           data-escape="true"
                           data-toolbar="#toolbar" data-show-columns="true" data-show-refresh="true" data-fixed-columns="true"
                           data-fixed-number="1" data-fixed-right-number="1" data-trim-on-search="false" data-responsive="true"
                           data-sort-name="id" data-sort-order="desc" data-pagination-successively-size="3"
                           data-query-params="queryParams" data-mobile-responsive="true">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col" data-field="state" data-checkbox="true"></th>
                            <th scope="col" data-field="id" data-align="center" data-sortable="true">{{ __('ID') }}</th>
                            <th scope="col" data-field="image" data-align="center" data-formatter='imageFormatter'>{{ __('Image') }}</th>
                            <th scope="col" data-field="name" data-align="center" data-sortable="true">{{ __('Custom Field') }}</th>
                            <th scope="col" data-field="operate" data-escape="false" data-sortable="false">{{ __('Action') }}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
