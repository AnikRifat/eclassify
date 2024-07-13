@extends('layouts.main')
@section('title')
    {{__("Edit Tips")}}
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
        <div class="buttons">
            <a class="btn btn-primary" href="{{ route('tips.index') }}">< {{__("Back to All Tips")}} </a>
        </div>
        <div class="row">
            <form class="form-redirection" action="{{ route('tips.update',$tip->id) }}" method="POST" data-parsley-validate enctype="multipart/form-data" data-success-function="successFunction">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">{{__("Edit Tips")}}</div>

                        <div class="card-body mt-3">
                            <div class="row">
                                <div class="col-md-12 form-group mandatory">
                                    <label for="description" class="form-label">{{ __('Description') }}</label>
                                    <textarea name="description" id="description" class="form-control" cols="10" rows="5" required>{{$tip->description}}</textarea>
                                </div>
                            </div>

                            @if($languages->isNotEmpty())
                                <hr>
                                <h5>{{__("Translation")}}</h5>
                                <div class="row">
                                    @foreach($languages as $key=>$language)
                                        <hr>
                                        <h5>{{($key+1).". ".$language->name}}</h5>
                                        <div class="col-md-12 form-group">
                                            <label for="description" class="form-label">{{ __('Description') }} : </label>
                                            <textarea name="translations[{{$language->id}}]" id="description" class="form-control" cols="10" rows="5" required>{{$translations[$language->id]??''}}</textarea>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12 text-end">
                        <input type="submit" class="btn btn-primary" value="{{__("Save and Back")}}">
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
@section('js')
    <script>
        function successFunction() {
            setTimeout(function () {
                window.location.href = "{{ route('tips.index') }}";
            }, 1000)
        }
    </script>
@endsection
