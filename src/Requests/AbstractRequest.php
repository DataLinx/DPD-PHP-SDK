<?php

namespace DataLinx\DPD\Requests;

use DataLinx\DPD\API;

/**
 * Abstract request class that all requests should extend
 */
abstract class AbstractRequest implements RequestInterface {

    /**
     * API instance
     *
     * @var API
     */
    protected $api;

    /**
     * Create request object
     *
     * @param API $api
     */
    public function __construct(API $api)
    {
        $this->api = $api;
    }

    /**
     * Send request via API
     *
     * @return array
     * @throws \DataLinx\DPD\Exceptions\APIException
     * @throws \DataLinx\DPD\Exceptions\ValidationException
     */
    protected function sendRequest()
    {
        $this->api->validate();
        $this->validate();

        $data = [
            'username' => $this->api->username,
            'password' => $this->api->password,
        ];

        $data += $this->getData();

        return $this->api->sendRequest($this->getEndpoint(), $data);
    }
}