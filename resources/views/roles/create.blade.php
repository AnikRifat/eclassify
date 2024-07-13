@extends('layouts.main')

@section('title')
    {{ __('Create New Role') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('Create New Role') }}
            </h3>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="mb-2">
                    <a class="btn btn-primary" href="{{ route('roles.index') }}"> {{ __('Back') }}</a>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            {!! Form::open(['route' => 'roles.store', 'method' => 'POST','class'=>'create-form','data-success-function'=>'successFunction']) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('Name') }} <span class="text-danger">*</span></label>
                                        {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div id="permission-list">

                                </div>
                                <div class="permission-tree ms-5 my-3">
                                    <ul>
                                        @foreach ($groupedPermissions as $groupName=>$groupData)
                                            <li data-jstree='{"opened":true}'>{{ucwords(str_replace("-"," ",$groupName))}}
                                                @foreach ($groupData as $key=>$permission)
                                                    <ul>
                                                        <li id="{{$permission->id}}" data-name="{{$permission->name}}" data-jstree='{"icon":"fa fa-user-cog"}'>{{ucfirst($permission->short_name)}}</li>
                                                    </ul>
                                                @endforeach
                                                @endforeach
                                            </li>
                                    </ul>
                                </div>
                                {{--                                <div class="col-xs-12 col-sm-12 col-md-12">--}}
                                {{--                                    <label><strong>{{ __('permission') }}:</strong></label>--}}
                                {{--                                    <div class="row">--}}
                                {{--                                        @foreach ($groupedPermissions as $group)--}}
                                {{--                                            <div class="form-group col-lg-3 col-sm-12 col-xs-12 col-md-3">--}}
                                {{--                                                <div class="form-check">--}}
                                {{--                                                    <label class="form-check-label">--}}
                                {{--                                                        {{ Form::checkbox('permission[]', $value->id, false, ['class' => 'name form-check-input']) }}--}}
                                {{--                                                        {{ $value->name }}--}}
                                {{--                                                    </label>--}}
                                {{--                                                </div>--}}
                                {{--                                            </div>--}}
                                {{--                                        @endforeach--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        function successFunction() {
            $('.permission-tree').jstree(true).deselect_all();
        }
    </script>
@endsection
