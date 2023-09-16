<?php

namespace Omnipay\PayPalRest\Message;

/**
 * PayPal REST List Webhooks request
 *
 * @link https://developer.paypal.com/docs/api/webhooks/v1/#webhooks_list
 */
final class ListWebhooksRequest extends AbstractRequest
{
    const API_VERSION = 'v1';

    /**
     * @inheritDoc
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
        return parent::getBaseEndpoint() . '/' . self::API_VERSION . '/notifications/webhooks';
    }

    /**
     * Get HTTP Method.
     *
     * @return string
     */
    protected function getHttpMethod()
    {
        return 'GET';
    }
}
