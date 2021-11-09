<?php

namespace DataLinx\DPD\Responses;

use DataLinx\DPD\Requests\RequestInterface;

/**
 * Abstract response class that all responses should extend
 */
abstract class AbstractResponse implements ResponseInterface {

	/**
	 * @var array Data as received by the API
	 */
	public array $data;

	/**
	 * @var RequestInterface Original request that was sent to the API
	 */
	public RequestInterface $request;

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
	 * Get response data parameter
	 *
	 * @param string $name Parameter name
	 * @return mixed|null
	 */
	protected function getParameter(string $name)
	{
		return $this->data[$name] ?? NULL;
	}
}