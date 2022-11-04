<?php

namespace DataLinx\DPD\Responses;

use DataLinx\DPD\Requests\RequestInterface;

/**
 * Abstract response class that all responses should extend
 */
abstract class AbstractResponse implements ResponseInterface
{
    /**
     * @var array Data as received by the API
     */
    protected array $data;

    /**
     * @var RequestInterface Original request that was sent to the API
     */
    protected RequestInterface $request;

    /**
     * @param array $data Response data
     * @param RequestInterface $request Original request
     */
    public function __construct(array $data, RequestInterface $request)
    {
        $this->data = $data;
        $this->request = $request;
    }

    /**
     * Get internal data array
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Get associated request that was sent to the API
     *
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    /**
     * Get response data parameter
     *
     * @param string $name Parameter name
     * @return mixed|null
     */
    protected function getParameter(string $name)
    {
        return $this->data[$name] ?? null;
    }
}
