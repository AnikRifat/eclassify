@extends('layouts.main')

@section('title')
    {{ __('Payment Gateways Settings') }}
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
        <form class="create-form-without-reset" action="{{ route('settings.payment-gateway.store') }}" method="post" enctype="multipart/form-data">
            <div class="row d-flex mb-3">

                {{--Stripe Payment Gateway START--}}
                <div class="col-md-6 mt-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="divider pt-3">
                                <h6 class="divider-text">{{ __('Stripe Setting') }}</h6>
                            </div>

                            <div class="form-group row mt-3">
                                <div class="col-sm-12 mt-2">
                                    <label for="stripe_currency_code" class="col-sm-12 form-check-label  mt-2">{{ __('Stripe Currency Symbol') }}</label>
                                    <select name="gateway[Stripe][currency_code]" id="stripe_currency_code" class="select2 form-select form-control-sm">
                                        <option value="USD">USD</option>
                                        <option value="AED">AED</option>
                                        <option value="AFN">AFN</option>
                                        <option value="ALL">ALL</option>
                                        <option value="AMD">AMD</option>
                                        <option value="ANG">ANG</option>
                                        <option value="AOA">AOA</option>
                                        <option value="ARS">ARS</option>
                                        <option value="AUD">AUD</option>
                                        <option value="AWG">AWG</option>
                                        <option value="AZN">AZN</option>
                                        <option value="BAM">BAM</option>
                                        <option value="BBD">BBD</option>
                                        <option value="BDT">BDT</option>
                                        <option value="BGN">BGN</option>
                                        <option value="BMD">BMD</option>
                                        <option value="BND">BND</option>
                                        <option value="BOB">BOB</option>
                                        <option value="BRL">BRL</option>
                                        <option value="BSD">BSD</option>
                                        <option value="BWP">BWP</option>
                                        <option value="BYN">BYN</option>
                                        <option value="BZD">BZD</option>
                                        <option value="CAD">CAD</option>
                                        <option value="CDF">CDF</option>
                                        <option value="CHF">CHF</option>
                                        <option value="CNY">CNY</option>
                                        <option value="COP">COP</option>
                                        <option value="CRC">CRC</option>
                                        <option value="CVE">CVE</option>
                                        <option value="CZK">CZK</option>
                                        <option value="DKK">DKK</option>
                                        <option value="DOP">DOP</option>
                                        <option value="DZD">DZD</option>
                                        <option value="EGP">EGP</option>
                                        <option value="ETB">ETB</option>
                                        <option value="EUR">EUR</option>
                                        <option value="FJD">FJD</option>
                                        <option value="FKP">FKP</option>
                                        <option value="GBP">GBP</option>
                                        <option value="GEL">GEL</option>
                                        <option value="GIP">GIP</option>
                                        <option value="GMD">GMD</option>
                                        <option value="GTQ">GTQ</option>
                                        <option value="GYD">GYD</option>
                                        <option value="HKD">HKD</option>
                                        <option value="HNL">HNL</option>
                                        <option value="HTG">HTG</option>
                                        <option value="HUF">HUF</option>
                                        <option value="IDR">IDR</option>
                                        <option value="ILS">ILS</option>
                                        <option value="INR">INR</option>
                                        <option value="ISK">ISK</option>
                                        <option value="JMD">JMD</option>
                                        <option value="KES">KES</option>
                                        <option value="KGS">KGS</option>
                                        <option value="KHR">KHR</option>
                                        <option value="KYD">KYD</option>
                                        <option value="KZT">KZT</option>
                                        <option value="LAK">LAK</option>
                                        <option value="LBP">LBP</option>
                                        <option value="LKR">LKR</option>
                                        <option value="LRD">LRD</option>
                                        <option value="LSL">LSL</option>
                                        <option value="MAD">MAD</option>
                                        <option value="MDL">MDL</option>
                                        <option value="MKD">MKD</option>
                                        <option value="MMK">MMK</option>
                                        <option value="MNT">MNT</option>
                                        <option value="MOP">MOP</option>
                                        <option value="MUR">MUR</option>
                                        <option value="MVR">MVR</option>
                                        <option value="MWK">MWK</option>
                                        <option value="MXN">MXN</option>
                                        <option value="MYR">MYR</option>
                                        <option value="MZN">MZN</option>
                                        <option value="NAD">NAD</option>
                                        <option value="NGN">NGN</option>
                                        <option value="NIO">NIO</option>
                                        <option value="NOK">NOK</option>
                                        <option value="NPR">NPR</option>
                                        <option value="NZD">NZD</option>
                                        <option value="PAB">PAB</option>
                                        <option value="PEN">PEN</option>
                                        <option value="PGK">PGK</option>
                                        <option value="PHP">PHP</option>
                                        <option value="PKR">PKR</option>
                                        <option value="PLN">PLN</option>
                                        <option value="QAR">QAR</option>
                                        <option value="RON">RON</option>
                                        <option value="RSD">RSD</option>
                                        <option value="RUB">RUB</option>
                                        <option value="SAR">SAR</option>
                                        <option value="SBD">SBD</option>
                                        <option value="SCR">SCR</option>
                                        <option value="SEK">SEK</option>
                                        <option value="SGD">SGD</option>
                                        <option value="SHP">SHP</option>
                                        <option value="SLE">SLE</option>
                                        <option value="SOS">SOS</option>
                                        <option value="SRD">SRD</option>
                                        <option value="STD">STD</option>
                                        <option value="SZL">SZL</option>
                                        <option value="THB">THB</option>
                                        <option value="TJS">TJS</option>
                                        <option value="TOP">TOP</option>
                                        <option value="TRY">TRY</option>
                                        <option value="TTD">TTD</option>
                                        <option value="TWD">TWD</option>
                                        <option value="TZS">TZS</option>
                                        <option value="UAH">UAH</option>
                                        <option value="UYU">UYU</option>
                                        <option value="UZS">UZS</option>
                                        <option value="WST">WST</option>
                                        <option value="XCD">XCD</option>
                                        <option value="YER">YER</option>
                                        <option value="ZAR">ZAR</option>
                                        <option value="ZMW">ZMW</option>
                                    </select>
                                </div>

                                <label for="stripe_secret_key" class="col-sm-12 form-check-label  mt-2">{{ __('Stripe Secret key') }}</label>
                                <div class="col-sm-12 mt-2">
                                    <input id="stripe_secret_key" name="gateway[Stripe][secret_key]" type="text" class="form-control" placeholder="{{ __('Stripe Secret key') }}" value="{{ $paymentGateway["Stripe"]['secret_key'] ?? '' }}" required>
                                </div>

                                <label for="stripe_publishable_key" class="col-sm-12 form-check-label  mt-2">{{ __('Stripe Publishable key') }}</label>
                                <div class="col-sm-12 mt-2">
                                    <input id="stripe_publishable_key" name="gateway[Stripe][api_key]" type="text" class="form-control" placeholder="{{ __('Stripe Publishable key') }}" value="{{ $paymentGateway["Stripe"]['api_key'] ?? '' }}" required>
                                </div>

                                <label for="stripe_webhook_secret" class="col-sm-12 form-check-label  mt-2">{{ __('Stripe Webhook Secret') }}</label>
                                <div class="col-sm-12 mt-2">
                                    <input id="stripe_webhook_secret" name="gateway[Stripe][webhook_secret_key]" type="text" class="form-control" placeholder="{{ __('Stripe Webhook Secret') }}" value="{{ $paymentGateway["Stripe"]['webhook_secret_key'] ?? '' }}" required>
                                </div>

                                <label for="stripe_webhook_url" class="col-sm-12 form-check-label  mt-2">{{ __('Stripe Webhook URL') }}</label>
                                <div class="col-sm-12 mt-2">
                                    <input id="stripe_webhook_url" name="gateway[Stripe][webhook_url]" type="text" class="form-control" placeholder="{{ __('Stripe Webhook URL') }}" value="{{ url('/webhook/stripe') }}" disabled>
                                </div>

                                <label class="col-sm-12 form-check-label  mt-2" id='lbl_stripe'>{{__("Status")}}</label>
                                <div class="col-sm-2 col-md-12 col-xs-12  mt-2">
                                    <div class="form-check form-switch ">
                                        <input type="hidden" name="gateway[Stripe][status]" id="stripe_gateway" value="{{ $paymentGateway["Stripe"]['status'] ?? 0 }}">
                                        <input class="form-check-input switch-input status-switch" type="checkbox" role="switch" name='op' {{ isset($paymentGateway["Stripe"]['status']) && $paymentGateway["Stripe"]['status'] == '1' ? 'checked' : '' }} id="switch_stripe_gateway" aria-label="switch_stripe_gateway">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                {{--Stripe Payment Gateway END--}}

                {{--Razorpay Payment Gateway START--}}
                <div class="col-md-6 mt-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="divider pt-3">
                                <h6 class="divider-text">{{ __('Razorpay Setting') }}</h6>
                            </div>

                            <div class="form-group row mt-3">
                                <div class="col-sm-12 mt-2">
                                    <label for="razorpay_currency_code" class="col-sm-12 form-check-label  mt-2">{{ __('Razorpay Currency Symbol') }}</label>
                                    <select name="gateway[Razorpay][currency_code]" id="razorpay_currency_code" class="select2 form-select form-control-sm">
                                        <option value="AED">AED</option>
                                        <option value="ALL">ALL</option>
                                        <option value="AMD">AMD</option>
                                        <option value="ARS">ARS</option>
                                        <option value="AUD">AUD</option>
                                        <option value="AWG">AWG</option>
                                        <option value="AZN">AZN</option>
                                        <option value="BAM">BAM</option>
                                        <option value="BBD">BBD</option>
                                        <option value="BDT">BDT</option>
                                        <option value="BGN">BGN</option>
                                        <option value="BHD">BHD</option>
                                        <option value="BIF">BIF</option>
                                        <option value="BMD">BMD</option>
                                        <option value="BND">BND</option>
                                        <option value="BOB">BOB</option>
                                        <option value="BRL">BRL</option>
                                        <option value="BSD">BSD</option>
                                        <option value="BTN">BTN</option>
                                        <option value="BWP">BWP</option>
                                        <option value="BZD">BZD</option>
                                        <option value="CAD">CAD</option>
                                        <option value="CHF">CHF</option>
                                        <option value="CLP">CLP</option>
                                        <option value="CNY">CNY</option>
                                        <option value="COP">COP</option>
                                        <option value="CRC">CRC</option>
                                        <option value="CUP">CUP</option>
                                        <option value="CVE">CVE</option>
                                        <option value="CZK">CZK</option>
                                        <option value="DJF">DJF</option>
                                        <option value="DKK">DKK</option>
                                        <option value="DOP">DOP</option>
                                        <option value="DZD">DZD</option>
                                        <option value="EGP">EGP</option>
                                        <option value="ETB">ETB</option>
                                        <option value="EUR">EUR</option>
                                        <option value="FJD">FJD</option>
                                        <option value="GBP">GBP</option>
                                        <option value="GHS">GHS</option>
                                        <option value="GIP">GIP</option>
                                        <option value="GMD">GMD</option>
                                        <option value="GNF">GNF</option>
                                        <option value="GTQ">GTQ</option>
                                        <option value="GYD">GYD</option>
                                        <option value="HKD">HKD</option>
                                        <option value="HNL">HNL</option>
                                        <option value="HRK">HRK</option>
                                        <option value="HTG">HTG</option>
                                        <option value="HUF">HUF</option>
                                        <option value="IDR">IDR</option>
                                        <option value="ILS">ILS</option>
                                        <option value="INR">INR</option>
                                        <option value="IQD">IQD</option>
                                        <option value="ISK">ISK</option>
                                        <option value="JMD">JMD</option>
                                        <option value="JOD">JOD</option>
                                        <option value="JPY">JPY</option>
                                        <option value="KES">KES</option>
                                        <option value="KGS">KGS</option>
                                        <option value="KHR">KHR</option>
                                        <option value="KMF">KMF</option>
                                        <option value="KRW">KRW</option>
                                        <option value="KWD">KWD</option>
                                        <option value="KYD">KYD</option>
                                        <option value="KZT">KZT</option>
                                        <option value="LAK">LAK</option>
                                        <option value="LKR">LKR</option>
                                        <option value="LRD">LRD</option>
                                        <option value="LSL">LSL</option>
                                        <option value="MAD">MAD</option>
                                        <option value="MDL">MDL</option>
                                        <option value="MGA">MGA</option>
                                        <option value="MKD">MKD</option>
                                        <option value="MMK">MMK</option>
                                        <option value="MNT">MNT</option>
                                        <option value="MOP">MOP</option>
                                        <option value="MUR">MUR</option>
                                        <option value="MVR">MVR</option>
                                        <option value="MWK">MWK</option>
                                        <option value="MXN">MXN</option>
                                        <option value="MYR">MYR</option>
                                        <option value="MZN">MZN</option>
                                        <option value="NAD">NAD</option>
                                        <option value="NGN">NGN</option>
                                        <option value="NIO">NIO</option>
                                        <option value="NOK">NOK</option>
                                        <option value="NPR">NPR</option>
                                        <option value="NZD">NZD</option>
                                        <option value="OMR">OMR</option>
                                        <option value="PEN">PEN</option>
                                        <option value="PGK">PGK</option>
                                        <option value="PHP">PHP</option>
                                        <option value="PKR">PKR</option>
                                        <option value="PLN">PLN</option>
                                        <option value="PYG">PYG</option>
                                        <option value="QAR">QAR</option>
                                        <option value="RON">RON</option>
                                        <option value="RSD">RSD</option>
                                        <option value="RUB">RUB</option>
                                        <option value="RWF">RWF</option>
                                        <option value="SAR">SAR</option>
                                        <option value="SCR">SCR</option>
                                        <option value="SEK">SEK</option>
                                        <option value="SGD">SGD</option>
                                        <option value="SLL">SLL</option>
                                        <option value="SOS">SOS</option>
                                        <option value="SSP">SSP</option>
                                        <option value="SVC">SVC</option>
                                        <option value="SZL">SZL</option>
                                        <option value="THB">THB</option>
                                        <option value="TND">TND</option>
                                        <option value="TRY">TRY</option>
                                        <option value="TTD">TTD</option>
                                        <option value="TWD">TWD</option>
                                        <option value="TZS">TZS</option>
                                        <option value="UAH">UAH</option>
                                        <option value="UGX">UGX</option>
                                        <option value="USD">USD</option>
                                        <option value="UYU">UYU</option>
                                        <option value="UZS">UZS</option>
                                        <option value="VND">VND</option>
                                        <option value="VUV">VUV</option>
                                        <option value="XAF">XAF</option>
                                        <option value="XCD">XCD</option>
                                        <option value="XOF">XOF</option>
                                        <option value="XPF">XPF</option>
                                        <option value="YER">YER</option>
                                        <option value="ZAR">ZAR</option>
                                        <option value="ZMW">ZMW</option>

                                    </select>
                                </div>

                                <label for="razorpay_secret_key" class="col-sm-12 form-check-label  mt-2">{{ __('Razorpay Secret key') }}</label>
                                <div class="col-sm-12 mt-2">
                                    <input id="razorpay_secret_key" name="gateway[Razorpay][secret_key]" type="text" class="form-control" placeholder="{{ __('Razorpay Secret key') }}" value="{{ $paymentGateway["Razorpay"]['secret_key'] ?? '' }}" required>
                                </div>

                                <label for="razorpay_public_key" class="col-sm-12 form-check-label  mt-2">{{ __('Razorpay Public key') }}</label>
                                <div class="col-sm-12 mt-2">
                                    <input id="razorpay_public_key" name="gateway[Razorpay][api_key]" type="text" class="form-control" placeholder="{{ __('Razorpay Publishable key') }}" value="{{ $paymentGateway["Razorpay"]['api_key'] ?? '' }}" required>
                                </div>

                                <label for="razorpay_webhook_secret" class="col-sm-12 form-check-label  mt-2">{{ __('Razorpay Webhook Secret') }}</label>
                                <div class="col-sm-12 mt-2">
                                    <input id="razorpay_webhook_secret" name="gateway[Razorpay][webhook_secret_key]" type="text" class="form-control" placeholder="{{ __('Razorpay Webhook Secret') }}" value="{{ $paymentGateway["Razorpay"]['webhook_secret_key'] ?? '' }}" required>
                                </div>

                                <label for="razorpay_webhook_url" class="col-sm-12 form-check-label  mt-2">{{ __('Razorpay Webhook URL') }}</label>
                                <div class="col-sm-12 mt-2">
                                    <input id="razorpay_webhook_url" name="gateway[Razorpay][webhook_url]" type="text" class="form-control" placeholder="{{ __('Razorpay Webhook URL') }}" value="{{ url('/webhook/razorpay') }}" disabled>
                                </div>

                                <label class="col-sm-12 form-check-label  mt-2" id='lbl_stripe'>{{__("Status")}}</label>
                                <div class="col-sm-2 col-md-12 col-xs-12  mt-2">
                                    <div class="form-check form-switch ">
                                        <input type="hidden" name="gateway[Razorpay][status]" id="razorpay_gateway" value="{{ $paymentGateway["Razorpay"]['status'] ?? 0 }}">
                                        <input class="form-check-input switch-input status-switch" type="checkbox" role="switch" name='op' {{ isset($paymentGateway["Razorpay"]['status']) && $paymentGateway["Razorpay"]['status'] == '1' ? 'checked' : '' }} id="switch_razorpay_gateway" aria-label="switch_razorpay_gateway">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                {{--Razorpay Payment Gateway END--}}

                {{--Paystack Payment Gateway START--}}
                <div class="col-md-6 mt-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="divider pt-3">
                                <h6 class="divider-text">{{ __('Paystack Setting') }}</h6>
                            </div>

                            <div class="form-group row mt-3">
                                <div class="col-sm-12 mt-2">
                                    <label for="paystack_currency_code" class="col-sm-12 form-check-label  mt-2">{{ __('Paystack Currency Symbol') }}</label>
                                    <select name="gateway[Paystack][currency_code]" id="paystack_currency_code" class="select2 form-select form-control-sm">
                                        <option value="USD">USD</option>
                                        <option value="GHS">GHS</option>
                                        <option value="KES">KES</option>
                                        <option value="NGN">NGN</option>
                                        <option value="ZAR">ZAR</option>
                                    </select>
                                </div>

                                <label for="paystack_secret_key" class="col-sm-12 form-check-label  mt-2">{{ __('Paystack Secret key') }}</label>
                                <div class="col-sm-12 mt-2">
                                    <input id="paystack_secret_key" name="gateway[Paystack][secret_key]" type="text" class="form-control" placeholder="{{ __('Paystack Secret key') }}" value="{{ $paymentGateway["Paystack"]['secret_key'] ?? '' }}" required>
                                </div>

                                <label for="paystack_publishable_key" class="col-sm-12 form-check-label  mt-2">{{ __('Paystack Public key') }}</label>
                                <div class="col-sm-12 mt-2">
                                    <input id="paystack_publishable_key" name="gateway[Paystack][api_key]" type="text" class="form-control" placeholder="{{ __('Paystack Public key') }}" value="{{ $paymentGateway["Paystack"]['api_key'] ?? '' }}" required>
                                </div>

                                <label for="paystack_webhook_url" class="col-sm-12 form-check-label  mt-2">{{ __('Paystack Webhook URL') }}</label>
                                <div class="col-sm-12 mt-2">
                                    <input id="paystack_webhook_url" name="gateway[Paystack][webhook_url]" type="text" class="form-control" placeholder="{{ __('Paystack Webhook URL') }}" value="{{ url('/webhook/paystack') }}" disabled>
                                </div>

                                <label class="col-sm-12 form-check-label  mt-2" id='lbl_stripe'>{{__("Status")}}</label>
                                <div class="col-sm-2 col-md-12 col-xs-12  mt-2">
                                    <div class="form-check form-switch ">
                                        <input type="hidden" name="gateway[Paystack][status]" id="paystack_gateway" value="{{ $paymentGateway["Paystack"]['status'] ?? 0 }}">
                                        <input class="form-check-input switch-input status-switch" type="checkbox" role="switch" name='op' {{ isset($paymentGateway["Paystack"]['status']) && $paymentGateway["Paystack"]['status'] == '1' ? 'checked' : '' }} id="switch_paystack_gateway" aria-label="switch_paystack_gateway">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                {{--Paystack Payment Gateway END--}}

            </div>
            <div class="col-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary me-1 mb-3">{{ __('Save') }}</button>
            </div>
        </form>
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        $('#stripe_currency_code').val("{{$paymentGateway["Stripe"]['currency_code'] ?? ''}}").trigger("change");
        $('#switch_stripe_gateway').val("{{$paymentGateway["Stripe"]['status'] ?? false}}").trigger("change");

        $('#razorpay_currency_code').val("{{$paymentGateway["Razorpay"]['currency_code'] ?? ''}}").trigger("change");
        $('#switch_razorpay_gateway').val("{{$paymentGateway["Stripe"]['status'] ?? false}}").trigger("change");

        $('#paystack_currency_code').val("{{$paymentGateway["Paystack"]['currency_code'] ?? ''}}").trigger("change");
        $('#switch_paystack_gateway').val("{{$paymentGateway["Stripe"]['status'] ?? false}}").trigger("change");
    </script>
@endsection

