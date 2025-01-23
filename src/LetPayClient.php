<?php
/** @noinspection PhpUnused */

namespace LetPay;

use Exception;
use LetPay\parameters\LetPayContractIds;
use LetPay\parameters\LetPayPaymentParameters;
use LetPay\parameters\LetPaySimpleBoletoParameters;
use LetPay\parameters\LetPaySimpleOxxoParameters;
use LetPay\parameters\LetPaySimplePaycashParameters;
use LetPay\parameters\LetPaySimplePaynetParameters;
use LetPay\parameters\LetPaySimplePicPayParameters;
use LetPay\parameters\LetPaySimplePixParameters;
use LetPay\parameters\LetPaySimpleSpeiParameters;
use LetPay\response\LetPayBoletoResponse;
use LetPay\response\LetPayContractResponse;
use LetPay\response\LetPayCreatePaymentResponse;
use LetPay\response\LetPayErrorResponse;
use LetPay\response\LetPayPaycashResponse;
use LetPay\response\LetPayPaymentStatusResponse;
use LetPay\response\LetPayPaynetResponse;
use LetPay\response\LetPayPicPayResponse;
use LetPay\response\LetPayPixResponse;
use LetPay\response\LetPaySpeiResponse;
use LetPay\response\LetPayTokenResponse;


class LetPayClient
{
    public string $url;
    public LetPayContractIds $contract_ids;
    private ?string $apiKey;
    private ?string $apiSecret;
    private ?string $username;
    private ?string $password;
    public ?string $token = null;

    public function __construct(object $params, public bool $sandbox = false)
    {
        $this->url = $this->sandbox ? 'https://sandbox.api.letpay.io/' : 'https://api.letpay.io/';
        $this->apiKey = $params->apiKey ?? null;
        $this->apiSecret = $params->apiSecret ?? null;
        $this->username = $params->username ?? null;
        $this->password = $params->password ?? null;
        $this->contract_ids = new LetPayContractIds($params->contract_ids);
    }

    /**
     * @throws Exception
     */
    public function getContractsList(): LetPayContractResponse
    {
        return $this->_send([
            'path' => 'merchant/contracts/list',
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
        $class = match ($method) {
            'PIX' => LetPayPixResponse::class,
            default => throw new Exception('Method ' . $method . ' -> @todo'),
        };

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
     * @param LetPaySimpleBoletoParameters $params
     * @return LetPayBoletoResponse|LetPayErrorResponse|null
     * @throws Exception
     */
    public function simpleBoleto(LetPaySimpleBoletoParameters $params): LetPayBoletoResponse|LetPayErrorResponse|null
    {
        $this->_ensureContractId('boleto', $params);

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
     * @param LetPaySimplePixParameters $params
     * @return LetPayErrorResponse|LetPayPixResponse|null
     * @throws Exception
     */
    public function simplePix(LetPaySimplePixParameters $params): LetPayErrorResponse|LetPayPixResponse|null
    {
        $this->_ensureContractId('pix', $params);

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
     * @param LetPaySimpleOxxoParameters $params
     * @return LetPayErrorResponse|LetPayPixResponse|null
     * @throws Exception
     */
    public function simpleOxxo(LetPaySimpleOxxoParameters $params): LetPayErrorResponse|LetPayPixResponse|null
    {
        $this->_ensureContractId('oxxo', $params);

        return $this->_send([
            'path' => 'oxxo/simple',
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
     * @param LetPaySimplePaycashParameters $params
     * @return LetPayErrorResponse|LetPayPaycashResponse|null
     * @throws Exception
     */
    public function simplePaycash(LetPaySimplePaycashParameters $params): LetPayErrorResponse|LetPayPaycashResponse|null
    {
        $this->_ensureContractId('paycash', $params);

        return $this->_send([
            'path' => 'paycash/simple',
            'headers' => [
                'Accept: application/json',
                'Content-Type: application/json',
                'X-Auth-Token: ' . $this->_getToken()
            ],
            'data' => json_encode($params)
        ],
            LetPayPaycashResponse::class,
            false
        );
    }

    /**
     * @param LetPaySimplePaynetParameters $params
     * @return LetPayErrorResponse|LetPayPaynetResponse|null
     * @throws Exception
     */
    public function simplePaynet(LetPaySimplePaynetParameters $params): LetPayErrorResponse|LetPayPaynetResponse|null
    {
        $this->_ensureContractId('paynet', $params);
//vdp($this->apiKey, $this->apiSecret, $params->contract_id);
        return $this->_send([
            'path' => 'paynet/simple',
            'headers' => [
                'Accept: application/json',
                'Content-Type: application/json',
                'X-Auth-Token: ' . $this->_getToken()
            ],
            'data' => json_encode($params)
        ],
            LetPayPaynetResponse::class,
            false
        );
    }

    /**
     * @param LetPaySimpleSpeiParameters $params
     * @return LetPayErrorResponse|LetPaySpeiResponse|null
     * @throws Exception
     */
    public function simpleSpei(LetPaySimpleSpeiParameters $params): LetPayErrorResponse|LetPaySpeiResponse|null
    {
        $this->_ensureContractId('spei', $params);

        return $this->_send([
            'path' => 'spei/simple',
            'headers' => [
                'Accept: application/json',
                'Content-Type: application/json',
                'X-Auth-Token: ' . $this->_getToken()
            ],
            'data' => json_encode($params)
        ],
            LetPaySpeiResponse::class,
            false
        );
    }

    /**
     * @param LetPaySimplePicPayParameters $params
     * @return LetPayErrorResponse|LetPayPicPayResponse|null
     * @throws Exception
     */
    public function simplePicPay(LetPaySimplePicPayParameters $params): LetPayErrorResponse|LetPayPicPayResponse|null
    {
        $this->_ensureContractId('picpay', $params);

        return $this->_send([
            'path' => 'picpay/simple',
            'headers' => [
                'Accept: application/json',
                'Content-Type: application/json',
                'X-Auth-Token: ' . $this->_getToken()
            ],
            'data' => json_encode($params)
        ],
            LetPayPicPayResponse::class,
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
                throw new Exception($resp->getMessage());

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
            $query = isset($this->apiKey)
                ? ['apiKey' => $this->apiKey, 'apiSecret' => $this->apiSecret]
                : ['username' => $this->username, 'password' => $this->password];
            $response = $this->_send([
                'path' => 'auth',
                'headers' => [
                    'Accept: application/json',
                    'Content-Type: application/x-www-form-urlencoded'
                ],
                'data' => http_build_query($query)
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

    private function _ensureContractId(string $method, object $params): void
    {
        if (empty($params->contract_id)) {
            $params->contract_id = $this->contract_ids->{$method};
        }
    }

}
