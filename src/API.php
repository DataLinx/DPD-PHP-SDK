<?php

namespace DataLinx\DPD;

use DataLinx\DPD\Exceptions\APIException;
use JsonException;

class API
{
    /**
     * @var string API username
     */
    public string $username;

    /**
     * @var string API password
     */
    public string $password;

    /**
     * @var string Country code (ISO A-2)
     */
    public string $country_code;

    /**
     * @param string $username
     * @param string $password
     * @param string $country_code
     */
    public function __construct(string $username, string $password, string $country_code)
    {
        $this->username = $username;
        $this->password = $password;
        $this->country_code = $country_code;
    }

    /**
     * Make sure the state of the API is valid
     *
     * @throws APIException
     */
    public function validate(): void
    {
        foreach (get_object_vars($this) as $key => $val) {
            if (empty($val)) {
                throw new APIException(sprintf('API attribute "%s" is required', $key));
            }
        }

        static $valid_countries = ['SI', 'HR'];

        if (! in_array($this->country_code, $valid_countries, true)) {
            throw new APIException(sprintf('API country code can only be one of the following: %s', implode(', ', $valid_countries)));
        }
    }

    /**
     * Get the API URL, depending on the country
     *
     * @return string
     */
    public function getUrl(): string
    {
        switch ($this->country_code) {
            case 'HR':
                return 'https://easyship.hr/api/';

            case 'SI':
            default:
                return 'https://easyship.si/api/';
        }
    }

    /**
     * Send a request to the API
     *
     * @param string $endpoint Endpoint/URI
     * @param array $data Request data
     * @return array Response array
     * @throws APIException
     * @noinspection CurlSslServerSpoofingInspection
     */
    public function sendRequest(string $endpoint, array $data): array
    {
        $ch = curl_init($this->getUrl() . $endpoint . '?' . http_build_query($data));

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FAILONERROR => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POST => true,
            CURLOPT_ENCODING => 'UTF-8',
            CURLOPT_FOLLOWLOCATION => true,
        ]);

        $response = curl_exec($ch);

        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        $err_no = curl_errno($ch);

        curl_close($ch);

        if (empty($response)) {
            throw new APIException('DPD API request failed! cURL error: '. $error .' (err.no.: '. $err_no .', HTTP code: '. $code .')', $code);
        }

        try {
            return json_decode($response, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new APIException('DPD API request failed! JSON decode error: '. $exception->getMessage(), 0, $exception);
        }
    }
}
