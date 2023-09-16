<?php

namespace Omnipay\PayPalRest\Message;

/**
 * https://developer.paypal.com/docs/api/webhooks/v1/#verify-webhook-signature_post
 */
final class VerifyWebhookSignatureResponse extends Response
{
    /**
     * @return boolean
     */
    public function isSuccessful()
    {
        return parent::isSuccessful() && $this->getVerificationStatus() == 'SUCCESS';
    }

    /**
     * The status of the signature verification. Value is `SUCCESS` or `FAILURE`.
     *
     * @return string
     */
    public function getVerificationStatus()
    {
        return isset($this->data['verification_status']) ? $this->data['verification_status'] : null;
    }
}
