<?php

namespace Omnipay\PayUBiz;

use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'PayUBiz';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultParameters()
    {
        return [
            'salt' => '',
            'key'  => '',
        ];
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
     * Use the PayU Paisa provider?
     *
     * @param  bool $paisa
     * @return $this
     */
    public function setPayuPaisa($paisa) {
        return $this->setParameter('payuPaisa', $paisa);
    }

    /**
     * {@inheritdoc}
     */
    public function purchase(array $options = [])
    {
        return $this->createRequest(Messages\PurchaseRequest::class, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function completePurchase(array $options = [])
    {
        return $this->createRequest(Messages\CompletePurchaseRequest::class, $options);
    }
}
