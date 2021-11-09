<?php

namespace DataLinx\DPD\Responses;

/**
 * Interface that each API response should implement
 */
interface ResponseInterface {

	/**
	 * Was the request successful?
	 *
	 * @return bool
	 */
	public function isSuccessful() : bool;

}