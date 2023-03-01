<?php

use allejo\VCR\VCRCleaner;
use VCR\VCR;

// Validate config
if (empty(getenv('DPD_USERNAME')) || empty(getenv('DPD_PASSWORD')) || empty(getenv('DPD_COUNTRY_CODE'))) {
    trigger_error('You must set the DPD_USERNAME, DPD_PASSWORD and DPD_COUNTRY_CODE env. variables before running the tests!', E_USER_ERROR);
}

// Include composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Include php-utils helper
require_once __DIR__ . '/../vendor/datalinx/php-utils/src/fluent_helpers.php';

// Delete test fixtures if live mode is requested
$fixtures_dir = __DIR__ . '/fixtures';

if (filter_input(INPUT_ENV, 'LIVE')) {
    echo 'Deleting existing fixtures to fetch new ones...' . PHP_EOL;
    directory($fixtures_dir)->clear();
} else {
    echo 'Using existing fixtures.' . PHP_EOL;
}

// Configure VCR
VCR::configure()
    ->setStorage('json')
    ->setCassettePath($fixtures_dir)
    ->enableLibraryHooks(['curl']);

VCR::turnOn();

// Configure VCR data sanitization
VCRCleaner::enable([
    'request' => [
        'ignoreQueryFields' => [
            'username',
            'password',
        ],
    ],
]);
