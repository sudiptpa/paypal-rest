<?php

namespace Omnipay\PayPalRest\Message;

/**
 * PayPal REST Fetch Purchase Request
 *
 * Use this call to get details about payments that have not completed, such
 * as payments that are created and approved, or if a payment has failed.
 *
 * @see PurchaseRequest
 * @link https://developer.paypal.com/docs/api/orders/v2/#orders_get
 */
class FetchPurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('transactionReference');

        return [];
    }

    /**
     * Get HTTP Method.
     *
     * The HTTP method for fetchTransaction requests must be GET.
     * Using POST results in an error 500 from PayPal.
     *
     * @return string
     */
    protected function getHttpMethod()
    {
        return 'GET';
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . '/checkout/orders/' . $this->getTransactionReference();
    }
}
