@extends('layouts.main')

@section('title')
    {{ __('System Settings') }}
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
        <form class="create-form-without-reset" action="{{route('settings.store') }}" method="post" enctype="multipart/form-data" data-success-function="successFunction" data-parsley-validate>
            @csrf
            <div class="row d-flex mb-3">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="divider pt-3">
                                <h6 class="divider-text">{{ __('Company Details') }}</h6>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 form-group mandatory">
                                    <label for="company_name" class="col-sm-6 col-md-6 form-label mt-1">{{ __('Company Name') }}</label>
                                    <input name="company_name" type="text" class="form-control" id="company_name" placeholder="{{ __('Company Name') }}" value="{{ $settings['company_name'] ?? '' }}" required>
                                </div>
                                <div class="col-sm-12 form-group mandatory">
                                    <label for="company_email" class="col-sm-12 col-md-6 form-label mt-1">{{ __('Email') }}</label>
                                    <input id="company_email" name="company_email" type="email" class="form-control" placeholder="{{ __('Email') }}" value="{{ $settings['company_email'] ?? '' }}" required>
                                </div>

                                <div class="col-sm-12 form-group mandatory">
                                    <label for="company_tel1" class="col-sm-12 col-md-6 form-label mt-1">{{ __('Contact Number')." 1" }}</label>
                                    <input id="company_tel1" name="company_tel1" type="text" class="form-control" placeholder="{{ __('Contact Number')." 1" }}" maxlength="16" onKeyDown="if(this.value.length==16 && event.keyCode!=8) return false;" value="{{ $settings['company_tel1'] ?? '' }}" required>
                                </div>

                                <div class="col-sm-12">
                                    <label for="company_tel2" class="col-sm-12 col-md-6 form-label mt-1">{{ __('Contact Number')." 2" }}</label>
                                    <input id="company_tel2" name="company_tel2" type="text" class="form-control" placeholder="{{ __('Contact Number')." 2" }}" maxlength="16" onKeyDown="if(this.value.length==16 && event.keyCode!=8) return false;" value="{{ $settings['company_tel2'] ?? '' }}">
                                </div>

                                <div class="col-sm-12">
                                    <label for="company_address" class="col-sm-12 col-md-6 form-label mt-1">{{ __('Address') }}</label>
                                    <textarea id="company_address" name="company_address" type="text" class="form-control" placeholder="{{ __('Address') }}">{{ $settings['company_address'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="divider pt-3">
                                <h6 class="divider-text">{{ __('More Setting') }}</h6>
                            </div>

                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6 col-xs-12 mandatory">
                                    <label for="default_language" class="form-label ">{{ __('Default Language') }}</label>
                                    <select name="default_language" id="default_language" class="form-select form-control-sm">
                                        @foreach ($languages as $row)
                                            {{ $row }}
                                            <option value="{{ $row->code }}"
                                                {{ $settings['default_language'] == $row->code ? 'selected' : '' }}>
                                                {{ $row->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-12 col-md-6 col-xs-12 mandatory">
                                    <label for="currency_symbol" class="form-label">{{ __('Currency Symbol') }}</label>
                                    <input id="currency_symbol" name="currency_symbol" type="text" class="form-control" placeholder="{{ __('Currency Symbol') }}" value="{{ $settings['currency_symbol'] ?? '' }}" required="">
                                </div>

                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="android_version" class="form-label ">{{ __('Android Version') }}</label>
                                    <input id="android_version" name="android_version" type="text" class="form-control" placeholder="{{ __('Android Version') }}" value="{{ $settings['android_version']?? '' }}" required="">
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="play_store_link" class="form-label ">{{ __('Play Store Link') }}</label>
                                    <input id="play_store_link" name="play_store_link" type="url" class="form-control" placeholder="{{ __('Play Store Link') }}" value="{{ $settings['play_store_link'] ?? '' }}">
                                </div>


                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="ios_version" class="form-label ">{{ __('IOS Version') }}</label>
                                    <input id="ios_version" name="ios_version" type="text" class="form-control" placeholder="{{ __('IOS Version') }}" value="{{ $settings['ios_version'] ?? '' }}" required="">
                                </div>

                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="app_store_link" class="form-label ">{{ __('App Store Link') }}</label>
                                    <input id="app_store_link" name="app_store_link" type="url" class="form-control" placeholder="{{ __('App Store Link') }}" value="{{ $settings['app_store_link'] ?? '' }}">
                                </div>


                                <div class="form-group col-sm-12 col-md-4">
                                    <label class="form-label ">{{ __('Maintenance Mode') }}</label>
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="maintenance_mode" id="maintenance_mode" class="checkbox-toggle-switch-input" value="{{ $settings['maintenance_mode'] ?? 0 }}">
                                        <input class="form-check-input checkbox-toggle-switch" type="checkbox" role="switch" {{ $settings['maintenance_mode'] == '1' ? 'checked' : '' }} id="switch_maintenance_mode">
                                        <label class="form-check-label" for="switch_maintenance_mode"></label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-12 col-md-4">
                                    <label class="form-label">{{ __('Force Update') }}</label>
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="force_update" id="force_update" class="checkbox-toggle-switch-input" value="{{ $settings['force_update'] ?? 0 }}">
                                        <input class="form-check-input checkbox-toggle-switch" type="checkbox" role="switch" {{ $settings['force_update'] == '1' ? 'checked' : '' }}id="switch_force_update">
                                        <label class="form-check-label" for="switch_force_update"></label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-12 col-md-4">
                                    <label class="form-check-label">{{ __('Number With Suffix') }}</label>
                                    <div class="form-check form-switch  ">
                                        <input type="hidden" name="number_with_suffix" id="number_with_suffix" class="checkbox-toggle-switch-input" value="{{ $settings['number_with_suffix'] ?? 0 }}">
                                        <input class="form-check-input checkbox-toggle-switch" type="checkbox" role="switch" {{ $settings['number_with_suffix'] == '1' ? 'checked' : '' }} id="switch_number_with_suffix" aria-label="switch_number_with_suffix">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="divider pt-3">
                                <h6 class="divider-text">{{ __('FCM Notification Settings') }}</h6>
                            </div>
                            <div class="form-group row mt-3">
                                <div class="col-md-6 col-sm-12">
                                    <label for="firebase_project_id" class="form-label">{{ __('Firebase Project Id') }}</label>
                                    <input type="text" id="firebase_project_id" name="firebase_project_id" class="form-control" placeholder="{{ __('Firebase Project Id') }}" value="{{ $settings['firebase_project_id'] ?? '' }}"/>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <label for="service_file" class="form-label">{{ __('Service Json File') }}</label><span style="color: #00B2CA">(Accept only Json File)</span>
                                    <input id="service_file" name="service_file" type="file" class="form-control">
                                    <p style="display: none" id="img_error_msg" class="badge rounded-pill bg-danger"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="divider pt-3">
                        <h6 class="divider-text">{{ __('Images') }}</h6>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4 col-sm-12">
                            <label class=" col-form-label ">{{ __('Favicon Icon') }}</label>
                            <input class="filepond" type="file" name="favicon_icon" id="favicon_icon">
                            <img src="{{ $settings['favicon_icon'] ?? '' }}" data-custom-image="{{asset('assets/images/logo/favicon.png')}}" class="mt-2 favicon_icon" alt="image" style=" height: 31%;width: 21%;">
                        </div>

                        <div class="form-group col-md-4 col-sm-12">
                            <label class="form-label ">{{ __('Company Logo') }}</label>
                            <input class="filepond" type="file" name="company_logo" id="company_logo">
                            <img src="{{ $settings['company_logo'] ?? '' }}" data-custom-image="{{asset('assets/images/logo/logo.png')}}" class="mt-2 company_logo" alt="image" style="height: 31%;width: 21%;">
                        </div>

                        <div class="form-group col-md-4 col-sm-12">
                            <label class="form-label ">{{ __('Login Page Image') }}</label>
                            <input class="filepond" type="file" name="login_image" id="login_image">
                            <img src="{{ $settings['login_image'] ?? ''  }}" data-custom-image="{{asset('assets/images/bg/login.jpg')}}" class="mt-2 login_image" alt="image" style="height: 31%;width: 21%;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="divider pt-3">
                        <h6 class="divider-text">{{ __('Web Settings') }}</h6>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="web_theme_color" class="form-label ">{{ __('Theme Color') }}</label>
                            <input id="web_theme_color" name="web_theme_color" type="color" class="form-control form-control-color" placeholder="{{ __('Theme Color') }}" value="{{ $settings['web_theme_color'] ?? '' }}">
                        </div>

                        <div class="form-group col-md-6 col-sm-12">
                            <label for="place_api_key" class="form-label ">{{ __('Place API Key') }}</label>
                            <input class="form-control" type="text" name="place_api_key" id="place_api_key" value="{{ $settings['place_api_key'] ?? '' }}">
                        </div>

                        <div class="form-group col-md-6 col-sm-12">
                            <label class="form-label ">{{ __('Header Logo') }}</label>
                            <input class="filepond" type="file" name="header_logo" id="header_logo">
                            <img src="{{ $settings['header_logo'] ?? '' }}" data-custom-image="{{asset('assets/images/logo/Header Logo.svg')}}" class="w-25" alt="image">
                        </div>

                        <div class="form-group col-md-6 col-sm-12">
                            <label class="form-label ">{{ __('Footer Logo') }}</label>
                            <input class="filepond" type="file" name="footer_logo" id="footer_logo">
                            <img src="{{ $settings['footer_logo'] ?? '' }}" data-custom-image="{{asset('assets/images/logo/Footer logo.svg')}}" class="w-25" alt="image">
                        </div>

                        <div class="form-group col-md-6 col-sm-12">
                            <label class="form-label ">{{ __('Placeholder image') }} <small>(This image will be displayed if no image is available.)</small></label>
                            <input class="filepond" type="file" name="placeholder_image" id="placeholder_image">
                            <img src="{{ $settings['placeholder_image'] ?? '' }}" data-custom-image="{{asset('assets/images/logo/favicon.png')}}" alt="image" style="height: 31%;width: 21%;">
                        </div>


                        <div class="form-group col-md-6 col-sm-12">
                            <label for="footer_description" class="form-label ">{{ __('Footer Description') }}</label>
                            <textarea id="footer_description" name="footer_description" class="form-control" rows="5" placeholder="{{ __('Footer Description') }}">{{ $settings['footer_description'] ?? '' }}</textarea>
                        </div>

                        <div class="form-group col-md-6 col-sm-12">
                            <label for="google_map_iframe_link" class="form-label ">{{ __('Google Map Iframe Link') }}</label>
                            <textarea id="google_map_iframe_link" name="google_map_iframe_link" type="text" class="form-control" rows="5" placeholder="{{ __('Google Map Iframe Link') }}">{{ $settings['google_map_iframe_link'] ?? '' }}</textarea>
                        </div>

                        <div class="form-group col-md-6 col-sm-12">
                            <label for="google_map_iframe_link" class="form-label ">{{ __('Default Latitude & Longitude') }} <small>(For Default Location Selection)</small></label>
                            <div class="form-group">
                                <label for="default_latitude" class="form-label ">{{ __('Latitude') }}</label>
                                <input id="default_latitude" name="default_latitude" type="text" class="form-control" placeholder="{{ __('Latitude') }}" value="{{ $settings['default_latitude'] ?? '' }}">

                                <label for="default_longitude" class="form-label ">{{ __('Longitude') }}</label>
                                <input id="default_longitude" name="default_longitude" type="text" class="form-control" placeholder="{{ __('Longitude') }}" value="{{ $settings['default_longitude'] ?? '' }}">
                            </div>


                        </div>

                        <div class="divider pt-3">
                            <h6 class="divider-text">{{ __('Social Media Links') }}</h6>
                        </div>
                        <div class="form-group col-sm-12 col-md-4">
                            <label for="instagram_link" class="form-label ">{{ __('Instagram Link') }}</label>
                            <input id="instagram_link" name="instagram_link" type="url" class="form-control" placeholder="{{ __('Instagram Link') }}" value="{{ $settings['instagram_link'] ?? '' }}">
                        </div>
                        <div class="form-group col-sm-12 col-md-4">
                            <label for="x_link" class="form-label ">{{ __('X Link') }}</label>
                            <input id="x_link" name="x_link" type="url" class="form-control" placeholder="{{ __('X Link') }}" value="{{ $settings['x_link'] ?? '' }}">
                        </div>
                        <div class="form-group col-sm-12 col-md-4">
                            <label for="facebook_link" class="form-label ">{{ __('Facebook Link') }}</label>
                            <input id="facebook_link" name="facebook_link" type="url" class="form-control" placeholder="{{ __('Facebook Link') }}" value="{{ $settings['facebook_link'] ?? '' }}">
                        </div>
                        <div class="form-group col-sm-12 col-md-4">
                            <label for="linkedin_link" class="form-label ">{{ __('Linkedin Link') }}</label>
                            <input id="linkedin_link" name="linkedin_link" type="url" class="form-control" placeholder="{{ __('Linkedin Link') }}" value="{{ $settings['linkedin_link'] ?? '' }}">
                        </div>
                        <div class="form-group col-sm-12 col-md-4">
                            <label for="pinterest_link" class="form-label ">{{ __('Pinterest Link') }}</label>
                            <input id="pinterest_link" name="pinterest_link" type="url" class="form-control" placeholder="{{ __('Pinterest Link') }}" value="{{ $settings['pinterest_link'] ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 d-flex justify-content-end">
                <button type="submit" value="btnAdd" class="btn btn-primary me-1 mb-3">{{ __('Save') }}</button>
            </div>
        </form>
    </section>
@endsection
@section('js')
    <script>
        function successFunction() {
            window.location.reload();
        }
    </script>
@endsection
