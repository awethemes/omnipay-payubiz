<?php

namespace Omnipay\PayUBiz\Messages;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * {@inheritdoc}
     */
    public function isSuccessful()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function isRedirect()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getRedirectUrl()
    {
        if (method_exists($this->request, 'getEndpoint')) {
            return $this->request->getEndpoint();
        }

        throw new \InvalidArgumentException('Incorrect request instance');
    }

    /**
     * {@inheritdoc}
     */
    public function getRedirectMethod()
    {
        return 'POST';
    }

    /**
     * {@inheritdoc}
     */
    public function getRedirectData()
    {
        return $this->getData();
    }
}
