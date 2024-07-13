@extends('layouts.main')

@section('title')
    {{ __('Languages') }}
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
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="divider">
                            <div class="divider-text">
                                <h4>{{ __('Add Language') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row form-group">
                                <div class="col-sm-12 col-md-12 form-group">
                                    {!! Form::open(['url' => route('language.store'), 'files' => true, 'data-parsley-validate','class'=>'create-form']) !!}
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 form-group mandatory ">
                                            {{ Form::label('Language Name', __('Language Name'), ['class' => 'form-label text-center']) }}
                                            {{ Form::text('name', '', ['class' => 'form-control', 'placeholder' => __('Language Name'), 'data-parsley-required' => 'true']) }}
                                        </div>

                                        <div class="col-sm-12 col-md-12 form-group mandatory ">
                                            {{ Form::label('Language Name', __('Language Name'). " (".__("in English").")", ['class' => 'form-label text-center']) }}
                                            {{ Form::text('name_in_english', '', ['class' => 'form-control', 'placeholder' => __('Language Name')." (".__("in English").")", 'data-parsley-required' => 'true']) }}
                                        </div>

                                        <div class="col-sm-12 col-md-12 form-group mandatory ">
                                            {{ Form::label('Language Code', __('Language Code'), ['class' => 'form-label text-center']) }}
                                            {{ Form::text('code', '', ['class' => 'form-control', 'placeholder' => __('Language Code'), 'data-parsley-required' => 'true']) }}
                                        </div>
                                        <div class="col-sm-12 col-md-12 form-group mandatory">
                                            <label class="form-label ">{{ __('Image') }}</label>
                                            <div class="">
                                                <input class="filepond" type="file" name="image" id="favicon_icon">
                                            </div>
                                        </div>
                                        <div class="col-sm-1 col-md-12">
                                            {{ Form::label('file', __('RTL'), ['class' => 'col-form-label text-center']) }}
                                            <div class="form-check form-switch col-12" style='padding-right:12.5rem;'>
                                                {{ Form::checkbox('rtl', '', false, ['class' => 'form-check-input','id'=>'rtl']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-2 col-md-12 form-group mandatory">
                                            {{ Form::label('file', __('File For Admin Panel'), ['class' => 'form-label  text-center', 'accept' => '.json.*']) }}
                                            {{ Form::file('panel_file', ['class' => 'form-control', 'language code', 'data-parsley-required' => 'true', 'accept' => '.json']) }}
                                        </div>
                                        <div class="col-sm-2 col-md-12  form-group mandatory">
                                            {{ Form::label('file', __('File For App'), ['class' => 'form-label text-center', 'accept' => '.json.*']) }}
                                            {{ Form::file('app_file', ['class' => 'form-control', 'data-parsley-required' => 'true', 'accept' => '.json']) }}
                                        </div>

                                        <div class="col-sm-2 col-md-12  form-group mandatory">
                                            {{ Form::label('file', __('File For Web'), ['class' => 'form-label text-center', 'accept' => '.json.*']) }}
                                            {{ Form::file('web_file', ['class' => 'form-control', 'data-parsley-required' => 'true', 'accept' => '.json']) }}
                                        </div>

                                        <div class="col-sm-1 col-md-4">
                                            {{ Form::label('file', __('Sample for Admin'), ['class' => 'col-form-label text-center']) }}
                                            <div class="form-check form-switch col-12" style='padding-right:12.5rem;'>
                                                <a class="btn icon btn-primary btn-sm rounded-pill" href="{{ route('language.download.panel.json') }}" title="Edit">
                                                    <i class="bi bi-download"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-sm-1 col-md-4">
                                            {{ Form::label('file', __('Sample For App'), ['class' => 'col-form-label text-center']) }}
                                            <div class="form-check form-switch col-12" style='padding-right:12.5rem;'>
                                                <a class="btn icon btn-primary btn-sm rounded-pill" href="{{ route('language.download.app.json') }}" title="Edit">
                                                    <i class="bi bi-download"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-sm-1 col-md-4">
                                            {{ Form::label('file', __('Sample For Web'), ['class' => 'col-form-label text-center']) }}
                                            <div class="form-check form-switch col-12" style='padding-right:12.5rem;'>
                                                <a class="btn icon btn-primary btn-sm rounded-pill" href="{{ route('language.download.web.json') }}" title="Edit">
                                                    <i class="bi bi-download"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 d-flex justify-content-end mt-3">
                                            {{ Form::submit(__('Save'), ['class' => 'btn btn-primary me-1 mb-1']) }}
                                        </div>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <table class="table-light table-striped" aria-describedby="mydesc" id="table_list"
                                       data-toggle="table" data-url="{{ route('language.show',1) }}" data-click-to-select="true"
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
                                        <th scope="col" data-field="name" data-sortable="false">{{ __('Name') }}</th>
                                        <th scope="col" data-field="name_in_english" data-sortable="false">{{ __('Name'). " (".__("in English").")" }}</th>
                                        <th scope="col" data-field="code" data-sortable="true">{{ __('Language Code') }}</th>
                                        <th scope="col" data-field="rtl_text" data-sortable="true">{{ __('RTL') }}
                                        <th scope="col" data-field="image" data-sortable="false" data-formatter="imageFormatter">{{ __('Image') }}
                                        <th scope="col" data-field="operate" data-escape="false" data-sortable="false" data-events="languageEvents">{{ __('Action') }}</th>
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

    <!-- EDIT MODEL MODEL -->
    <div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="#" class="form-horizontal" id="edit-form" enctype="multipart/form-data" method="POST" data-parsley-validate>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">{{ __('Edit Language') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-md-12 col-12">
                                    <div class="form-group mandatory">
                                        <label for="edit_name" class="form-label col-12">{{ __('Language Name') }}</label>
                                        <input type="text" id="edit_name" class="form-control col-12" placeholder="{{__("Name")}}" name="name" data-parsley-required="true">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="col-md-12 col-12">
                                    <div class="form-group mandatory">
                                        <label for="edit_name_in_english" class="form-label col-12">{{ __('Language Name') }}({{__("in English")}})</label>
                                        <input type="text" id="edit_name_in_english" class="form-control col-12" placeholder="{{__("Name")}}" name="name_in_english" data-parsley-required="true">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="col-md-12 col-12">
                                    <div class="form-group mandatory">
                                        <label for="edit_code" class="form-label col-12">{{ __('Language Code') }}</label>
                                        <input type="text" id="edit_code" class="form-control col-12" placeholder="{{__("Language Code")}}" name="code" data-parsley-required="true">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 form-group">
                                <label class="col-form-label ">{{ __('Image') }}</label>
                                <div class="">
                                    <input class="filepond" type="file" name="image" id="edit_image">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="edit_panel_file" class="form-label col-12">{{ __('File For Admin Panel') }}</label>
                                        <input type="file" id="edit_panel_file" class="form-control col-12" name="panel_file">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="edit_app_file" class="form-label col-12">{{ __('File For App') }}</label>
                                        <input type="file" id="edit_app_file" class="form-control col-12" name="app_file">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="edit_web_file" class="form-label col-12">{{ __('File For Web') }}</label>
                                        <input type="file" id="edit_web_file" class="form-control col-12" name="web_file">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="col-md-12 col-12">
                                    <div class="form-group form-check form-switch">
                                        <label for="edit_rtl" class="form-label col-12">{{ __('RTL') }}</label>
                                        <input type="hidden" value="0" name="rtl" id="edit_rtl">
                                        <input type="checkbox" class="form-check-input status-switch" id="edit_rtl_switch" aria-label="edit_rtl">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('Save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
