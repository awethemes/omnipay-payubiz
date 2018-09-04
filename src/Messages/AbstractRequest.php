<?php

namespace Omnipay\PayUBiz\Messages;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /* Constansts */
    const LIVE_ENDPOINT = 'https://secure.payu.in/_payment';
    const TEST_ENDPOINT = 'https://test.payu.in/_payment';

    /**
     * Gets the endpoint URL.
     *
     * @return string
     */
    public function getEndPoint()
    {
        return $this->getTestMode() ? static::TEST_ENDPOINT : static::LIVE_ENDPOINT;
    }

    /**
     * Sets the key.
     *
     * @param  string $key
     * @return $this
     */
    public function setKey($key)
    {
        return $this->setParameter('key', $key);
    }

    /**
     * Sets the salt.
     *
     * @param  string $salt
     * @return $this
     */
    public function setSalt($salt)
    {
        return $this->setParameter('salt', $salt);
    }

    /**
     * Use the PayU Paisa provider.
     *
     * @param  bool $paisa
     * @return $this
     */
    public function setPayuPaisa($paisa) {
        return $this->setParameter('payuPaisa', $paisa);
    }

    /**
     * Trim trailing zeros off prices.
     *
     * @param  string $number
     * @return string
     */
    protected function trimZeros($number) {
        return preg_replace( '/\.0++$/', '', $number );
    }
}
