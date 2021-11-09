<?php

namespace DataLinx\DPD\Requests;

use DataLinx\DPD\Exceptions\ValidationException;
use DataLinx\DPD\ParcelCODType;
use DataLinx\DPD\ParcelType;
use DataLinx\DPD\Responses\ParcelImportResponse;
use DataLinx\DPD\Responses\ResponseInterface;

class ParcelImport extends AbstractRequest {

	/**
	 * @var string Receiver company or personal name
	 */
	public string $name1;

	/**
	 * @var string|null Receiver additional name (if needed)
	 */
	public ?string $name2 = null;

	/**
	 * @var string|null Receiver contact person
	 */
	public ?string $contact = null;

	/**
	 * @var string Receiver street
	 */
	public string $street;

	/**
	 * @var string Receiver house number (case-sensitive)
	 */
	public string $rPropNum;

	/**
	 * @var string Receiver city
	 */
	public string $city;

	/**
	 * @var string Receiver country code (ISO2 standard)
	 */
	public string $country;

	/**
	 * @var string Receiver postal code
	 */
	public string $pcode;

	/**
	 * @var string|null Receiver E-mail address, mandatory for PUDO and export parcels
	 */
	public ?string $email = null;

	/**
	 * @var string|null Receiver phone number, mandatory for PUDO and export parcels
	 */
	public ?string $phone = null;

	/**
	 * @var string|null Delivery instructions for courier
	 */
	public ?string $sender_remark = null;

	/**
	 * @var float|null Parcel weight (kg), mandatory for PUDO parcels
	 */
	public ?float $weight = null;

	/**
	 * @var int Number of parcel labels to be generated
	 */
	public int $num_of_parcel;

	/**
	 * @var string|null Customer’s parcel reference
	 */
	public ?string $order_number = null;

	/**
	 * @var string|null Customer’s additional parcel reference
	 */
	public ?string $order_number2 = null;

	/**
	 * @var string Parcel type string
	 * @see ParcelType
	 */
	public string $parcel_type;

	/**
	 * @var string|null Parcel COD type
	 * @see ParcelCODType
	 */
	public ?string $parcel_cod_type = null;

	/**
	 * @var float|null Mandatory for COD, the value is in destination country currency
	 */
	public ?float $cod_amount = null;

	/**
	 * @var string|null Mandatory for COD, this is customer's COD reference
	 */
	public ?string $cod_purpose = null;

	/**
	 * @var bool|null Predict notification, mandatory for B2C parcels
	 */
	public ?bool $predict = null;

	/**
	 * @var bool|null Required for ID check activation
	 */
	public ?bool $is_id_check = null;

	/**
	 * @var string|null Required for ID check activation - Name of person for ID check
	 */
	public ?string $id_check_receiver = null;

	/**
	 * @var string|null Receiver ID check document number
	 */
	public ?string $id_check_num = null;

	/**
	 * @var string|null Sender company name on the label
	 */
	public ?string $sender_name = null;

	/**
	 * @var string|null Sender city on the label
	 */
	public ?string $sender_city = null;

	/**
	 * @var string|null Sender postal code on the label
	 */
	public ?string $sender_pcode = null;

	/**
	 * @var string|null Sender country on the label
	 */
	public ?string $sender_country = null;

	/**
	 * @var string|null Sender street on the label
	 */
	public ?string $sender_street = null;

	/**
	 * @var string|null Sender phone number. on the label
	 */
	public ?string $sender_phone = null;

	/**
	 * @var ?string PUDO ID, mandatory for direct sending to PUDO location (example: HR00006)
	 */
	public ?string $pudo_id = null;

	/**
	 * @var int|null Length of the parcel - Mandatory for Pallet product
	 */
	public ?int $length = null;

	/**
	 * @var int|null Width of the parcel - Mandatory for Pallet product
	 */
	public ?int $width = null;

	/**
	 * @var int|null Height of the parcel - Mandatory for Pallet product
	 */
	public ?int $height = null;

	/**
	 * @inheritDoc
	 */
	public function validate() : void
	{
		static $required = [
			'name1',
			'street',
			'rPropNum',
			'city',
			'country',
			'pcode',
			'num_of_parcel',
			'parcel_type',
		];

		$additional = [];

		switch ($this->parcel_type ?? NULL)
		{
			case ParcelType::CLASSIC_COD:
			case ParcelType::HOME_COD:
			case ParcelType::HOME_COD_RETURN:
				$additional[] = 'cod_amount';
				$additional[] = 'cod_purpose';
				break;

			case ParcelType::PALLET:
				$additional[] = 'length';
				$additional[] = 'width';
				$additional[] = 'height';
				break;
		}

		if ($this->pudo_id)
		{
			$additional[] = 'weight';
		}

		if ($this->is_id_check)
		{
			$additional[] = 'id_check_receiver';
		}

		foreach ($required + $additional as $attr)
		{
			if ( ! isset($this->$attr))
			{
				throw new ValidationException($attr, ValidationException::CODE_ATTR_REQUIRED);
			}
		}
	}

	/**
	 * @inheritDoc
	 */
	public function getData() : array
	{
		// Required attributes
		// ------------------------------------------------------------
		$data = [
			'name1' => $this->name1,
			'street' => $this->street,
			'rPropNum' => $this->rPropNum,
			'city' => $this->city,
			'country' => $this->country,
			'pcode' => $this->pcode,
			'num_of_parcel' => $this->num_of_parcel,
			'parcel_type' => $this->parcel_type,
		];

		// Optional attributes
		// ------------------------------------------------------------
		$optional = [
			'name2',
			'contact',
			'email',
			'phone',
			'sender_remark',
			'order_number',
			'order_number2',
			'parcel_cod_type',
			'cod_purpose',
			'id_check_receiver',
			'id_check_num',
			'sender_name',
			'sender_city',
			'sender_pcode',
			'sender_country',
			'sender_street',
			'sender_phone',
			'pudo_id',
		];

		foreach ($optional as $attr)
		{
			if (isset($this->$attr))
			{
				$data[$attr] = $this->$attr;
			}
		}

		// Attributes that require formatting:
		// ------------------------------------------------------------
		// Weight in kg
		if ($this->pudo_id)
		{
			$data['weight'] = number_format($this->weight, 3);
		}

		// COD amount
		if ($this->cod_amount)
		{
			$data['cod_amount'] = number_format($this->cod_amount, 2);
		}

		// Receiver notifications
		if (isset($this->predict))
		{
			$data['predict'] = $this->predict ? 1 : 0;
		}

		// ID check
		if (isset($this->is_id_check))
		{
			$data['is_id_check'] = $this->is_id_check ? 1 : 0;
		}

		// Pallet dimensions
		if ($this->length)
		{
			$data['dimension'] =
				str_pad($this->length, 3, '0', STR_PAD_LEFT) .
				str_pad($this->width, 3, '0', STR_PAD_LEFT) .
				str_pad($this->height, 3, '0', STR_PAD_LEFT);
		}

		return $data;
	}

	/**
	 * @inheritDoc
	 */
	public function getEndpoint() : string
	{
		return 'parcel/parcel_import';
	}

	/**
	 * @inheritDoc
	 */
	public function createResponse($data): ResponseInterface
	{
		return new ParcelImportResponse($data, $this);
	}
}