<?php

namespace Omnipay\PayPalRest\Message;

use Omnipay\PayPalRest\Enums\ItemTypeEnum;

/**
 * @link https://developer.paypal.com/docs/api/orders/v2/#orders_create
 * @link https://developer.paypal.com/docs/api/orders/v2/#orders_capture
 */
class PurchaseRequest extends AbstractRequest
{
    /**
     * @return array
     */
    public function getData()
    {
        $card = $this->getCard();

        $stack = $this->filterDataRecursively([
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'reference_id' => $this->getTransactionId(),
                    'invoice_id' => $this->getTransactionReference(),
                    'description' => $this->getDescription(),
                    'shipping' => [
                        'type' => $card ? $this->getShippingType() : null,
                        'full_name' => $card ? $card->getShippingName() : null,
                        'address' => [
                            'address_line_1' => $card ? $card->getShippingAddress1() : null,
                            'address_line_2' => $card ? $card->getShippingAddress2() : null,
                            'admin_area_2' => $card ? $card->getShippingCity() : null,
                            'admin_area_1' => $card ? $card->getShippingState() : null,
                            'postal_code' => $card ? $card->getShippingPostcode() : null,
                            'country_code' => strtoupper($card ? $card->getShippingCountry() : null),
                        ],
                    ],
                    'items' => $this->getItemData(),
                    'amount' => [
                        'currency_code' => $this->getCurrency(),
                        'value' => $this->formatAmount($this->getAmount()),
                        'breakdown' => $this->getItemsBreakdown($this->getItems()),
                    ],
                ],
            ],
            'payment_source' => [
                'paypal' => [
                    'experience_context' => [
                        'shipping_preference' => $card ? 'SET_PROVIDED_ADDRESS' : 'NO_SHIPPING',
                        'landing_page' => 'LOGIN',
                        'payment_method_preference' => 'IMMEDIATE_PAYMENT_REQUIRED',
                        'user_action' => 'PAY_NOW',
                        'return_url' => $this->getReturnUrl(),
                        'cancel_url' => $this->getCancelUrl(),
                    ],
                ],
            ],
        ]);

        return $stack;
    }

    /**
     * @param $items
     * @return array
     */
    public function getItemsBreakDown($items)
    {
        $stack = [];

        if ($item_total = $this->getTotalByReference($items, ItemTypeEnum::TYPE_ITEM)) {
            $stack['item_total'] = [
                'currency_code' => $this->getCurrency(),
                'value' => $this->formatAmount($item_total),
            ];
        }

        if ($tax_total = $this->getTotalByReference($items, ItemTypeEnum::TYPE_TAX)) {
            $stack['tax_total'] = [
                'currency_code' => $this->getCurrency(),
                'value' => $this->formatAmount($tax_total),
            ];
        }

        if ($shipping_total = $this->getTotalByReference($items, ItemTypeEnum::TYPE_SHIPPING)) {
            $stack['shipping'] = [
                'currency_code' => $this->getCurrency(),
                'value' => $this->formatAmount($shipping_total),
            ];
        }

        if ($handling_total = $this->getTotalByReference($items, ItemTypeEnum::TYPE_HANDLING)) {
            $stack['handling'] = [
                'currency_code' => $this->getCurrency(),
                'value' => $this->formatAmount($handling_total),
            ];
        }

        if ($insurance_total = $this->getTotalByReference($items, ItemTypeEnum::TYPE_INSURANCE)) {
            $stack['insurance'] = [
                'currency_code' => $this->getCurrency(),
                'value' => $this->formatAmount($insurance_total),
            ];
        }

        if ($discount_total = $this->getTotalByReference($items, ItemTypeEnum::TYPE_DISCOUNT)) {
            $stack['discount'] = [
                'currency_code' => $this->getCurrency(),
                'value' => $this->formatAmount($discount_total),
            ];
        }

        return $stack;
    }

    /**
     * @param $amount
     */
    public function formatAmount($amount)
    {
        return number_format($amount, 2, '.', '');
    }

    /**
     * @param $stack
     * @param $reference
     * @return float
     */
    public function getTotalByReference($stack, $reference)
    {
        $amount = 0;

        foreach ($stack as $k => $item) {
            if ($item->getReference() == $reference) {
                $amount += $this->formatCurrency($item->getQuantity() * $item->getPrice());
            }
        }

        return $amount;
    }

    /**
     * @return string
     */
    protected function getEndpoint()
    {
        return parent::getEndpoint() . '/checkout/orders';
    }

    /**
     * @param $data
     * @param $statusCode
     * @return \Omnipay\PayPalRest\Message\PurchaseResponse
     */
    protected function createResponse($data, $statusCode)
    {
        return $this->response = new PurchaseResponse($this, $data, $statusCode);
    }
}
