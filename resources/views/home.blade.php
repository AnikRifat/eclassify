@extends('layouts.main')
@section('title')
    {{__('Home')}}
@endsection
@section('content')
    <section class="section">
        <div class="dashboard_title mb-3">{{__("Hi, Admin")}}</div>
        <div class="row mb-3 d-flex">
            <div class="col-md-4 col-sm-12">
                <div class="row">
                    <div class="col-md-6 col-sm-6 mb-5">
                        <a href="{{ url('customer') }}">
                            <div class="card h-100">
                                <div class="total_customer d-flex">
                                    <div class="curtain"></div>
                                    <div class="row">
                                        <div class="col-4 col-md-12 ">
                                            <div class="svg_icon align-items-center d-flex justify-content-center me-3">
                                                <span class="fa fa-users text-white fa-2x"></span>
                                            </div>
                                        </div>
                                        <div class="col-8 col-md-12">
                                            <div class="total_number">{{$user_count}}</div>
                                            <div class="card_title">{{ __('Total Customers') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-6 col-sm-6 mb-5">
                        <a href="{{ url('item') }}">
                            <div class="card h-100">
                                <div class="total_items d-flex">
                                    <div class="curtain"></div>
                                    <div class="row">
                                        <div class="col-4 col-md-12 ">
                                            <div class="svg_icon align-items-center d-flex justify-content-center me-3">
                                                <span class="fa fa-box text-white fa-2x"></span>
                                            </div>
                                        </div>
                                        <div class="col-8 col-md-12">
                                            <div class="total_number">{{$item_count}}</div>
                                            <div class="card_title">{{ __('Total Items') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-6 col-sm-6 mb-5">
                        <a href="{{ route('category.index') }}">
                            <div class="card h-100">
                                <div class="item_for_sale d-flex">
                                    <div class="curtain"></div>
                                    <div class="row">
                                        <div class="col-4 col-md-12 ">
                                            <div class="svg_icon align-items-center d-flex justify-content-center me-3">
                                                <span class="fa fa-layer-group text-white fa-2x"></span>
                                            </div>
                                        </div>
                                        <div class="col-8 col-md-12">
                                            <div class="total_number">{{$categories_count}}</div>
                                            <div class="card_title">{{ __('Total Categories') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-6 col-sm-6 mb-5">
                        <a href="{{ route('custom-fields.index') }}">
                            <div class="card h-100">
                                <div class="properties_for_rent d-flex">
                                    <div class="curtain"></div>
                                    <div class="row">
                                        <div class="col-4 col-md-12 ">
                                            <div class="svg_icon align-items-center d-flex justify-content-center me-3">
                                                <span class="fab fa-wpforms text-white fa-2x"></span>
                                            </div>
                                        </div>
                                        <div class="col-8 col-md-12">
                                            <div class="total_number">{{$custom_field_count}}</div>
                                            <div class="card_title">{{ __('Total Custom Fields') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card h-100">
                    <div class="card-header border-0 pb-0">
                        <h3 style="font-weight: 600">{{__("Featured Sections")}}</h3>
                    </div>
                    <div class="card-body">
                        <table class="table-borderless table-striped" aria-describedby="mydesc"
                               id="table_list" data-toggle="table" data-url="{{ route('feature-section.show',1) }}"
                               data-click-to-select="true" data-search="true" data-toolbar="#toolbar"
                               data-show-columns="true" data-show-refresh="true" data-fixed-columns="true"
                               data-fixed-number="1" data-trim-on-search="false" data-responsive="true"
                               data-escape="true"
                               data-sort-name="id" data-sort-order="desc" data-query-params="queryParams" data-mobile-responsive="true"
                               data-side-pagination="server" data-pagination="true" data-page-size="4">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" data-field="id" data-sortable="true">{{ __('ID') }}</th>
                                <th scope="col" data-field="style" data-formatter="styleImageFormatter">{{ __('Style') }}</th>
                                <th scope="col" data-field="title" data-sortable="false">{{ __('Title') }}</th>
                                <th scope="col" data-field="filter" data-sortable="false" data-formatter="filterTextFormatter">{{ __('Filters') }}</th>
                                <th scope="col" data-field="min_price" data-sortable="true" data-visible="false">{{ __('Min Price') }}</th>
                                <th scope="col" data-field="max_price" data-sortable="true" data-visible="false">{{ __('Max price') }}</th>
                                <th scope="col" data-field="values_text" data-sortable="true" data-visible="false">{{ __('Value') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header border-0 pb-0">
                <h3 style="font-weight: 600">{{__("Recent Items")}}</h3>
            </div>
            <div class="card-body">
                <table class="table-borderless table-striped" aria-describedby="mydesc" id="table_list"
                       data-toggle="table" data-url="{{ route('item.show',1) }}" data-click-to-select="true"
                       data-search="true" data-toolbar="#toolbar" data-show-columns="true" data-show-refresh="true"
                       data-fixed-columns="true" data-fixed-number="1" data-trim-on-search="false"
                       data-responsive="true" data-sort-name="id" data-sort-order="desc"
                       data-escape="true"
                       data-query-params="queryParams" data-mobile-responsive="true">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col" data-field="id" data-sortable="true">{{ __('ID') }}</th>
                        <th scope="col" data-field="name" data-sortable="true">{{ __('Name') }}</th>
                        <th scope="col" data-field="category.name" data-sortable="true">{{ __('Category') }}</th>
                        <th scope="col" data-field="user.name" data-sortable="true">{{ __('Added By') }}</th>
                        <th scope="col" data-field="price" data-sortable="true">{{ __('Price') }}</th>
                        <th scope="col" data-field="status" data-sortable="true" data-formatter="itemStatusFormatter">{{ __('Status') }}</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

        <div class="row mb-10">
            <div class="col-md-6 col-sm-12">
                <div class="card h-100">
                    <div class="card-header">
                        <div class="recent_list_heading">{{__("Total Categories")}}</div>
                    </div>
                    <div class="card-body mt-5">
                        <div id="pie_chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        let options = {
            series: [{{ implode(',', array_values($category_item_count)) }}],
            chart: {
                type: 'donut',
                height: "700px"
            },
            labels: [{!! implode(',', $category_name) !!}],
            plotOptions: {},

            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: '100%',
                        height: '300px',
                    },
                }
            }],
            legend: {
                show: true,
                showForSingleSeries: false,
                showForNullSeries: true,
                showForZeroSeries: true,
                position: 'bottom',
                horizontalAlign: 'center',
                fontSize: '18px',
                fontFamily: 'Helvetica, Arial',
                fontWeight: 400,
                itemMargin: {
                    horizontal: 30,
                    vertical: 10
                }
            }
        };

        let chart1 = new ApexCharts(document.querySelector("#pie_chart"), options);
        chart1.render();
    </script>
@endsection
