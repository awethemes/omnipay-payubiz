<?php

namespace Omnipay\PayUBiz\Messages;

class CompletePurchaseResponse extends \Omnipay\Common\Message\AbstractResponse
{
    /**
     * {@inheritdoc}
     */
    public function isSuccessful()
    {
        return isset($this->data['status']) && 'success' === $this->data['status'];
    }

    /**
     * {@inheritdoc}
     */
    public function isPending()
    {
        return isset($this->data['status']) && 'pending' === $this->data['status'];
    }

    /**
     * {@inheritdoc}
     */
    public function getTransactionReference()
    {
        if (isset($this->data['txnid']) && ! empty($this->data['txnid'])) {
            return (string) $this->data['txnid'];
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        if (!$this->isSuccessful() && isset($this->data['error_Message'])) {
            return $this->data['error_Message'];
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getCode()
    {
        if (!$this->isSuccessful() && isset($this->data['error'])) {
            return $this->data['error'];
        }

        return null;
    }
}
