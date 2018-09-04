<?php

namespace Omnipay\PayUBiz\Messages;

use Omnipay\Common\Exception\InvalidRequestException;

class CompletePurchaseRequest extends AbstractRequest
{
    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->httpRequest->request->all();
    }

    /**
     * {@inheritdoc}
     */
    public function sendData($data)
    {
        $this->checkRequestHash();

        return $this->response = new CompletePurchaseResponse($this, $data);
    }

    /**
     * Check request hash.
     *
     * @throws InvalidRequestException
     */
    protected function checkRequestHash() {
        $request = $this->httpRequest->request;

        $params = [
            $this->getParameter('salt'),
            $request->get('status'),
            '|||||||||',
            $request->get('email'),
            $request->get('firstname'),
            $request->get('productinfo'),
            $request->get('amount'),
            $request->get('txnid'),
            $request->get('key'),
        ];

        If ($request->has('additionalCharges')) {
            array_unshift( $params, $request->get('additionalCharges'));
        }

        $hash = strtolower(hash('sha512', implode('|', $params)));

        if ( ! hash_equals($request->get('hash'), $hash)) {
            throw new InvalidRequestException('Invalid Transaction. Please try again');
        }
    }
}
