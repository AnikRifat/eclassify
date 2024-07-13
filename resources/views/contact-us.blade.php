@extends('layouts.main')
@section('title')
    {{__("User Queries")}}
@endsection

@section('page-title')
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-6">
                <h4 class="mb-0">@yield('title')</h4>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-body">
                        <table class="table table-borderless table-striped" aria-describedby="mydesc"
                               id="table_list" data-toggle="table" data-url="{{ route('contact-us.show') }}"
                               data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                               data-page-list="[5, 10, 20, 50, 100, 200,500,2000]" data-search="true" data-search-align="right"
                               data-toolbar="#toolbar" data-show-columns="true" data-show-refresh="true"
                               data-trim-on-search="false" data-responsive="true" data-sort-name="id"
                               data-sort-order="asc" data-pagination-successively-size="3" data-query-params="queryParams"
                               data-escape="true"
                               data-use-row-attr-func="true" data-mobile-responsive="true"
                               data-show-export="true" data-export-options='{"fileName": "category-list","ignoreColumn": ["operate"]}' data-export-types="['pdf','json', 'xml', 'csv', 'txt', 'sql', 'doc', 'excel']">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" data-field="id" data-align="center" data-sortable="true">{{ __('ID') }}</th>
                                <th scope="col" data-field="name" data-align="center" data-sortable="true">{{ __('Name') }}</th>
                                <th scope="col" data-field="email" data-align="center">{{ __('Email') }}</th>
                                <th scope="col" data-field="subject" data-align="center" data-sortable="true">{{ __('Subject') }}</th>
                                <th scope="col" data-field="message" data-align="center" data-sortable="true" >{{ __('Message') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
