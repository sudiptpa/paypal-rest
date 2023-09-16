<?php
/**
 * PayPalRest Item
 */

namespace Omnipay\PayPalRest;

use Omnipay\Common\Item;

/**
 * Class PayPalItem
 *
 * @package Omnipay\PayPalRest
 */
class PayPalItem extends Item
{
    /**
     * {@inheritDoc}
     */
    public function getSku()
    {
        return $this->getParameter('sku');
    }

    /**
     * Set the item SKU
     */
    public function setSku($value)
    {
        return $this->setParameter('sku', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getCategory()
    {
        return $this->getParameter('category');
    }

    /**
     * Set the item Category
     */
    public function setCategory($value)
    {
        return $this->setParameter('category', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getReference()
    {
        return $this->getParameter('reference');
    }

    /**
     * Set the item Category
     */
    public function setReference($value)
    {
        return $this->setParameter('reference', $value);
    }
}
