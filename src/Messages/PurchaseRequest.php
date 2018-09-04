<?php

namespace Omnipay\PayUBiz\Messages;

class PurchaseRequest extends AbstractRequest
{
    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $this->validate(
            'key', 'salt', 'transactionId', 'description', 'email'
        );

        $data                = [];
        $data['key']         = $this->getParameter('key');
        $data['txnid']       = $this->getTransactionId();
        $data['amount']      = round($this->trimZeros($this->getAmount()));
        $data['productinfo'] = $this->getDescription();
        $data['firstname']   = $this->getParameter('firstName') ?: $this->getParameter('name');
        $data['lastname']    = $this->getParameter('lastName');
        $data['hash']        = $this->generateHash();
        $data['email']       = $this->getParameter('email');
        $data['curl']        = $this->getCancelUrl();
        $data['surl']        = $this->getReturnUrl();
        $data['furl']        = $this->getParameter('failureUrl');
        $data['pg']          = 'NB';

        if ($this->getParameter('payuPaisa')) {
            $data['service_provider'] = 'payu_paisa';
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }

    public function setName($name)
    {
        $this->setParameter('name', $name);
    }

    public function setProduct($productInfo)
    {
        $this->setParameter('product', $productInfo);
    }

    public function setFirstName($name)
    {
        $this->setParameter('firstName', $name);
    }

    public function setLastName($name)
    {
        $this->setParameter('lastName', $name);
    }

    public function setEmail($email)
    {
        $this->setParameter('email', $email);
    }

    public function setFailureUrl($furl)
    {
        $this->setParameter('failureUrl', $furl);
    }

    public function setUdf($index, $value)
    {
        if ($index <= 5 && $index > 0) {
            $this->setParameter('udf' . $index, $value);
        }
    }

    public function getUdf()
    {
        return array_map(function ($index) {
            return $this->getParameter('udf' . $index);
        }, range(1, 10));
    }

    protected function generateHash()
    {
        $params = array_merge([
            $this->getParameter('key'),
            $this->getParameter('transactionId'),
            round($this->trimZeros($this->getParameter('amount'))),
            $this->getDescription(),
            $this->getParameter('firstName') ?: $this->getParameter('name'),
            $this->getParameter('email'),
        ], $this->getUdf(), (array) $this->getParameter('salt'));

        return strtolower(hash('sha512', implode('|', $params)));
    }
}
