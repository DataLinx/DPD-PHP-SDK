<?php declare(strict_types=1);

namespace DataLinx\DPD\Tests\Feature;

use DataLinx\DPD\API;
use DataLinx\DPD\Exceptions\ValidationException;
use DataLinx\DPD\ParcelType;
use DataLinx\DPD\Requests\ParcelImport;
use DataLinx\DPD\Responses\ParcelImportResponse;
use PHPUnit\Framework\TestCase;

class ParcelImportTest extends TestCase {

	private API $api;

	public function setUp(): void
	{
		parent::setUp();

		$this->api = new API(getenv('dpd.username'), getenv('dpd.password'), getenv('dpd.country_code'));
	}

	public function testBasic() : void
	{
		$this->assertIsObject($this->api);

		$this->assertInstanceOf(API::class, $this->api);

		$this->assertEquals(getenv('dpd.username'), $this->api->username);
		$this->assertEquals(getenv('dpd.password'), $this->api->password);
		$this->assertEquals(getenv('dpd.country_code'), $this->api->country_code);

		$request = new ParcelImport($this->api);
		$request->name1 = 'Zdravko Dren';
		$request->street = 'Partizanska';
		$request->rPropNum = '44';
		$request->city = 'Izola';
		$request->country = 'SI';
		$request->pcode = '6310';
		$request->num_of_parcel = 1;
		$request->parcel_type = ParcelType::CLASSIC_COD;
		$request->cod_amount = 12.34;
		$request->cod_purpose = 'CODREF001';
		$request->predict = TRUE;

        $response = $request->send();

		$this->assertInstanceOf(ParcelImportResponse::class, $response);
		$this->assertTrue($response->isSuccessful());
        $this->assertNull($response->getError());
        $this->assertNotEmpty($response->getParcelNumbers());
        $this->assertIsArray($response->getData());
        $this->assertInstanceOf(ParcelImport::class, $response->getRequest());
	}

	public function testRequiredAttribute()
	{
		$request = new ParcelImport($this->api);

		$this->expectException(ValidationException::class);
		$this->expectExceptionCode(ValidationException::CODE_ATTR_REQUIRED);
		$this->expectExceptionMessage('Attribute "name1" is required');

		$request->validate();
	}
}