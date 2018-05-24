<?php

namespace Backend\Modules\Instagram\Engine;

use Backend\Core\Engine\Model as BackendModel;

/**
 * In this file we store all generic functions that we will be using in the instagram module.
 * Created with help from https://github.com/cosenary/Instagram-PHP-API
 */
class Helper
{
    /**
     * The API base URL.
     */
    const API_URL = 'https://api.instagram.com/v1/';

    /**
     * The API OAuth URL.
     */
    const API_OAUTH_URL = 'https://api.instagram.com/oauth/authorize';

    /**
     * The OAuth token URL.
     */
    const API_OAUTH_TOKEN_URL = 'https://api.instagram.com/oauth/access_token';


    /**
     * Get the OAuth data of a user by the returned callback code.
     *
     * @param string $clientId
     * @param string $clientSecret
     * @param string $code OAuth2 code variable (after a successful login)
     * @param string $callbackUrl
     * @param bool $token If it's true, only the access token will be returned
     *
     * @return mixed
     * @throws \Exception
     */
    public static function getOAuthToken($clientId, $clientSecret, $code, $callbackUrl, $token = false)
    {
        $apiData = array(
            'grant_type' => 'authorization_code',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri' => $callbackUrl,
            'code' => $code
        );

        $result = self::makeOAuthCall($apiData);

        return !$token ? $result : $result->access_token;
    }

    /**
     * Search for a user.
     *
     * @param string $name Instagram username
     * @param int $limit Limit of returned results
     *
     * @return mixed
     * @throws \Exception
     */
    public static function searchUser($name, $limit = 0)
    {
        $params = array();
        $params['q'] = $name;
        if ($limit > 0) {
            $params['count'] = $limit;
        }
        return self::makeApiCall('users/search', true, $params);
    }

    /**
     * The OAuth call operator.
     *
     * @param array $apiData The post API data
     *
     * @return mixed
     * @throws \Exception
     */
    private static function makeOAuthCall($apiData)
    {
        $apiHost = self::API_OAUTH_TOKEN_URL;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiHost);
        curl_setopt($ch, CURLOPT_POST, count($apiData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($apiData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);
        $jsonData = curl_exec($ch);
        if (!$jsonData) {
            throw new \Exception('Error: _makeOAuthCall() - cURL error: ' . curl_error($ch));
        }
        curl_close($ch);
        return json_decode($jsonData);
    }

    /**
     * Generates the OAuth login URL.
     *
     * @param string $clientId
     * @param string $callbackUrl
     * @return string Instagram OAuth login URL
     * @throws \Exception
     */
    public static function getLoginUrl($clientId, $callbackUrl): string
    {
        // We can add "&scope=basic+public_content" or other permissions.
        return self::API_OAUTH_URL . '?client_id=' . $clientId . '&redirect_uri=' . urlencode($callbackUrl) . '&response_type=code';
    }

    /**
     * The call operator.
     *
     * @param string $function API resource path
     * @param bool $auth Whether the function requires an access token
     * @param array $params Additional request parameters
     * @param string $method Request type GET|POST
     * @return mixed
     * @throws \Exception
     */
    protected static function makeApiCall($function, $auth = false, $params = null, $method = 'GET')
    {
        if (!$auth) {
            // If the call doesn't requires authentication
            $authMethod = '?client_id=' . self::getApiKey();
        } else {
            $authMethod = '?access_token=' . self::getAccessToken();
        }
        $paramString = null;
        if (isset($params) && is_array($params)) {
            $paramString = '&' . http_build_query($params);
        }
        $apiCall = self::API_URL . $function . $authMethod . (('GET' === $method) ? $paramString : null);

        // Signed header of POST/DELETE requests
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

        // Split header from JSON data and assign each to a variable
        list($headerContent, $jsonData) = explode("\r\n\r\n", $jsonData, 2);

        // Convert header content into an array
        $headers = self::processHeaders($headerContent);

        // Get the 'X-Ratelimit-Remaining' header value
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
        return BackendModel::get('fork.settings')->get('Instagram', 'client_id');
    }

    /**
     * Get the access token from the settings
     *
     * @return string Access token
     */
    private static function getAccessToken(): string
    {
        return BackendModel::get('fork.settings')->get('Instagram', 'access_token');
    }
}
