<?php

namespace DataLinx\DPD;

class ParcelType {

	/**
	 * DPD Classic
	 */
	const CLASSIC = 'D';

	/**
	 * DPD Classic COD (cash on delivery)
	 */
	const CLASSIC_COD = 'D-COD';

	/**
	 * DPD Classic Document return
	 */
	const CLASSIC_DOCUMENT_RETURN = 'D-DOCRET';

	/**
	 * DPD Home (B2C)
	 */
	const HOME_B2C = 'D-B2C';

	/**
	 * DPD Home COD
	 */
	const HOME_COD = 'D-COD-B2C';

	/**
	 * Exchange
	 */
	const EXCHANGE = 'D-SWAP';

	/**
	 * Tyre
	 */
	const TYRE = 'D-TYRE';

	/**
	 * Tyre (B2C)
	 */
	const TYRE_B2C = 'D-TYRE-B2C';

	/**
	 * Parcel shop
	 */
	const PARCEL_SHOP = 'D-B2C-PSD';

	/**
	 * Pallet
	 */
	const PALLET = 'PAL';

	/**
	 * DPD Home COD with return label
	 */
	const HOME_COD_RETURN = 'D-COD-B2C-RP';
}