<?php

namespace DataLinx\DPD\Requests;

use DataLinx\DPD\API;
use DataLinx\DPD\Exceptions\APIException;
use DataLinx\DPD\Exceptions\ValidationException;

/**
 * Abstract request class that all requests should extend
 */
abstract class AbstractRequest implements RequestInterface
{
    /**
     * API instance
     *
     * @var API
     */
    protected API $api;

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
     * @throws APIException
     * @throws ValidationException
     */
    protected function sendRequest(): array
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
