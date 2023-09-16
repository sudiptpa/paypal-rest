<?php

namespace Omnipay\PayPalRest\Message;

/**
 * Class TokenRequest
 * @package Omnipay\PayPalRest\Message
 */
class TokenRequest extends AbstractRequest
{
    const API_VERSION = 'v1';

    public function getData()
    {
        return ['grant_type' => 'client_credentials'];
    }

    /**
     * @return string
     */
    protected function getEndpoint()
    {
        return $this->getBaseEndpoint() . '/' . self::API_VERSION . '/oauth2/token';
    }

    /**
     * @param $data
     * @return \Omnipay\PayPalRest\Message\Response
     */
    public function sendData($data)
    {
        $body = $data ? http_build_query($data, '', '&') : null;

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json; charset=UTF-8',
            'Authorization' => 'Basic ' . base64_encode("{$this->getClientId()}:{$this->getSecret()}"),
        ];

        $httpResponse = $this->httpClient->createRequest(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            $headers,
            $body
        )->send();

        return $this->response = new Response($this, $httpResponse->json(), $httpResponse->getStatusCode());
    }
}
