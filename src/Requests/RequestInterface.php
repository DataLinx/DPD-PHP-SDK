<?php

namespace DataLinx\DPD\Requests;

use DataLinx\DPD\Exceptions\ValidationException;
use DataLinx\DPD\Responses\ResponseInterface;

/**
 * Request interface that all requests should implement
 */
interface RequestInterface
{
    /**
     * Validate the request before sending.
     * @throws ValidationException
     */
    public function validate(): void;

    /**
     * Get request data - associative array
     *
     * @return array
     */
    public function getData(): array;

    /**
     * Get API endpoint / URI
     *
     * @return string
     */
    public function getEndpoint(): string;

    /**
     * Send the request to the API
     *
     * @return ResponseInterface
     */
    public function send(): ResponseInterface;
}
