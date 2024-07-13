@extends('layouts.main')

@section('title')
    {{ __('Countries') }}
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
    <section class="section">
        <div class="buttons d-flex justify-content-end">
            <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#countryModal">+ {{__("Import Countries")}} </a>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <table class="table-borderless table-striped" aria-describedby="mydesc" id="table_list"
                               data-toggle="table" data-url="{{ route('countries.show',1) }}" data-click-to-select="true"
                               data-side-pagination="server" data-pagination="true"
                               data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true"
                               data-show-columns="true" data-show-refresh="true" data-fixed-columns="true"
                               data-fixed-number="1" data-fixed-right-number="1" data-trim-on-search="false"
                               data-responsive="true" data-sort-name="id" data-sort-order="desc"
                               data-pagination-successively-size="3" data-table="countries" data-status-column="deleted_at"
                               data-escape="true"
                               data-show-export="true" data-export-options='{"fileName": "country-list","ignoreColumn": ["operate"]}' data-export-types="['pdf','json', 'xml', 'csv', 'txt', 'sql', 'doc', 'excel']"
                               data-mobile-responsive="true" data-filter-control="true" data-filter-control-container="#filters" data-toolbar="#filters">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" data-field="id" data-sortable="true">{{ __('ID') }}</th>
                                <th scope="col" data-field="name" data-sortable="true">{{ __('Name') }}</th>
                                <th scope="col" data-field="emoji">{{ __('Flag') }}</th>
                                <th scope="col" data-field="operate" data-escape="false">{{ __('Action') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div id="countryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">{{ __('Import Country Data') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="create-form" action="{{route('countries.import')}}" method="POST" data-success-function="successFunction">
                            @csrf
                            <div class="row">
                                @foreach($countries as $country)
                                    <div class="col-md-3">
                                        <input type="checkbox" id="{{$country['id']}}" name="countries[]" value="{{$country['id']}}" {{$country['is_already_exists'] ? "checked disabled" : ""}} class="form-check-input">
                                        <label for="{{$country['id']}}" class="form-label">{{$country['name'].' '.$country['emoji']}}</label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="text-end">
                                <input type="submit" value="{{__("Save")}}" class="btn btn-primary mt-3">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </section>
@endsection
@section('js')
    <script>
        function successFunction() {
            $('#countryModal').modal('hide');
        }
    </script>
@endsection
