<?php

namespace DataLinx\DPD;

class ParcelCODType
{
    /**
     * The amount of each parcel will be the average amount of the given cod_amount
     */
    public const AVERAGE = 'avg';

    /**
     * All parcels have the same amount which is in the cod_amount field
     */
    public const ALL = 'all';

    /**
     * Only the first parcel will have the COD amount and the other parcels will be DPD Classic parcels
     */
    public const FIRST_ONLY = 'firstonly';
}
