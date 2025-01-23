<?php

namespace Omnipay\PayPalRest\Message;

use Omnipay\PayPalRest\Enums\ItemTypeEnum;

class RefundRequest extends AbstractRequest
{
    /**
     * @return array
     */
    public function getData()
    {
        return [];
    }

    /**
     * @return string
     */
    protected function getEndpoint()
    {
        return parent::getEndpoint() . '/payments/captures/' . $this->getTransactionReference() . '/refund';
    }

    /**
     * @param $data
     * @param $statusCode
     * @return \Omnipay\PayPalRest\Message\RefundResponse
     */
    protected function createResponse($data, $statusCode)
    {
        return $this->response = new RefundResponse($this, $data, $statusCode);
    }
}