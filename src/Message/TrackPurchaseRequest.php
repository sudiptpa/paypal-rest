<?php

namespace Omnipay\PayPalRest\Message;

use Omnipay\PayPalRest\Enums\ItemTypeEnum;

/**
 * PayPal REST Track Purchase Request
 *
 * @see TrackPurchaseRequest
 * @link https://developer.paypal.com/docs/api/orders/v2/#orders_track_create
 */
class TrackPurchaseRequest extends AbstractRequest
{
    /**
     * @return string
     */
    public function getTrackingNumber()
    {
        return $this->getParameter('trackingNumber');
    }

    /**
     * @param string $value
     */
    public function setTrackingNumber($value)
    {
        return $this->setParameter('trackingNumber', $value);
    }

    /**
     * @return string
     */
    public function getCarrierName()
    {
        return $this->getParameter('carrierName');
    }

    /**
     * @param string $value
     */
    public function setCarrierName($value)
    {
        return $this->setParameter('carrierName', $value);
    }

    /**
     * @return string
     */
    public function getNotifyPayer()
    {
        return $this->getParameter('notifyPayer');
    }

    /**
     * @param string $value
     */
    public function setNotifyPayer($value)
    {
        return $this->setParameter('notifyPayer', $value);
    }

    /**
     * @return array
     */
    protected function getItemData()
    {
        $stack = [];

        $items = $this->getItems();

        if (sizeof($items)) {
            foreach ($items as $k => $item) {
                if ($item->getReference() == ItemTypeEnum::TYPE_ITEM) {
                    $stack[] = $this->filterDataRecursively([
                        'name' => $item->getName(),
                        'quantity' => $item->getQuantity(),
                        'description' => $item->getDescription(),
                        'sku' => $item->getSku(),
                    ]);
                }

            }
        }

        return $stack;
    }

    public function getData()
    {
        $this->validate('transactionReference', 'captureId', 'trackingNumber', 'carrierName');

        return [
            'capture_id' => $this->getCaptureId(),
            'tracking_number' => $this->getTrackingNumber(),
            'carrier' => 'OTHER',
            'carrier_name_other' => $this->getCarrierName(),
            'notify_payer' => $this->getNotifyPayer(),
            'items' => $this->getItemData(),
        ];
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . '/checkout/orders/' . $this->getTransactionReference() . '/track';
    }
}
