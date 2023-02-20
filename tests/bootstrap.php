<?php

// Validate config
if (empty(getenv('DPD_USERNAME')) || empty(getenv('DPD_PASSWORD')) || empty(getenv('DPD_COUNTRY_CODE'))) {
    trigger_error('You must set the DPD_USERNAME, DPD_PASSWORD and DPD_COUNTRY_CODE env. variables before running the tests!', E_USER_ERROR);
}

// Include composer autoloader
require_once __DIR__ .'/../vendor/autoload.php';
