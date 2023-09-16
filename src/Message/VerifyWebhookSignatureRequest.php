<?php

namespace Omnipay\PayPalRest\Message;

/**
 * https://developer.paypal.com/docs/api/webhooks/v1/#verify-webhook-signature_post
 */
final class VerifyWebhookSignatureRequest extends AbstractRequest
{
    const API_VERSION = 'v1';

    /**
     * @return array
     */
    public function getData()
    {
        return [
            'auth_algo' => $this->getAuthAlgo(),
            'cert_url' => $this->getCertUrl(),
            'transmission_id' => $this->getTransmissionId(),
            'transmission_sig' => $this->getTransmissionSig(),
            'transmission_time' => $this->getTransmissionTime(),
            'webhook_id' => $this->getWebhookId(),
            'webhook_event' => $this->getWebhookEvent(),
        ];
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->getBaseEndpoint() . '/' . self::API_VERSION . '/notifications/verify-webhook-signature';
    }

    /**
     * @return string
     */
    public function getAuthAlgo()
    {
        return $this->getParameter('auth_algo');
    }

    /**
     * @param string $authAlgo
     *
     * @return $this
     */
    public function setAuthAlgo($authAlgo)
    {
        return $this->setParameter('auth_algo', $authAlgo);
    }

    /**
     * @return string
     */
    public function getCertUrl()
    {
        return $this->getParameter('cert_url');
    }

    /**
     * @param string $certUrl
     *
     * @return $this
     */
    public function setCertUrl($certUrl)
    {
        return $this->setParameter('cert_url', $certUrl);
    }

    /**
     * @return string
     */
    public function getTransmissionId()
    {
        return $this->getParameter('transmission_id');
    }

    /**
     * @param string $transmissionId
     *
     * @return $this
     */
    public function setTransmissionId($transmissionId)
    {
        return $this->setParameter('transmission_id', $transmissionId);
    }

    /**
     * @return string
     */
    public function getTransmissionSig()
    {
        return $this->getParameter('transmission_sig');
    }

    /**
     * @param string $transmissionSig
     *
     * @return $this
     */
    public function setTransmissionSig($transmissionSig)
    {
        return $this->setParameter('transmission_sig', $transmissionSig);
    }

    /**
     * @return string
     */
    public function getTransmissionTime()
    {
        return $this->getParameter('transmission_time');
    }

    /**
     * @param string $transmissionTime
     *
     * @return $this
     */
    public function setTransmissionTime($transmissionTime)
    {
        return $this->setParameter('transmission_time', $transmissionTime);
    }

    /**
     * @return string
     */
    public function getWebhookId()
    {
        return $this->getParameter('webhook_id');
    }

    /**
     * @param string $webhookId
     *
     * @return $this
     */
    public function setWebhookId($webhookId)
    {
        return $this->setParameter('webhook_id', $webhookId);
    }

    /**
     * @return string
     */
    public function getWebhookEvent()
    {
        return $this->getParameter('webhook_event');
    }
    /**
     * @param array $webhookEvent
     *
     * @return $this
     */
    public function setWebhookEvent(array $webhookEvent)
    {
        return $this->setParameter('webhook_event', $webhookEvent);
    }

    /**
     * @param $data
     * @param $statusCode
     * @return \Omnipay\PayPalRest\Message\VerifyWebhookSignatureResponse
     */
    protected function createResponse($data, $statusCode)
    {
        return $this->response = new VerifyWebhookSignatureResponse($this, $data, $statusCode);
    }
}
