@extends('layouts.main')

@section('title')
    {{ __('User Reports') }}
@endsection

@section('page-title')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h4>@yield('title')</h4>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first"></div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <section class="section">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div id="filters">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="user_filter">{{__("User")}}</label>
                                                <select class="form-control bootstrap-table-filter-control-user_id" id="user_filter">
                                                    <option value="">{{__("All")}}</option>
                                                    @foreach($users as $user)
                                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="item_filter">{{__("Item")}}</label>
                                                <select class="form-control bootstrap-table-filter-control-item_id" id="item_filter">
                                                    <option value="">{{__("All")}}</option>
                                                    @foreach($items as $item)
                                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table-light table-striped" aria-describedby="mydesc"
                                           id="table_list" data-toggle="table" data-url="{{  route('report-reasons.user-reports.show') }}"
                                           data-click-to-select="true" data-responsive="true" data-side-pagination="server"
                                           data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]"
                                           data-search="true" data-show-columns="true"
                                           data-show-refresh="true" data-fixed-columns="true" data-fixed-number="1"
                                           data-fixed-right-number="1" data-trim-on-search="false" data-sort-name="id"
                                           data-sort-order="desc" data-pagination-successively-size="3" data-query-params="queryParams"
                                           data-escape="true"
                                           data-show-export="true" data-export-options='{"fileName": "advertisement-package-list","ignoreColumn": ["operate"]}' data-export-types="['pdf','json', 'xml', 'csv', 'txt', 'sql', 'doc', 'excel']"
                                           data-mobile-responsive="true" data-filter-control="true" data-filter-control-container="#filters" data-toolbar="#filters">
                                        <thead>
                                        <tr>
                                            <th scope="col" data-field="id" data-align="center" data-sortable="true">{{ __('ID') }}</th>
                                            <th scope="col" data-field="reason" data-align="center">{{ __('Reason') }}</th>
                                            <th scope="col" data-field="user.name" data-sort-name="user_name" data-align="center" data-sortable="true">{{ __('User') }}</th>
                                            <th scope="col" data-field="item.name" data-sort-name="item_name" data-align="center" data-sortable="true">{{ __('Item') }}</th>
                                            <th scope="col" data-field="item_id" data-align="center" data-sortable="true" data-visible="false" data-filter-control="select" data-filter-data="">{{ __('Item ID') }}</th>
                                            <th scope="col" data-field="user_id" data-align="center" data-sortable="true" data-visible="false" data-filter-control="select" data-filter-data="">{{ __('User ID') }}</th>
                                            <th scope="col" data-field="item_status" data-visible="true" data-formatter="itemStatusSwitchFormatter">{{ __('Item Status') }}</th>
                                            <th scope="col" data-field="user_status" data-visible="true" data-formatter="userStatusSwitchFormatter">{{ __('User status') }}</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
