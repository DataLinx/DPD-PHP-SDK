<?php

namespace DataLinx\DPD;

use InvalidArgumentException;

class Helper
{
    /**
     * Get URL for tracking the parcel
     *
     * @param string $parcel_no
     * @param string $language_id Language ID, Alpha-2 ISO standard
     * @return string
     */
    public static function getTrackingUrl(string $parcel_no, string $language_id): string
    {
        switch (strtolower($language_id))
        {
            case 'sl':
                $lang = 'si';
                break;
            case 'hr':
                $lang = $language_id;
                break;
            default:
                throw new InvalidArgumentException(sprintf('Language ID "%s" is not supported', $language_id));
        }

        return "https://www.dpdgroup.com/$lang/mydpd/my-parcels/track?parcelNumber=$parcel_no";
    }
}