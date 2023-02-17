<?php

declare(strict_types=1);

namespace DataLinx\DPD\Tests\Unit;

use DataLinx\DPD\Helper;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    public function testGetTrackingUrl(): void
    {
        $this->assertEquals('https://www.dpdgroup.com/si/mydpd/my-parcels/track?parcelNumber=XXX', Helper::getTrackingUrl('XXX', 'sl'));
        $this->assertEquals('https://www.dpdgroup.com/hr/mydpd/my-parcels/track?parcelNumber=XXX', Helper::getTrackingUrl('XXX', 'hr'));

        $this->expectException(InvalidArgumentException::class);
        Helper::getTrackingUrl('XXX', 'it');
    }
}
