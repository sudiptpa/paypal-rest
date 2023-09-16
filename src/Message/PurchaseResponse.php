<?php
namespace Omnipay\PayPalRest\Message;

use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * PayPal REST Purchase Response
 */
class PurchaseResponse extends Response implements RedirectResponseInterface
{
    /**
     * @return boolean
     */
    public function isRedirect()
    {
        return $this->getRedirectUrl() !== null;
    }

    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        if (isset($this->data['links']) && is_array($this->data['links'])) {
            foreach ($this->data['links'] as $key => $value) {
                if ($value['rel'] == 'payer-action') {
                    return $value['href'];
                }
            }
        }

        return null;
    }

    public function getTransactionReference()
    {
        return isset($this->data['id']) ? $this->data['id'] : null;
    }

    /**
     * Get the required redirect method (either GET or POST).
     *
     * @return string
     */
    public function getRedirectMethod()
    {
        return 'GET';
    }

    /**
     * Gets the redirect form data array, if the redirect method is POST.
     *
     * @return null
     */
    public function getRedirectData()
    {
        return null;
    }
}
