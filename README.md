# PHP SDK for the DPD EasyShip API

![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/datalinx/dpd-php-sdk)
[![Packagist Version](https://img.shields.io/packagist/v/datalinx/dpd-php-sdk)](https://packagist.org/packages/datalinx/dpd-php-sdk)
![Packagist Downloads](https://img.shields.io/packagist/dt/datalinx/dpd-php-sdk)
[![Tests](https://github.com/DataLinx/DPD-PHP-SDK/actions/workflows/test-runner.yml/badge.svg)](https://github.com/DataLinx/DPD-PHP-SDK/actions/workflows/test-runner.yml)
[![codecov](https://codecov.io/gh/DataLinx/DPD-PHP-SDK/branch/master/graph/badge.svg?token=0NKRZC1TZL)](https://codecov.io/gh/DataLinx/DPD-PHP-SDK)
[![Conventional Commits](https://img.shields.io/badge/Conventional%20Commits-1.0.0-%23FE5196?logo=conventionalcommits&logoColor=white)](https://conventionalcommits.org)
![Packagist License](https://img.shields.io/packagist/l/datalinx/dpd-php-sdk)

## About
This package implements the DPD EasyShip API for Slovenia and Croatia.  
It appears each region has its own version, so this will not work for any other country, nor will any other implementation work for Slovenia and Croatia.

## Requirements
- Supported PHP versions: 7.4 - 8.2
- Supported OS: Linux or Windows
- Required PHP extensions: curl, json

Note: the package works on PHP 8.2, but currently testing in CI for 8.2 fails, because it is still not supported in the [php-vcr](https://php-vcr.github.io/) package, which we use for testing.

## Installing
Download it with composer:
```shell
composer require datalinx/dpd-php-sdk
````

## Usage
Currently, only the `ParcelImport` endpoint is implemented.

```php
// Set up the API
$dpd = new \DataLinx\DPD\API(getenv('DPD_USERNAME'), getenv('DPD_PASSWORD'), getenv('DPD_COUNTRY_CODE'));

// Prepare the request
$request = new \DataLinx\DPD\Requests\ParcelImport($dpd);
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

try {
    $response = $request->send();
    
    // Get parcel numbers
    $parcel_no = $response->getParcelNumbers();
    
    // $parcel_no is now an array with parcel numbers, e.g. ["16962023438943"]

} catch (\DataLinx\DPD\Exceptions\ValidationException $exception) {
    // Handle request validation exception
} catch (\DataLinx\DPD\Exceptions\APIException $exception) {
    // Handle API exception
} catch (\Exception $exception) {
    // Handle other exceptions
}
```

## Contributing
Pull requests for new endpoint implementations are highly welcome.

If you have some suggestions how to make this package better, please open an issue or even better, submit a pull request.

Should you want to contribute, please see the development guidelines in the [DataLinx PHP package template](https://github.com/DataLinx/php-package-template).

### Running tests
By default, the tests run against static fixtures which were captured by the php-vcr package.

If you want to update the fixtures or run the tests against the live (but still testing) API provided by DPD, you need the username and password to run them. You can get them by writing to it@dpd.si.

Once you have the credentials, you can set them in `phpunit.xml`.

After that, you also need to set a environment variable with the name `LIVE` and value `1`. This will delete the fixtures before running the tests, which forces live requests to be made.

### Developer resources
* [DPD EasyShip website](https://easyship.si/login)
* [Webservice User Manual](https://drive.google.com/file/d/1UsbTv-dp7fOdPJwExqo5iyB1ngTnx4Rn/view?usp=share_link) (PDF)

### Changelog
All notable changes to this project are automatically documented in the [CHANGELOG.md](CHANGELOG.md) file using the release workflow, based on the [release-please](https://github.com/googleapis/release-please) GitHub action.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

For all this to work, commit messages must follow the [Conventional commits](https://www.conventionalcommits.org/) specification, which is also enforced by a Git hook. 
