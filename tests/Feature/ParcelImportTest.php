<?php

declare(strict_types=1);

namespace DataLinx\DPD\Tests\Feature;

use DataLinx\DPD\API;
use DataLinx\DPD\Exceptions\APIException;
use DataLinx\DPD\Exceptions\ValidationException;
use DataLinx\DPD\ParcelType;
use DataLinx\DPD\Requests\ParcelImport;
use PHPUnit\Framework\TestCase;

class ParcelImportTest extends TestCase
{
    private API $api;

    public function setUp(): void
    {
        parent::setUp();

        $this->api = new API(getenv('DPD_USERNAME'), getenv('DPD_PASSWORD'), getenv('DPD_COUNTRY_CODE'));
    }

    /**
     * @throws ValidationException
     * @throws APIException
     */
    public function testBasic(): void
    {
        $this->assertIsObject($this->api);

        $this->assertInstanceOf(API::class, $this->api);

        $this->assertEquals(getenv('DPD_USERNAME'), $this->api->username);
        $this->assertEquals(getenv('DPD_PASSWORD'), $this->api->password);
        $this->assertEquals(getenv('DPD_COUNTRY_CODE'), $this->api->country_code);

        $request = new ParcelImport($this->api);
        $request->name1 = 'Zdravko Dren';
        $request->street = 'Partizanska';
        $request->rPropNum = '44';
        $request->city = 'Izola';
        $request->country = 'SI';
        $request->pcode = '6310';
        $request->num_of_parcel = 1;
        $request->parcel_type = ParcelType::CLASSIC_COD;
        $request->cod_amount = 1234.56;
        $request->cod_purpose = 'CODREF001';
        $request->predict = true;

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertNull($response->getError());
        $this->assertNotEmpty($response->getParcelNumbers());
        $this->assertIsArray($response->getData());
        $this->assertInstanceOf(ParcelImport::class, $response->getRequest());
    }

    public function testRequiredAttribute(): void
    {
        $request = new ParcelImport($this->api);

        $this->expectException(ValidationException::class);
        $this->expectExceptionCode(ValidationException::CODE_ATTR_REQUIRED);
        $this->expectExceptionMessage('Attribute "name1" is required');

        $request->validate();
    }

    /**
     * @throws ValidationException
     * @throws APIException
     */
    public function testNoPropNum(): void
    {
        $request = new ParcelImport($this->api);
        $request->name1 = 'Zdravko Dren';
        $request->street = 'Partizanska 12';
        $request->rPropNum = null;
        $request->city = 'Izola';
        $request->country = 'SI';
        $request->pcode = '6310';
        $request->num_of_parcel = 1;
        $request->parcel_type = ParcelType::HOME_B2C;
        $request->predict = true;
        $request->phone = '090123456';

        $response = $request->send();

        $this->assertIsObject($response);
    }
}
