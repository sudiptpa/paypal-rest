<?php
namespace Omnipay\PayPalRest\Message;

/**
 * PayPalRest Purchase Response
 */
class CompletePurchaseResponse extends Response
{
    public function isCaptured()
    {
        return isset($this->data['status']) ? $this->data['status'] == 'COMPLETED' : null;
    }
}
