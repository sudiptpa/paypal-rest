<?php

namespace Omnipay\PayPalRest;

/**
 * Class RestGateway
 * @package Omnipay\PayPalRest
 */
class RestGateway extends \Omnipay\Common\AbstractGateway
{
    public function getName()
    {
        return 'PayPal REST';
    }

    public function getDefaultParameters()
    {
        return [
            'clientId' => '',
            'secret' => '',
            'token' => '',
            'testMode' => false,
        ];
    }

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->getParameter('clientId');
    }

    /**
     * @param string $value
     */
    public function setClientId($value)
    {
        return $this->setParameter('clientId', $value);
    }

    /**
     * @return string
     */
    public function getSecret()
    {
        return $this->getParameter('secret');
    }

    /**
     * @param string $value
     */
    public function setSecret($value)
    {
        return $this->setParameter('secret', $value);
    }

    /**
     * @return string
     */
    public function getCaptureId()
    {
        return $this->getParameter('captureId');
    }

    /**
     * @param string $value
     */
    public function setCaptureId($value)
    {
        return $this->setParameter('captureId', $value);
    }

    /**
     * @return string
     */
    public function getToken($createIfNeeded = true)
    {
        if ($createIfNeeded && !$this->hasToken()) {
            $response = $this->createToken()->send();

            if ($response->isSuccessful()) {
                $data = $response->getData();

                if (isset($data['access_token'])) {
                    $this->setToken($data['access_token']);
                    $this->setTokenExpires(time() + $data['expires_in']);
                }
            }
        }

        return $this->getParameter('token');
    }

    /**
     * Create OAuth 2.0 access token request.
     *
     * @return \Omnipay\PayPalRest\Message\TokenRequest
     */
    public function createToken()
    {
        return $this->createRequest('\Omnipay\PayPalRest\Message\TokenRequest', []);
    }

    /**
     * Set OAuth 2.0 access token.
     *
     * @param string $value
     */
    public function setToken($value)
    {
        return $this->setParameter('token', $value);
    }

    /**
     * Get OAuth 2.0 access token expiry time.
     *
     * @return integer
     */
    public function getTokenExpires()
    {
        return $this->getParameter('tokenExpires');
    }

    /**
     * Set OAuth 2.0 access token expiry time.
     *
     * @param integer $value
     */
    public function setTokenExpires($value)
    {
        return $this->setParameter('tokenExpires', $value);
    }

    /**
     * @return bool
     */
    public function hasToken()
    {
        $token = $this->getParameter('token');

        $expires = $this->getTokenExpires();

        if (!empty($expires) && !is_numeric($expires)) {
            $expires = strtotime($expires);
        }

        return !empty($token) && time() < $expires;
    }

    /**
     * @param string $class
     * @param array $parameters
     * @return \Omnipay\PayPalRest\Message\AbstractRequest
     */
    public function createRequest($class, array $parameters = [])
    {
        if (!$this->hasToken() && $class != '\Omnipay\PayPalRest\Message\TokenRequest') {
            $this->getToken(true);
        }

        return parent::createRequest($class, $parameters);
    }

    /**
     * @link https://developer.paypal.com/docs/api/orders/v2/#orders_create
     * @param array $parameters
     * @return \Omnipay\PayPalRest\Message\PurchaseRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\PayPalRest\Message\PurchaseRequest', $parameters);
    }

    /**
     * @link https://developer.paypal.com/docs/api/orders/v2/#orders_capture
     * @param array $parameters
     * @return \Omnipay\PayPalRest\Message\CompletePurchaseRequest
     */
    public function completePurchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\PayPalRest\Message\CompletePurchaseRequest', $parameters);
    }

    /**
     * @link https://developer.paypal.com/docs/api/orders/v2/#orders_get
     * @param array $parameters
     * @return \Omnipay\PayPalRest\Message\FetchPurchaseRequest
     */
    public function fetchPurchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\PayPalRest\Message\FetchPurchaseRequest', $parameters);
    }

    /**
     * @link https://developer.paypal.com/docs/api/orders/v2/#orders_track_create
     * @param array $parameters
     * @return \Omnipay\PayPalRest\Message\TrackPurchaseRequest
     */
    public function trackPurchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\PayPalRest\Message\TrackPurchaseRequest', $parameters);
    }

    /**
     * @link https://developer.paypal.com/docs/api/webhooks/v1/#verify-webhook-signature_post
     * @param array $parameters
     * @return \Omnipay\PayPalRest\Message\VerifyWebhookSignatureRequest
     */
    public function verifyWebhookSignature(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\PayPalRest\Message\VerifyWebhookSignatureRequest', $parameters);
    }

    /**
     * @link https://developer.paypal.com/docs/api/webhooks/v1/#webhooks_list
     * @param array $parameters
     * @return \Omnipay\PayPalRest\Message\ListWebhooksRequest
     */
    public function listWebhooks(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\PayPalRest\Message\ListWebhooksRequest', $parameters);
    }

    /**
     * @link https://developer.paypal.com/docs/api/webhooks/v1/#webhooks_delete
     * @param array $parameters
     * @return \Omnipay\PayPalRest\Message\DeleteWebhookRequest
     */
    public function deleteWebhook(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\PayPalRest\Message\DeleteWebhookRequest', $parameters);
    }
}
