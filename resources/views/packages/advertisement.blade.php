@extends('layouts.main')

@section('title')
    {{ __('Advertisement Package') }}
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
            @can('advertisement-package-create')
                <div class="col-md-4">
                    <div class="card">
                        {!! Form::open(['route' => 'package.advertisement.store', 'data-parsley-validate', 'files' => true,'class'=>'create-form']) !!}

                        <div class="card-body">
                            <div class="row ">
                                <div class="col-md-12 col-12 form-group mandatory">
                                    {{ Form::label('name', __('Name'), ['class' => 'form-label col-12 ']) }}
                                    {{ Form::text('name', '', [
                                        'class' => 'form-control ',
                                        'placeholder' => __('Package Name'),
                                        'data-parsley-required' => 'true',
                                        'id' => 'name',
                                    ]) }}
                                </div>

                                <div class="col-md-12 col-12 form-group">
                                    {{ Form::label('ios_product_id', __('IOS Product ID'), ['class' => 'form-label col-12 ']) }}
                                    {{ Form::text('ios_product_id', '', [
                                        'class' => 'form-control ',
                                        'placeholder' => __("IOS Product ID"),
                                        'id' => 'ios_product_id',
                                    ]) }}
                                </div>

                                <div class="col-md-6 col-12 form-group mandatory">
                                    {{ Form::label('price', __('Price') . ' (' . $currency_symbol . ')', [
                                        'class' => 'form-label col-12 ',
                                    ]) }}
                                    {{ Form::number('price', 0, [
                                        'class' => 'form-control ',
                                        'placeholder' => __('Package Price'),
                                        'data-parsley-required' => 'true',
                                        'id' => 'price',
                                        'min' => '0',
                                        'step'=>0.01,
                                        'data-parsley-field-name'=>'price',

                                    ]) }}
                                </div>

                                <div class="col-md-6 col-12 form-group mandatory">
                                    {{ Form::label('discount_in_percentage', __('Discount') . ' (%)', [
                                        'class' => 'form-label col-12 ',
                                    ]) }}
                                    {{ Form::number('discount_in_percentage', 0, [
                                        'class' => 'form-control ',
                                        'placeholder' => __('Package Price'),
                                        'data-parsley-required' => 'true',
                                        'id' => 'discount_in_percentage',
                                        'min' => '0',
                                        'max'=>'100',
                                        'step'=>0.01,
                                        'data-parsley-field-name'=>'price',
                                    ]) }}
                                </div>

                                <div class="col-md-12 col-12 form-group mandatory">
                                    {{ Form::label('price', __('Final Price') . ' (' . $currency_symbol . ')', [
                                        'class' => 'form-label col-12' ,
                                    ]) }}
                                    {{ Form::number('final_price', 0, [
                                        'class' => 'form-control ',
                                        'placeholder' => __('Stripped Price'),
                                        'data-parsley-required' => 'true',
                                        'id' => 'final_price',
                                        'min' => '0',
                                        'step'=>0.01
                                    ]) }}
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-12 form-group mandatory">
                                    <label for="icon" class="mandatory form-label">{{ __('Image') }}</label>
                                    <input type="file" name="icon" id="icon" class="form-control" data-parsley-required="true" accept=".jpg,.jpeg,.png">
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12">
                                <div class="col-md-12 col-sm-12 form-group mandatory">
                                    <label for="w3review" class="mandatory form-label">{{ __('Description') }}</label>
                                    <textarea id="w3review" class="form-control" name="description" rows="3" cols="48" data-parsley-required="true"></textarea>
                                </div>
                            </div>

                            <div id="duration_limitation" class="col-md-12 col-sm-12 form-group">
                                <div class="row">
                                    {{ Form::label('duration', __('Days'), ['class' => 'form-label col-12 ']) }}
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text myDivClass" style="height: 42px;">
                                                <span class="mySpanClass">{{__("Days")}}</span>
                                            </div>
                                        </div>
                                        {{ Form::number('duration', '', [
                                            'class' => 'form-control',
                                            'type' => 'number',
                                            'min' => '1',
                                            'placeholder' => __('Unlimited'),
                                            'id' => 'durationLimit',
                                            'style' => 'height: 42px;',
                                        ]) }}
                                    </div>
                                </div>
                            </div>

                            <div id="limit" class="col-md-12 col-sm-12 form-group">
                                <div class="row">
                                    {{ Form::label('limit', __('Item Limit'), ['class' => 'form-label col-12 ']) }}
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text myDivClass" style="height: 42px;">
                                                <span class="mySpanClass">{{__("Number")}}</span>
                                            </div>
                                        </div>
                                        {{ Form::number('item_limit', '', [
                                            'class' => 'form-control',
                                            'type' => 'number',
                                            'min' => '1',
                                            'placeholder' => __('Unlimited'),
                                            'id' => 'durationForLimit',
                                            'style' => 'height: 42px;',
                                        ]) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-12 text-end form-group pt-4">
                                {{ Form::submit(__('Add Package'), ['class' => 'center btn btn-primary', 'style' => 'width:200']) }}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            @endcan
            <div class="{{\Illuminate\Support\Facades\Auth::user()->can('advertisement-package-create') ? "col-md-8" : "col-md-12"}}">
                <div class="card">
                    <div class="card-body">

                        {{-- <div class="row " id="toolbar"> --}}
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-borderless table-striped" aria-describedby="mydesc"
                                       id="table_list" data-toggle="table" data-url="{{ route('package.advertisement.show') }}"
                                       data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                       data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true"
                                       data-search-align="right" data-toolbar="#toolbar" data-show-columns="true"
                                       data-show-refresh="true" data-fixed-columns="true" data-fixed-number="1"
                                       data-fixed-right-number="1" data-trim-on-search="false" data-responsive="true"
                                       data-sort-name="id" data-sort-order="desc" data-pagination-successively-size="3"
                                       data-escape="true"
                                       data-query-params="queryParams" data-table="packages"
                                       data-show-export="true" data-export-options='{"fileName": "advertisement-package-list","ignoreColumn": ["operate"]}' data-export-types="['pdf','json', 'xml', 'csv', 'txt', 'sql', 'doc', 'excel']"
                                       data-mobile-responsive="true">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col" data-field="id" data-align="center" data-sortable="true">{{ __('ID') }}</th>
                                        <th scope="col" data-field="icon" data-formatter="imageFormatter" data-align="center" data-sortable="false">{{ __('Image') }}</th>
                                        <th scope="col" data-field="name" data-align="center" data-sortable="true">{{ __('Name') }}</th>
                                        <th scope="col" data-field="price" data-align="center" data-sortable="true">{{ __('Price') }}</th>
                                        <th scope="col" data-field="discount_in_percentage" data-align="center" data-sortable="true">{{ __('Discount in(%)') }}</th>
                                        <th scope="col" data-field="final_price" data-align="center" data-sortable="true">{{ __('Final Price') }}</th>
                                        <th scope="col" data-field="description" data-align="center" data-sortable="true" data-visible="false">{{ __('Description') }}</th>
                                        <th scope="col" data-field="duration" data-align="center" data-sortable="true">{{ __('Days') }}</th>
                                        <th scope="col" data-field="item_limit" data-align="center" data-sortable="true">{{ __('Item Limit') }}</th>
                                        <th scope="col" data-field="ios_product_id" data-align="center" data-sortable="true" data-visible="false">{{ __('IOS Product ID') }}</th>
                                        @can('item-listing-package-update')
                                            <th scope="col" data-field="status" data-sortable="true" data-align="center" data-width="5%" data-formatter="statusSwitchFormatter">{{ __('Status') }}</th>
                                            <th scope="col" data-field="operate" data-escape="false" data-align="center" data-sortable="false" data-events="advertisementPackageEvents">{{ __('Action') }}</th>
                                        @endcan
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- EDIT MODEL MODEL -->
        <div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">{{ __('Edit Package') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" class="edit-form form-horizontal" enctype="multipart/form-data" method="POST" data-parsley-validate>
                        <div class="modal-body">
                            {{ csrf_field() }}
                            <input type="hidden" id="edit_id" name="edit_id">
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group mandatory">
                                        <label for="edit_name" class="form-label col-12 ">{{ __('Name') }}</label>
                                        <input type="text" id="edit_name" class="form-control col-12" placeholder="{{__("Name")}}" name="name" data-parsley-required="true">
                                    </div>
                                </div>
                                <div class="col-md-12 col-12 form-group">
                                    {{ Form::label('ios_product_id', __('IOS Product ID'), ['class' => 'form-label col-12 ']) }}
                                    {{ Form::text('ios_product_id', '', [
                                        'class' => 'form-control ',
                                        'placeholder' => __("IOS Product ID"),
                                        'id' => 'edit_ios_product_id',
                                    ]) }}
                                </div>

                                <div class="col-md-12 col-12 form-group mandatory">
                                    {{ Form::label('price', __('Price') . '(' . $currency_symbol . ')', [
                                        'class' => 'form-label col-12 ',
                                    ]) }}
                                    {{ Form::number('price', '', [
                                        'class' => 'form-control ',
                                        'placeholder' => __('Price'),
                                        'data-parsley-required' => 'true',
                                        'id' => 'edit_price',
                                        'step'=>0.01,
                                        'min' => '0',
                                    ]) }}
                                </div>

                                <div class="col-md-12 col-12 form-group mandatory">
                                    {{ Form::label('discount_in_percentage', __('Discount') . ' (%)', [
                                        'class' => 'form-label col-12 ',
                                    ]) }}
                                    {{ Form::number('discount_in_percentage', 0, [
                                        'class' => 'form-control ',
                                        'placeholder' => __('Package Price'),
                                        'data-parsley-required' => 'true',
                                        'id' => 'edit_discount_in_percentage',
                                        'min' => '0',
                                        'max'=>'100',
                                        'step'=>0.01,
                                        'data-parsley-field-name'=>'price',
                                    ]) }}
                                </div>

                                <div class="col-md-12 col-12">
                                    <div class="form-group mandatory">
                                        <label for="edit_final_price" class="form-label col-12">{{__('Final Price') . '(' . $currency_symbol . ')'}}</label>
                                        <input type="text" id="edit_final_price" class="form-control col-12" min="0" placeholder="{{__('Final Price') . ' (' . $currency_symbol . ')'}}" name="final_price" data-parsley-required="true">
                                    </div>
                                </div>


                                <div class="col-md-12 form-group">
                                    <label for="Field Name" class="form-label">{{ __('Image') }}</label>
                                    <input type="file" name="icon" id="edit_image" class="form-control" accept=".jpg,.jpeg,.png">
                                </div>

                                <div id="edit_duration_limit" class="col-md-12 col-sm-12 form-group">
                                    <div class="row">
                                        {{ Form::label('duration', __('Days'), ['class' => 'form-label col-sm-12  col-md-12 ',]) }}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text myDivClass" style="height: 42px;">
                                                    <span class="mySpanClass">{{__("Number")}}</span>
                                                </div>
                                            </div>
                                            {{ Form::number('duration', '', [
                                            'class' => 'form-control',
                                            'type' => 'number',
                                            'min' => '1',
                                            'placeholder' => __('Unlimited'),
                                            'id' => 'edit_durationLimit',
                                            'style' => 'height: 42px;',
                                        ]) }}
                                        </div>
                                    </div>
                                </div>

                                <div id="edit_limit" class="col-md-12 col-sm-12 form-group">
                                    <div class="row">
                                        {{ Form::label('limit', __('Item Limit'), ['class' => 'form-label col-12 ']) }}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text myDivClass" style="height: 42px;">
                                                    <span class="mySpanClass">{{__("Number")}}</span>
                                                </div>
                                            </div>
                                            {{ Form::number('item_limit', '', [
                                                'class' => 'form-control',
                                                'type' => 'number',
                                                'min' => '1',
                                                'placeholder' => __('Unlimited'),
                                                'id' => 'edit_ForLimit',
                                                'style' => 'height: 42px;',
                                            ]) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 form-group mandatory">
                                    <label for="edit_description" class="mandatory form-label">{{ __('Description') }}</label>
                                    <textarea id="edit_description" name="description" class="form-control" rows="3" cols="48" data-parsley-required="true"></textarea>
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
    </section>
@endsection
