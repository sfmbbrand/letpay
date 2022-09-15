<?php
/** @noinspection PhpUnused */

namespace LetPay;

use Exception;
use LetPay\parameters\LetPayPaymentParameters;
use LetPay\parameters\LetPaySimpleBoletoParameters;
use LetPay\parameters\LetPaySimplePixParameters;
use LetPay\response\LetPayBoletoResponse;
use LetPay\response\LetPayContractResponse;
use LetPay\response\LetPayCreatePaymentResponse;
use LetPay\response\LetPayErrorResponse;
use LetPay\response\LetPayPaymentStatusResponse;
use LetPay\response\LetPayPixResponse;
use LetPay\response\LetPayTokenResponse;


class LetPayClient
{
    public bool $sandbox;
    public string $url;
    private string $user;
    private string $password;
    public string $contract_id;
    private ?string $token = null;

    public function __construct(string $user, string $password, string $contract_id, bool $sandbox = false)
    {
        $this->user = $user;
        $this->password = $password;
        $this->contract_id = $contract_id;
        $this->sandbox = $sandbox;
        $this->url = $sandbox ? 'https://sandbox.api.letpay.io/' : 'https://api.letpay.io/';

    }

    /**
     * @throws Exception
     */
    public function getContractId(): LetPayContractResponse
    {
        return $this->_send([
            'path' => 'merchant/contracts',
            'headers' => [
                'Accept: application/json',
                'X-Auth-Token: ' . $this->_getToken()
            ],
            'method' => 'GET'],
            LetPayContractResponse::class);
    }

    /**
     * @throws Exception
     */
    public function createPayment(LetPayPaymentParameters $data): LetPayCreatePaymentResponse
    {
        return $this->_send([
            'path' => 'payment',
            'headers' => [
                'Accept: application/json',
                'Content-Type: application/json',
                'X-Auth-Token: ' . $this->_getToken()
            ],
            'data' => json_encode($data)],
            LetPayCreatePaymentResponse::class);
    }

    /**
     * @throws Exception
     */
    public function processPayment(LetPayCreatePaymentResponse $p_response, string $method): LetPayPixResponse
    {
        switch ($method) {
            case 'PIX':
                $class = LetPayPixResponse::class;
                break;

            default:
                throw new Exception('Method ' . $method . ' -> @todo');
        }

        return $this->_send([
            'path' => 'payment/' . $p_response->payment->payment_token . '/sendPayment',
            'headers' => [
                'Accept: application/json',
                'Content-Type: application/json',
                'X-Auth-Token: ' . $this->_getToken()
            ],
            'data' => json_encode(['method' => $method])],
            $class);
    }

    /**
     * @throws Exception
     * @return LetPayBoletoResponse | LetPayErrorResponse
     */
    public function simpleBoleto(LetPaySimpleBoletoParameters $params)
    {
        return $this->_send([
            'path' => 'boleto/simple',
            'headers' => [
                'Accept: application/json',
                'Content-Type: application/json',
                'X-Auth-Token: ' . $this->_getToken()
            ],
            'data' => json_encode($params)
        ],
            LetPayBoletoResponse::class
        );
    }

    /**
     * @throws Exception
     * @return LetPayPixResponse | LetPayErrorResponse
     */
    public function simplePix(LetPaySimplePixParameters $params)
    {
        return $this->_send([
            'path' => 'pix/simple',
            'headers' => [
                'Accept: application/json',
                'Content-Type: application/json',
                'X-Auth-Token: ' . $this->_getToken()
            ],
            'data' => json_encode($params)
        ],
            LetPayPixResponse::class,
            false
        );
    }

    /**
     * @throws Exception
     */
    public function paymentStatus(string $payment_token)
    {
        return $this->_send([
            'path' => 'payment/' . $payment_token,
            'headers' => [
                'Accept: application/json',
                'X-Auth-Token: ' . $this->_getToken()
            ],
           'method' => 'GET'
        ],
            LetPayPaymentStatusResponse::class, false);
    }

    /**
     * @throws Exception
     */
    private function _send(array $params, $class, bool $throw_error = true)
    {
        $response = $this->_sendCurlRequest($params);

        if (!$response) {
            if ($throw_error)
                throw new Exception('Empty response for ' . $params['path']);

            return $response;
        }

        if (!empty($response->error)) {
            $resp = new LetPayErrorResponse($response);

            if ($throw_error)
                throw new Exception($resp->error . ' · ' . $resp->message);

            return $resp;
        }

        return new $class($response);
    }

    /**
     * @throws Exception
     */
    private function _getToken(): string
    {
        if (!$this->token) {
            $response = $this->_send([
                'path' => 'auth',
                'headers' => [
                    'Accept: application/json',
                    'Content-Type: application/x-www-form-urlencoded'
                ],
                'data' => http_build_query(['username' => $this->user, 'password' => $this->password])
            ],
                LetPayTokenResponse::class
            );
            $this->token = $response->token;
        }

        return $this->token;
    }

    private function _sendCurlRequest(array $params)
    {
        $method = $params['method'] ?? 'POST';

        $curl_params = array(
            CURLOPT_URL => $this->url . $params['path'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $params['headers']
        );

        if ($method === 'POST' && !empty($params['data']))
            $curl_params[CURLOPT_POSTFIELDS] = $params['data'];

        $curl = curl_init();
        curl_setopt_array($curl, $curl_params);
        $curl_response = curl_exec($curl);
        curl_close($curl);

        return json_decode($curl_response) ?: null;
    }

}
