@extends('layouts.main')
@section('title')
    {{__("Area")}}
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
        @can('area-create')
            <div class="row">
                <form class="create-form" action="{{route('area.create')}}" method="POST" data-parsley-validate enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">{{__("Add Area")}}</div>
                            <div class="card-body mt-3">
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label for="country" class="mandatory form-label">Country:</label>
                                        <select name="country_id" id="country" class="form-control form-select" data-placeholder="{{__("Select Country")}}">
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label for="state" class="mandatory form-label">State:</label>
                                        <select name="state_id" id="state" class="form-control form-select" data-placeholder="{{__("Select State")}}">
                                            <option value="">Select State</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label for="city" class="mandatory form-label">City:</label>
                                        <select name="city_id" id="city" class="form-control form-select" data-placeholder="{{__("Select City")}}">
                                            <option value="">Select City</option>
                                        </select>
                                    </div>
                                    <div id="areas-container" class="col-md-4 form-group">

                                        <label for="name" class="mandatory form-label mt-2">{{ __('Area Name') }}</label>
                                        <div class="d-flex">
                                            <input type="text" id="name" name="name[]" class="form-control me-2 " placeholder="Enter Area name">
                                            <button type="button" id="add-area-button" class="btn btn-secondary">+</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 m-2 text-end">
                                    <input type="submit" class="btn btn-primary" value="{{__("Create")}}">
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
                        <div id="filters">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <label for="filter_country">{{__("Country")}}</label>
                                    <select class="form-control bootstrap-table-filter-control-country.name" id="filter_country">
                                        <option value="">{{__("All")}}</option>
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}">{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label for="filter_state">{{__("State")}}</label>
                                    <select class="form-control bootstrap-table-filter-control-state.name" id="filter_state">
                                        <option value="">{{__("All")}}</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label for="filter_city">{{__("City")}}</label>
                                    <select name="city_id" class="form-control bootstrap-table-filter-control-city.name" id="filter_city">
                                        <option value="">{{__("All")}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table class="table-light table-striped" aria-describedby="mydesc" id="table_list"
                                       data-toggle="table" data-url="{{ route('area.show',1) }}" data-click-to-select="true"
                                       data-side-pagination="server" data-pagination="true"
                                       data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true"
                                       data-show-columns="true" data-show-refresh="true"
                                       data-fixed-columns="true" data-fixed-number="1" data-fixed-right-number="1"
                                       data-trim-on-search="false" data-responsive="true" data-sort-name="id"
                                       data-sort-order="desc" data-pagination-successively-size="3"
                                       data-escape="true" data-mobile-responsive="true"
                                       data-filter-control="true"
                                       data-toolbar="#filters"
                                       data-filter-control-container="#filters">
                                    <thead>
                                    <tr>
                                        <th scope="col" data-field="id" data-sortable="true">{{ __('ID') }}</th>
                                        <th scope="col" data-field="name" data-sortable="false">{{'Name'}}</th>
                                        <th scope="col" data-field="country.name" data-sortable="false" data-filter-name="country_id" data-filter-control="select" data-filter-data="">{{ __('Country') }}</th>
                                        <th scope="col" data-field="state.name" data-sortable="false" data-filter-name="state_id" data-filter-control="select" data-filter-data="">{{'State'}}</th>
                                        <th scope="col" data-field="city.name" data-sortable="false" data-filter-name="city_id" data-filter-control="select" data-filter-data="">{{'City'}}</th>
                                        <th scope="col" data-field="operate" data-sortable="false" data-escape="false" data-events="areaEvents">{{ __('Action') }}</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @can('area-update')
        <!-- EDIT MODEL MODEL -->
            <div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel1">{{ __('Edit Area') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="edit-form" class="edit-form" action="" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 form-group mandatory">
                                        <label for="edit_name" class="mandatory form-label">{{ __('Name') }}</label>
                                        <input type="text" name="name" id="edit_name" class="form-control" data-parsley-required="true">
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
            </div>
        @endcan
    </section>
@endsection
