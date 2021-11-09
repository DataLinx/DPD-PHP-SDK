<?php

namespace DataLinx\DPD\Responses;

class ParcelImportResponse extends AbstractResponse {

	/**
	 * Get response status:
	 * - ok: no problem occurred
	 * - err: problem occurred
	 *
	 * @return string
	 */
	public function getStatus() : string
	{
		return $this->getParameter('status');
	}

	/**
	 * Get error text message
	 *
	 * @return string
	 */
	public function getError() : string
	{
		return $this->getParameter('errlog');
	}

	/**
	 * Get parcel numbers, if status is 'ok'
	 *
	 * @return string[]
	 */
	public function getParcelNumbers() : array
	{
		return $this->getParameter('pl_number');
	}

	/**
	 * @inheritDoc
	 */
	public function isSuccessful() : bool
	{
		return $this->getStatus() === 'ok';
	}
}