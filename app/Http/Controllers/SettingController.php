<?php

namespace App\Http\Controllers;

use App\Models\PaymentConfiguration;
use App\Models\Setting;
use App\Services\CachingService;
use App\Services\FileService;
use App\Services\HelperService;
use App\Services\ResponseService;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class SettingController extends Controller {
    private string $uploadFolder;
    protected $helperService;

    public function __construct() {
        $this->uploadFolder = 'settings';
    }

    public function index() {
        ResponseService::noPermissionThenRedirect('settings-update');
        return view('settings.index');
    }

    public function page() {
        ResponseService::noPermissionThenSendJson('settings-update');
        $type = last(request()->segments());
        $settings = CachingService::getSystemSettings()->toArray();
        if (!empty($settings['place_api_key']) && config('app.demo_mode')) {
            $settings['place_api_key'] = "**************************";
        }
        $stripe_currencies = ["USD", "AED", "AFN", "ALL", "AMD", "ANG", "AOA", "ARS", "AUD", "AWG", "AZN", "BAM", "BBD", "BDT", "BGN", "BIF", "BMD", "BND", "BOB", "BRL", "BSD", "BWP", "BYN", "BZD", "CAD", "CDF", "CHF", "CLP", "CNY", "COP", "CRC", "CVE", "CZK", "DJF", "DKK", "DOP", "DZD", "EGP", "ETB", "EUR", "FJD", "FKP", "GBP", "GEL", "GIP", "GMD", "GNF", "GTQ", "GYD", "HKD", "HNL", "HTG", "HUF", "IDR", "ILS", "INR", "ISK", "JMD", "JPY", "KES", "KGS", "KHR", "KMF", "KRW", "KYD", "KZT", "LAK", "LBP", "LKR", "LRD", "LSL", "MAD", "MDL", "MGA", "MKD", "MMK", "MNT", "MOP", "MRO", "MUR", "MVR", "MWK", "MXN", "MYR", "MZN", "NAD", "NGN", "NIO", "NOK", "NPR", "NZD", "PAB", "PEN", "PGK", "PHP", "PKR", "PLN", "PYG", "QAR", "RON", "RSD", "RUB", "RWF", "SAR", "SBD", "SCR", "SEK", "SGD", "SHP", "SLE", "SOS", "SRD", "STD", "SZL", "THB", "TJS", "TOP", "TTD", "TWD", "TZS", "UAH", "UGX", "UYU", "UZS", "VND", "VUV", "WST", "XAF", "XCD", "XOF", "XPF", "YER", "ZAR", "ZMW"];
        $languages = CachingService::getLanguages();
        return view('settings.' . $type, compact('settings', 'type', 'languages', 'stripe_currencies'));
    }

    public function store(Request $request) {
        ResponseService::noPermissionThenSendJson('settings-update');
        try {
            $inputs = $request->input();
            unset($inputs['_token']);
            $data = [];
            foreach ($inputs as $key => $input) {
                $data[] = [
                    'name'  => $key,
                    'value' => $input,
                    'type'  => 'string'
                ];
            }

            //Fetch old images to delete from the disk storage
            $oldSettingFiles = Setting::whereIn('name', collect($request->files)->keys())->get();
            foreach ($request->files as $key => $file) {
                $data[] = [
                    'name'  => $key,
                    'value' => $request->file($key)->store($this->uploadFolder, 'public'),
                    'type'  => 'file'
                ];
                $oldFile = $oldSettingFiles->first(function ($old) use ($key) {
                    return $old->name == $key;
                });
                if (!empty($oldFile)) {
                    FileService::delete($oldFile->getRawOriginal('value'));
                }
            }
            Setting::upsert($data, 'name', ['value']);

            if(!empty($inputs['company_name']) && config('app.name')!=$inputs['company_name']){
                HelperService::changeEnv([
                    'APP_NAME'  => $inputs['company_name'],
                ]);
            }
            CachingService::removeCache(config('constants.CACHE.SETTINGS'));
            ResponseService::successResponse('Settings Updated Successfully');
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, "Setting Controller -> store");
            ResponseService::errorResponse('Something Went Wrong');
        }
    }

    public function updateFirebaseSettings(Request $request) {
        ResponseService::noPermissionThenSendJson('settings-update');
        $validator = Validator::make($request->all(), [
            'apiKey'            => 'required',
            'authDomain'        => 'required',
            'projectId'         => 'required',
            'storageBucket'     => 'required',
            'messagingSenderId' => 'required',
            'appId'             => 'required',
            'measurementId'     => 'required',
        ]);
        if ($validator->fails()) {
            ResponseService::validationError($validator->errors()->first());
        }
        try {
            $inputs = $request->input();
            unset($inputs['_token']);
            $data = [];
            foreach ($inputs as $key => $input) {
                $data[] = [
                    'name'  => $key,
                    'value' => $input,
                    'type'  => 'string'
                ];
            }
            Setting::upsert($data, 'name', ['value']);
            //Service worker file will be copied here
            File::copy(public_path('assets/dummy-firebase-messaging-sw.js'), public_path('firebase-messaging-sw.js'));
            $serviceWorkerFile = file_get_contents(public_path('firebase-messaging-sw.js'));

            $updateFileStrings = [
                "apiKeyValue"            => '"' . $request->apiKey . '"',
                "authDomainValue"        => '"' . $request->authDomain . '"',
                "projectIdValue"         => '"' . $request->projectId . '"',
                "storageBucketValue"     => '"' . $request->storageBucket . '"',
                "messagingSenderIdValue" => '"' . $request->measurementId . '"',
                "appIdValue"             => '"' . $request->appId . '"',
                "measurementIdValue"     => '"' . $request->measurementId . '"'
            ];
            $serviceWorkerFile = str_replace(array_keys($updateFileStrings), $updateFileStrings, $serviceWorkerFile);
            file_put_contents(public_path('firebase-messaging-sw.js'), $serviceWorkerFile);
            CachingService::removeCache(config('constants.CACHE.SETTINGS'));
            ResponseService::successResponse('Settings Updated Successfully');
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, "Settings Controller -> updateFirebaseSettings");
            ResponseService::errorResponse();
        }
    }

    public function paymentSettingsIndex() {
        ResponseService::noPermissionThenRedirect('settings-update');
        $paymentConfiguration = PaymentConfiguration::all();
        $paymentGateway = [];
        foreach ($paymentConfiguration as $row) {
            $paymentGateway[$row->payment_method] = $row->toArray();
        }

        return view('settings.payment-gateway', compact('paymentGateway'));
    }

    public function paymentSettingsStore(Request $request) {
        ResponseService::noPermissionThenSendJson('settings-update');
        $validator = Validator::make($request->all(), [
            'gateway'          => 'required|array',
            'gateway.Stripe'   => 'required|array|required_array_keys:api_key,secret_key,webhook_secret_key,status',
            'gateway.Razorpay' => 'required|array|required_array_keys:api_key,secret_key,webhook_secret_key,status',
            'gateway.Paystack' => 'required|array|required_array_keys:api_key,secret_key,status'
        ]);
        if ($validator->fails()) {
            ResponseService::validationError($validator->errors()->first());
        }
        try {
            foreach ($request->gateway as $key => $gateway) {
                PaymentConfiguration::updateOrCreate(['payment_method' => $key], [
                    'api_key'            => $gateway["api_key"] ?? '',
                    'secret_key'         => $gateway["secret_key"] ?? '',
                    'webhook_secret_key' => $gateway["webhook_secret_key"] ?? '',
                    'status'             => $gateway["status"] ?? '',
                    'currency_code'      => $gateway["currency_code"] ?? ''
                ]);
                if ($key === 'Paystack') {
                    HelperService::changeEnv([
                        'PAYSTACK_PUBLIC_KEY'  => $gateway['api_key'] ?? '',
                        'PAYSTACK_SECRET_KEY'  => $gateway['secret_key'] ?? '',
                        'PAYSTACK_PAYMENT_URL' => "https://api.paystack.co"
                    ]);
                }
            }


            ResponseService::successResponse('Settings Updated Successfully');
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, "Settings Controller -> updateFirebaseSettings");
            ResponseService::errorResponse();
        }
    }
}
