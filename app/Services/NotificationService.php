<?php

namespace App\Services;

use App\Models\Setting;
use Google\Client;
use Google\Exception;
use RuntimeException;
use Throwable;

class NotificationService {
    /**
     * @param array $registrationIDs
     * @param string|null $title
     * @param string|null $message
     * @param string $type
     * @param array $customBodyFields
     * @return string|array|bool
     */
    public static function sendFcmNotification(array $registrationIDs, string|null $title = '', string|null $message = '',string $type = "default", array $customBodyFields = []): string|array|bool {
        try {
            //TODO : Use this from caching
            $project_id = Setting::select('value')->where('name', 'firebase_project_id')->first();
            if (empty($project_id->value)) {
                return false;
            }

            $project_id = $project_id->value;
            $url = 'https://fcm.googleapis.com/v1/projects/' . $project_id . '/messages:send';

            $registrationIDs_chunks = array_chunk($registrationIDs, 1000);

            $access_token = self::getAccessToken();

            $unregisteredIDs = array();
            if (!count($registrationIDs_chunks)) {
                return false;
            }
            $result = [];
            //TODO : Add this process to queue for better performance
            foreach ($registrationIDs as $registrationID) {
                $data = [
                    "message" => [
                        "token"        => $registrationID,
                        "notification" => [
                            "title" => $title,
                            "body"  => $message
                        ],
                        "data"         => count($customBodyFields) > 0 ? array_map('strval', $customBodyFields) : null,
                        "android"      => [
                            "notification" => [
                                'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                            ],
                            "data"         => [
                                "title" => $title,
                                "body"  => $message,
                                "type"  => $type,
                            ]
                        ],
                        "apns"         => [
                            "headers" => [
                                "apns-priority" => "10" // Set APNs priority to 10 (high) for immediate delivery
                            ],
                            "payload" => [
                                "aps" => [
                                    "alert" => [
                                        "title" => $title,
                                        "body"  => $message,
                                    ],
                                ]
                            ]
                        ]
                    ]
                ];
                $encodedData = json_encode($data);

                $headers = [
                    'Authorization: Bearer ' . $access_token,
                    'Content-Type: application/json',
                ];

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
                curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

                // Disabling SSL Certificate support temporarily
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

                // Execute post
                $result = curl_exec($ch);

                if (!$result) {
                    die('Curl failed: ' . curl_error($ch));
                }

//                                if (isset($result['results'])) {
//                    foreach ($result['results'] as $index => $response) {
//                        if (isset($response['error']) && $response['error'] == 'NotRegistered') {
//                            $unregisteredIDs[] = $registrationIDsChunk[$index];
//                        }
//                    }
//                }
                // Close connection
                curl_close($ch);

                // $result[] = json_decode($get_result, true, 512, JSON_THROW_ON_ERROR);

                // $fcmMsg = [
                //     'title'        => $title,
                //     'message'      => $message,
                //     'body'         => $message,
                //     'type'         => 'default',
                //     'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                //     'sound'        => 'default',
                //     ...$customBodyFields
                // ];
                // $fcmFields = array(
                //     'registration_ids' => $registrationIDsChunk,
                //     'priority'         => 'high',
                //     'notification'     => $fcmMsg,
                //     'data'             => $fcmMsg
                // );

                // if (isset($result['results'])) {
                //     foreach ($result['results'] as $index => $response) {
                //         if (isset($response['error']) && $response['error'] == 'NotRegistered') {
                //             $unregisteredIDs[] = $registrationIDsChunk[$index];
                //         }
                //     }
                // }
            }

            // if (count($unregisteredIDs)) {
            //     User::whereIn('fcm_id', $unregisteredIDs)->delete();
            // }
            return $result;
        } catch (Throwable $th) {
            throw new RuntimeException($th);
        }
    }

    public static function getAccessToken() {
        try {
            $file_name = Setting::select('value')->where('name', 'service_file')->first();
            if (empty($file_name)) {
                return false;
            }
            $file_name = $file_name->value;
            $file_path = base_path('public/storage/' . $file_name);

            $client = new Client();
            $client->setAuthConfig($file_path);
            $client->setScopes(['https://www.googleapis.com/auth/firebase.messaging']);
            return $client->fetchAccessTokenWithAssertion()['access_token'];
        } catch (Exception $e) {
            throw new RuntimeException($e);
        }
    }

}
