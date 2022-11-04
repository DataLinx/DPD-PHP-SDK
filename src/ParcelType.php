<?php

namespace DataLinx\DPD;

class ParcelType
{
    /**
     * DPD Classic
     */
    public const CLASSIC = 'D';

    /**
     * DPD Classic COD (cash on delivery)
     */
    public const CLASSIC_COD = 'D-COD';

    /**
     * DPD Classic Document return
     */
    public const CLASSIC_DOCUMENT_RETURN = 'D-DOCRET';

    /**
     * DPD Home (B2C)
     */
    public const HOME_B2C = 'D-B2C';

    /**
     * DPD Home COD
     */
    public const HOME_COD = 'D-COD-B2C';

    /**
     * Exchange
     */
    public const EXCHANGE = 'D-SWAP';

    /**
     * Tyre
     */
    public const TYRE = 'D-TYRE';

    /**
     * Tyre (B2C)
     */
    public const TYRE_B2C = 'D-TYRE-B2C';

    /**
     * Parcel shop
     */
    public const PARCEL_SHOP = 'D-B2C-PSD';

    /**
     * Pallet
     */
    public const PALLET = 'PAL';

    /**
     * DPD Home COD with return label
     */
    public const HOME_COD_RETURN = 'D-COD-B2C-RP';
}
