@extends('layouts.main')
@section('title')
    {{__("Create Tips")}}
@endsection

@section('page-title')
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-6">
                <h4 class="mb-0">@yield('title')</h4>
            </div>
            <div class="col-12 col-md-6 d-flex justify-content-end">
                @can('tips-create')
                    <a class="btn btn-primary" href="{{ route('tips.create') }}">+ {{__("Add Tip")}} </a>
                @endcan
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
                        <div id="toolbar">
                            <small class="text-danger">* {{__("To change the order, Drag the Table column Up & Down")}}</small>
                        </div>
                        <table class="table table-borderless table-striped" aria-describedby="mydesc"
                               id="table_list" data-toggle="table" data-url="{{ route('tips.show',0) }}"
                               data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                               data-page-list="[5, 10, 20, 50, 100, 200,500,2000]" data-search="true" data-search-align="right"
                               data-toolbar="#toolbar" data-show-columns="true" data-show-refresh="true"
                               data-trim-on-search="false" data-responsive="true" data-sort-name="sequence"
                               data-sort-order="asc" data-pagination-successively-size="3" data-query-params="queryParams"
                               data-escape="true"
                               data-reorderable-rows="true" data-table="tips" data-status-column="deleted_at" data-use-row-attr-func="true" data-mobile-responsive="true"
                               data-show-export="true" data-export-options='{"fileName": "tips-list","ignoreColumn": ["operate"]}' data-export-types="['pdf','json', 'xml', 'csv', 'txt', 'sql', 'doc', 'excel']"
                               data-detail-view="true"
                               data-detail-formatter="detailFormatter">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" data-field="id" data-align="center" data-sortable="true">{{ __('ID') }}</th>
                                <th scope="col" data-field="description" data-align="center" data-sortable="true">{{ __('Description') }}</th>
                                @can('tips-update')
                                    <th scope="col" data-field="status" data-width="5" data-sortable="true" data-formatter="statusSwitchFormatter">{{ __('Active') }}</th>
                                @endcan
                                @canany(['tips-update', 'tips-delete'])
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
