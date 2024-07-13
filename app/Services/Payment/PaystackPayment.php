<?php

namespace App\Services\Payment;

use RuntimeException;
use Throwable;
use Unicodeveloper\Paystack\Paystack;

class PaystackPayment extends Paystack implements PaymentInterface {
    private Paystack $paystack;
    private string $currencyCode;

    /**
     * PaystackPayment constructor.
     * @param $currencyCode
     */
    public function __construct($currencyCode) {
        // Call Paystack Class and Create Payment Intent
        $this->paystack = new Paystack();
        $this->currencyCode = $currencyCode;
        parent::__construct();
    }

    /**
     * @param $amount
     * @param $customMetaData
     * @return array
     */
    public function createPaymentIntent($amount, $customMetaData) {
        try {
            if (empty($customMetaData['email'])) {
                throw new RuntimeException("Email cannot be empty");
            }
            $finalAmount = $amount * 100;
            $data = [
                'amount'   => $finalAmount, // Amount should be in kobo
                'currency' => $this->currencyCode,
                'email'    => $customMetaData['email'],
                'metadata' => $customMetaData
            ];
            return $this->paystack->getAuthorizationResponse($data);
        } catch (Throwable $e) {
            throw new RuntimeException($e);
        }
    }

    /**
     * @param $amount
     * @param $customMetaData
     * @return array
     */
    public function createAndFormatPaymentIntent($amount, $customMetaData): array {
        $response = $this->createPaymentIntent($amount, $customMetaData);
        return $this->format($response, $amount, $this->currencyCode, $customMetaData);
    }

    /**
     * @param $paymentId
     * @return array
     * @throws Throwable
     */
    public function retrievePaymentIntent($paymentId): array {
        try {
            $relativeUrl = "/transaction/verify/{$paymentId}";
            $this->response = $this->client->get($this->baseUrl . $relativeUrl, []);
            $response = json_decode($this->response->getBody(), true, 512, JSON_THROW_ON_ERROR);
            return $this->format($response['data'], $response['data']['amount'], $response['data']['currency'], $response['data']['metadata']);
        } catch (Throwable $e) {
            throw new RuntimeException($e);
        }
    }

    /**
     * @param $currency
     * @param $amount
     */
    public function minimumAmountValidation($currency, $amount) {
        // TODO: Implement minimumAmountValidation() method.
    }

    /**
     * @param $paymentIntent
     * @param $amount
     * @param $currencyCode
     * @param $metadata
     * @return array
     */
    public function format($paymentIntent, $amount, $currencyCode, $metadata) {
        return $this->formatPaymentIntent($paymentIntent['data']['reference'], $amount, $currencyCode, $paymentIntent['status'], $metadata, $paymentIntent);
    }

    /**
     * @param $id
     * @param $amount
     * @param $currency
     * @param $status
     * @param $metadata
     * @param $paymentIntent
     * @return array
     */
    public function formatPaymentIntent($id, $amount, $currency, $status, $metadata, $paymentIntent): array {
        return [
            'id'                       => $id,
            'amount'                   => $amount,
            'currency'                 => $currency,
            'metadata'                 => $metadata,
            'status'                   => match ($status) {
                "abandoned" => "failed",
                "succeed" => "succeed",
                default => $status ?? true
            },
            'payment_gateway_response' => $paymentIntent
        ];
    }
}
