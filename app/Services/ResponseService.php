<?php

namespace App\Services;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class ResponseService
{
    /**
     * @param $permission
     * @return Application|RedirectResponse|Redirector|true
     */
    public static function noPermissionThenRedirect($permission)
    {
        if (!Auth::user()->can($permission)) {
            return redirect(route('home'))->withErrors([
                'message' => trans("You Don't have enough permissions")
            ])->send();
        }
        return true;
    }

    /**
     * @param $permission
     * @return true
     */
    public static function noPermissionThenSendJson($permission)
    {
        if (!Auth::user()->can($permission)) {
            self::errorResponse("You Don't have enough permissions");
        }
        return true;
    }

    /**
     * @param $role
     * @return Application|\Illuminate\Foundation\Application|RedirectResponse|Redirector|true
     */
    // Check user role
    public static function noRoleThenRedirect($role)
    {
        if (!Auth::user()->hasRole($role)) {
            return redirect(route('home'))->withErrors([
                'message' => trans("You Don't have enough permissions")
            ])->send();
        }
        return true;
    }

    /**
     * @param array $role
     * @return bool|Application|\Illuminate\Foundation\Application|RedirectResponse|Redirector
     */
    public static function noAnyRoleThenRedirect(array $role)
    {
        if (!Auth::user()->hasAnyRole($role)) {
            return redirect(route('home'))->withErrors([
                'message' => trans("You Don't have enough permissions")
            ])->send();
        }
        return true;
    }

    //    /**
    //     * @param $role
    //     * @return true
    //     */
    //    public static function noRoleThenSendJson($role)
    //    {
    //        if (!Auth::user()->hasRole($role)) {
    //            self::errorResponse("You Don't have enough permissions");
    //        }
    //        return true;
    //    }

    /**
     * @param $feature
     * @return RedirectResponse|true
     */
    // Check Feature
    //    public static function noFeatureThenRedirect($feature) {
    //        if (Auth::user()->school_id && !app(FeaturesService::class)->hasFeature($feature)) {
    //            return redirect()->back()->withErrors([
    //                'message' => trans('Purchase') . " " . $feature . " " . trans("to Continue using this functionality")
    //            ])->send();
    //        }
    //        return true;
    //    }
    //
    //    public static function noFeatureThenSendJson($feature) {
    //        if (Auth::user()->school_id && !app(FeaturesService::class)->hasFeature($feature)) {
    //            self::errorResponse(trans('Purchase') . " " . $feature . " " . trans("to Continue using this functionality"));
    //        }
    //        return true;
    //    }

    /**
     * If User don't have any of the permission that is specified in Array then Redirect will happen
     * @param array $permissions
     * @return RedirectResponse|true
     */
    public static function noAnyPermissionThenRedirect(array $permissions)
    {
        if (!Auth::user()->canany($permissions)) {
            return redirect()->back()->withErrors([
                'message' => trans("You Don't have enough permissions")
            ])->send();
        }
        return true;
    }

    /**
     * If User don't have any of the permission that is specified in Array then Json Response will be sent
     * @param array $permissions
     * @return true
     */
    public static function noAnyPermissionThenSendJson(array $permissions)
    {
        if (!Auth::user()->canany($permissions)) {
            self::errorResponse("You Don't have enough permissions");
        }
        return true;
    }

    /**
     * @param string|null $message
     * @param null $data
     * @param array $customData
     * @param null $code
     * @return void
     */
    public static function successResponse(string|null $message = "Success", $data = null, array $customData = array(), $code = null): void
    {
        response()->json(array_merge([
            'error'   => false,
            'message' => trans($message),
            'data'    => $data,
            'code'    => $code ?? config('constants.RESPONSE_CODE.SUCCESS')
        ], $customData))->send();
        exit();
    }

    /**
     * @param string $message
     * @param $url
     * @return Application|\Illuminate\Foundation\Application|RedirectResponse|Redirector
     */
    public static function successRedirectResponse(string $message = "success", $url = null)
    {
        return isset($url) ? redirect($url)->with([
            'success' => trans($message)
        ])->send() : redirect()->back()->with([
            'success' => trans($message)
        ])->send();
    }

    /**
     *
     * @param string $message - Pass the Translatable Field
     * @param null $data
     * @param string $code
     * @param null $e
     * @return void
     */
    public static function errorResponse(string $message = 'Error Occurred', $data = null, string|int $code = null, $e = null)
    {
        response()->json([
            'error'   => true,
            'message' => trans($message),
            'data'    => $data,
            'code'    => $code ?? config('constants.RESPONSE_CODE.EXCEPTION_ERROR'),
            'details' => (!empty($e) && is_object($e)) ? $e->getMessage() . ' --> ' . $e->getFile() . ' At Line : ' . $e->getLine() : ''
        ])->send();
        exit();
    }

    /**
     * return keyword should, must be used wherever this function is called.
     * @param string|string[] $message
     * @param $url
     * @param null $input
     * @return RedirectResponse
     */
    public static function errorRedirectResponse(string|array $message = 'Error Occurred', $url = 'back', $input = null)
    {
        return $url == "back" ? redirect()->back()->with([
            'errors' => trans($message)
        ])->withInput($input) : redirect($url)->with([
            'errors' => trans($message)
        ])->withInput($input);
    }

    /**
     * @param string $message
     * @param null $data
     * @param null $code
     * @return void
     */
    public static function warningResponse(string $message = 'Error Occurred', $data = null, $code = null)
    {
        response()->json([
            'error'   => false,
            'warning' => true,
            'code'    => $code,
            'message' => trans($message),
            'data'    => $data,
        ])->send();
        exit();
    }


    /**
     * @param string $message
     * @param null $data
     * @return void
     */
    public static function validationError(string $message = 'Error Occurred', $data = null)
    {
        self::errorResponse($message, $data, config('constants.RESPONSE_CODE.VALIDATION_ERROR'));
    }

    /**
     * @param string $message
     * @return void
     */
    public static function validationErrorRedirect(string $message = 'Error Occurred')
    {
        self::errorRedirectResponse(route('custom-fields.create'), $message);
        exit();
    }

    /**
     * @param Throwable|Exception $e
     * @param string $logMessage
     * @param string $responseMessage
     * @param bool $jsonResponse
     * @return void
     */
    public static function logErrorResponse(Throwable|Exception $e, string $logMessage = ' ', string $responseMessage = 'Error Occurred', bool $jsonResponse = true)
    {
        Log::error($logMessage . ' ' . $e->getMessage() . '---> ' . $e->getFile() . ' At Line : ' . $e->getLine() . "\n\n" . request()->method() . " : " . request()->fullUrl() . "\nParams : ", request()->all());
        if ($jsonResponse && config('app.debug')) {
            self::errorResponse($responseMessage, null, null, $e);
        }
    }

    /**
     * @param $e
     * @param string $logMessage
     * @param string $responseMessage
     * @param bool $jsonResponse
     */
    public static function logErrorRedirect($e, string $logMessage = ' ', string $responseMessage = 'Error Occurred', bool $jsonResponse = true)
    {
        Log::error($logMessage . ' ' . $e->getMessage() . '---> ' . $e->getFile() . ' At Line : ' . $e->getLine());
        if ($jsonResponse && config('app.debug')) {
            throw $e;
        }
    }
}
