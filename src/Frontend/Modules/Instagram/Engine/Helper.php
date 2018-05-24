<?php

namespace Frontend\Modules\Instagram\Engine;

use Frontend\Core\Engine\Model as FrontendModel;

/**
 * In this file we store all generic functions that we will be using in the instagram module.
 * Created with help from https://github.com/cosenary/Instagram-PHP-API
 *
 * @author Jesse Dobbelaere <jesse@dobbelae.re>
 */
class Helper
{
    /**
     * The API base URL.
     */
    const API_URL = 'https://api.instagram.com/v1/';

    /**
     * Get user recent media.
     *
     * @param int|string $id Instagram user ID
     * @param int $limit Limit of returned results
     *
     * @return mixed
     * @throws \Exception
     */
    public static function getUserMedia($id = 'self', $limit = 0)
    {
        $params = array();
        if ($limit > 0) {
            $params['count'] = $limit;
        }
        return self::makeApiCall('users/' . $id . '/media/recent', strlen(self::getAccessToken()), $params);
    }

    /**
     * The call operator.
     *
     * @param string $function API resource path
     * @param bool $auth Whether the function requires an access token
     * @param array $params Additional request parameters
     * @param string $method Request type GET|POST
     *
     * @return mixed
     *
     * @throws \Exception
     */
    protected static function makeApiCall($function, $auth = false, $params = null, $method = 'GET')
    {
        if (!$auth) {
            // if the call doesn't requires authentication
            $authMethod = '?client_id=' . self::getApiKey();
        } else {
            $authMethod = '?access_token=' . self::getAccessToken();
        }
        $paramString = null;
        if (isset($params) && is_array($params)) {
            $paramString = '&' . http_build_query($params);
        }
        $apiCall = self::API_URL . $function . $authMethod . (('GET' === $method) ? $paramString : null);

        // signed header of POST/DELETE requests
        $headerData = array('Accept: application/json');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiCall);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerData);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, true);
        switch ($method) {
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, count($params));
                curl_setopt($ch, CURLOPT_POSTFIELDS, ltrim($paramString, '&'));
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }
        $jsonData = curl_exec($ch);

        // split header from JSON data
        // and assign each to a variable
        list($headerContent, $jsonData) = explode("\r\n\r\n", $jsonData, 2);

        // convert header content into an array
        $headers = self::processHeaders($headerContent);

        // get the 'X-Ratelimit-Remaining' header value
        //$this->_xRateLimitRemaining = $headers['X-Ratelimit-Remaining'];

        if (!$jsonData) {
            throw new \Exception('Error: _makeCall() - cURL error: ' . curl_error($ch));
        }
        curl_close($ch);
        return json_decode($jsonData);
    }

    /**
     * Read and process response header content.
     *
     * @param array
     *
     * @return array
     */
    private static function processHeaders($headerContent): array
    {
        $headers = array();
        foreach (explode("\r\n", $headerContent) as $i => $line) {
            if ($i === 0) {
                $headers['http_code'] = $line;
                continue;
            }
            list($key, $value) = explode(':', $line);
            $headers[$key] = $value;
        }
        return $headers;
    }

    /**
     * Get the API key (client ID) from the settings
     *
     * @return string The API key
     */
    private static function getApiKey(): string
    {
        return FrontendModel::get('fork.settings')->get('Instagram', 'client_id');
    }

    /**
     * Get the access token from the settings
     *
     * @return string Access token
     */
    private static function getAccessToken(): string
    {
        return FrontendModel::get('fork.settings')->get('Instagram', 'access_token');
    }
}
