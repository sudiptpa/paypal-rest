<?php

namespace Omnipay\PayPalRest\Message;

/**
 * @link https://developer.paypal.com/docs/api/webhooks/v1/#webhooks_delete
 */
class DeleteWebhookRequest extends AbstractRequest
{
    const API_VERSION = 'v1';

    /**
     * @return array
     */
    public function getData()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getEndpoint()
    {
        return parent::getBaseEndpoint() . '/' . self::API_VERSION . '/notifications/webhooks/' . $this->getTransactionReference();
    }

    /**
     * Get HTTP Method.
     *
     * @return string
     */
    protected function getHttpMethod()
    {
        return 'DELETE';
    }

    /**
     * @param $data
     * @param $statusCode
     * @return \Omnipay\PayPalRest\Message\PurchaseResponse
     */
    protected function createResponse($data, $statusCode)
    {
        return $this->response = new Response($this, $data, $statusCode);
    }
}
