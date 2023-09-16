<?php

namespace Omnipay\PayPalRest\Message;

/**
 * PayPalRest Complete Purchase Request
 *
 * @see PurchaseRequest
 * @link https://developer.paypal.com/docs/api/orders/v2/#orders_capture
 */
class CompletePurchaseRequest extends AbstractRequest
{
    /**
     * @return array
     */
    public function getData()
    {
        $this->validate('transactionReference');

        return [];
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . '/checkout/orders/' . $this->getTransactionReference() . '/capture';
    }

    /**
     * @param $data
     * @param $statusCode
     * @return \Omnipay\PayPalRest\Message\CompletePurchaseResponse
     */
    protected function createResponse($data, $statusCode)
    {
        return $this->response = new CompletePurchaseResponse($this, $data, $statusCode);
    }
}
