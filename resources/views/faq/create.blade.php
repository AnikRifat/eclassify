@extends('layouts.main')
@section('title')
    {{__("FAQ")}}
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
        @can('faq-create')
            <div class="row">
                <form class="create-form" action="{{ route('faq.store') }}" method="POST" data-parsley-validate enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">{{__("Add FAQ")}}</div>

                            <div class="card-body mt-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="question" class="mandatory form-label">{{ __('Question') }}</label>
                                        <input type="text" name="question" id="question" class="form-control" placeholder="Enter Question here">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="answer" class="mandatory form-label">{{ __('Answer') }}</label>
                                        <textarea name="answer" id="answer" class="form-control" cols="10" rows="5" placeholder="Enter your answer here"></textarea>
                                    </div>

                                    <div class="col-md-12 m-2 text-end">
                                        <input type="submit" class="btn btn-primary" value="{{__("Create")}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        @endcan
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <table class="table-light table-striped" aria-describedby="mydesc" id="table_list"
                                       data-toggle="table" data-url="{{ route('faq.show',1) }}" data-click-to-select="true"
                                       data-side-pagination="server" data-pagination="true"
                                       data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true"
                                       data-toolbar="#toolbar" data-show-columns="true" data-show-refresh="true"
                                       data-fixed-columns="true" data-fixed-number="1" data-fixed-right-number="1"
                                       data-trim-on-search="false" data-responsive="true" data-sort-name="id"
                                       data-sort-order="desc" data-pagination-successively-size="3"
                                       data-escape="true"
                                       data-query-params="queryParams" data-mobile-responsive="true">
                                    <thead>
                                    <tr>
                                        <th scope="col" data-field="id" data-sortable="true">{{ __('ID') }}</th>
                                        <th scope="col" data-field="question" data-sortable="false">{{ __('Questions') }}</th>
                                        <th scope="col" data-field="answer" data-sortable="false">{{'Answers'}}</th>
                                        <th scope="col" data-field="operate" data-sortable="false" data-escape="false" data-events="faqEvents">{{ __('Action') }}</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @can('faq-update')
        <!-- EDIT MODEL MODEL -->
            <div id="editModal" class="modal fade modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="" class="form-horizontal edit-form" enctype="multipart/form-data" method="POST" novalidate>
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel1">{{ __('Edit FAQ') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12 form-group mandatory">
                                        <label for="edit_question" class="mandatory form-label">{{ __('Question') }}</label>
                                        <input type="text" name="question" id="edit_question" class="form-control" data-parsley-required="true">
                                    </div>
                                    <div class="col-md-12 form-group mandatory">
                                        <label for="edit_answer" class="form-label">{{ __('Answer') }}</label>
                                        <textarea name="answer" id="edit_answer" class="form-control" cols="10" rows="5" data-parsley-required="true"></textarea>
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
