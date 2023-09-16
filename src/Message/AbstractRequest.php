<?php
namespace Omnipay\PayPalRest\Message;

use Exception;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\ItemBag;
use Omnipay\PayPalRest\Enums\CategoryEnum;
use Omnipay\PayPalRest\Enums\ItemTypeEnum;
use Omnipay\PayPalRest\PayPalItemBag;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    const API_VERSION = 'v2';

    /**
     * @var string
     */
    protected $testEndpoint = 'https://api-m.sandbox.paypal.com';

    /**
     * @var string
     */
    protected $liveEndpoint = 'https://api-m.paypal.com';

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->getParameter('clientId');
    }

    /**
     * @param $value
     * @return \Omnipay\PayPalRest\Message\AbstractRequest
     */
    public function setClientId($value)
    {
        return $this->setParameter('clientId', $value);
    }

    /**
     * @return string
     */
    public function getSecret()
    {
        return $this->getParameter('secret');
    }

    /**
     * @param $value
     * @return \Omnipay\PayPalRest\Message\AbstractRequest
     */
    public function setSecret($value)
    {
        return $this->setParameter('secret', $value);
    }

    /**
     * @return string
     */
    public function getShippingType()
    {
        return $this->getParameter('shippingType');
    }

    /**
     * @param $value
     * @return \Omnipay\PayPalRest\Message\AbstractRequest
     */
    public function setShippingType($value)
    {
        return $this->setParameter('shippingType', $value);
    }

    /**
     * @return string
     */
    public function getCaptureId()
    {
        return $this->getParameter('captureId');
    }

    /**
     * @param string $value
     */
    public function setCaptureId($value)
    {
        return $this->setParameter('captureId', $value);
    }

    protected function getHttpMethod()
    {
        return 'POST';
    }

    /**
     * @return string
     */
    protected function getBaseEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    /**
     * @return string
     */
    protected function getEndpoint()
    {
        return $this->getBaseEndpoint() . '/' . self::API_VERSION;
    }

    /**
     * @param $data
     * @return \Omnipay\PayPalRest\Message\Response|Exception
     */
    public function sendData($data)
    {
        if ($this->getHttpMethod() == 'GET') {
            $requestUrl = $this->getEndpoint() . '?' . http_build_query($data);
            $body = null;
        } else {
            $body = sizeof($data) ? $this->toJSON($data) : null;
            $requestUrl = $this->getEndpoint();
        }

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->getToken(),
            'Content-Type' => 'application/json; charset=UTF-8;',
        ];

        try {
            $httpResponse = $this->httpClient->request(
                $this->getHttpMethod(),
                $requestUrl,
                $headers,
                $body
            );

            $body = json_decode($httpResponse->getBody()->getContents(), true);

            return $this->createResponse($body, $httpResponse->getStatusCode());
        } catch (ClientErrorResponseException $e) {
            $httpResponse = $e->getResponse();

            $body = json_decode($httpResponse->getBody()->getContents(), true);

            return $this->createResponse($body, $httpResponse->getStatusCode());
        } catch (Exception $e) {
            throw new InvalidResponseException(
                'Error communicating with payment gateway: ' . $e->getMessage(),
                $e->getCode()
            );
        }
    }

    /**
     * @param int $options http://php.net/manual/en/json.constants.php
     * @return string
     */
    public function toJSON($data, $options = 0)
    {
        return json_encode($data, $options | 64);
    }

    /**
     * @param array $array
     */
    public function filterDataRecursively($array = [])
    {
        foreach ($array as &$value) {
            if (is_array($value)) {
                $value = $this->filterDataRecursively($value);
            }
        }

        return array_filter($array);
    }

    /**
     * Set the items in this order
     *
     * @param \Omnipay\Common\ItemBag|array $items An array of items in this order
     */
    public function setItems($items)
    {
        if ($items && !$items instanceof ItemBag) {
            $items = new PayPalItemBag($items);
        }

        return $this->setParameter('items', $items);
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
                        'category' => $item->getCategory() ?: CategoryEnum::TYPE_PHYSICAL_GOODS,
                        'unit_amount' => [
                            'currency_code' => $this->getCurrency(),
                            'value' => $this->formatCurrency($item->getPrice()),
                        ],
                    ]);
                }
            }
        }

        return $stack;
    }

    /**
     * @param $data
     * @param $statusCode
     * @return \Omnipay\PayPalRest\Message\Response
     */
    protected function createResponse($data, $statusCode)
    {
        return $this->response = new Response($this, $data, $statusCode);
    }
}
