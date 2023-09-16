<?php

namespace Omnipay\PayPalRest\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Class Response
 * @package \Omnipay\PayPalRest\Message
 */
class Response extends AbstractResponse
{
    protected $statusCode;

    /**
     * @param RequestInterface $request
     * @param $data
     * @param $statusCode
     */
    public function __construct(RequestInterface $request, $data, $statusCode = 200)
    {
        parent::__construct($request, $data);
        $this->statusCode = $statusCode;
    }

    public function isSuccessful()
    {
        $statusCode = $this->getCode();

        return $statusCode >= 200 && $statusCode <= 399;
    }

    public function isFailure()
    {
        return !$this->isSuccessful();
    }

    public function getTransactionReference()
    {
        return isset($this->data['id']) ? $this->data['id'] : null;
    }

    public function getCode()
    {
        return $this->statusCode;
    }
}
