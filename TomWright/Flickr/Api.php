<?php

namespace TomWright\Flickr;

use TomWright\Curl\CurlRequest;

class Api
{

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $apiSecret;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string
     */
    protected $format;


    /**
     * Api constructor.
     * @param string $apiKey
     * @param string $apiSecret
     */
    public function __construct($apiKey, $apiSecret)
    {
        $this->setApiKey($apiKey);
        $this->setApiSecret($apiSecret);
        $this->setBaseUrl('https://api.flickr.com/services/rest/');
        $this->setFormat('json');
    }


    /**
     * Get recently uploaded photos from flickr.
     * https://www.flickr.com/services/api/flickr.photos.getRecent.html
     * @param int $page
     * @param int $perPage
     * @param array $extraInformation
     * @return mixed
     */
    public function getRecentPhotos($page = 1, $perPage = 10, array $extraInformation = array())
    {
        $data = array(
            'page' => $page,
            'per_page' => $perPage,
            'extras' => implode(',', $extraInformation),
        );
        return $this->execute('flickr.photos.getRecent', $data, 'GET');
    }


    /**
     * @param string $method The flickr API method to call
     * @param array $data The data to pass to the API method.
     * @param string $requestType
     * @param bool $parseResponse
     * @return mixed
     * @throws ApiResponseException
     * @throws \Exception
     */
    public function execute($method, array $data, $requestType = 'GET', $parseResponse = true)
    {
        $data['api_key'] = $this->getApiKey();
        $data['method'] = $method;
        $data['format'] = $this->getFormat();

        switch($data['format']) {
            case 'json':
                $data['nojsoncallback'] = true;
                break;
        }

        $request = new CurlRequest();

        $request->setUrl($this->getBaseUrl());
        $request->setHttpRequestType($requestType);
        $request->addParams($data);

        $response = $request->execute();

        if ($parseResponse) {
            $response = $this->parseResponse($response);
            $responseOk = false;

            if (is_object($response) && isset($response->stat)) {
                $responseOk = ($response->stat == 'ok');
            } elseif (is_array($response) && array_key_exists('stat', $response)) {
                $responseOk = ($response['stat'] == 'ok');
            }

            if (! $responseOk) {
                throw new ApiResponseException("Flickr API Method '{$method}' didn't respond as expected.");
            }
        }

        return $response;
    }


    /**
     * Decode the API response.
     * @param $response
     * @return mixed
     * @throws \Exception
     */
    protected function parseResponse($response)
    {
        $format = $this->getFormat();

        switch ($format) {
            case 'json':
                $response = json_decode($response);
                break;

            default:
                throw new \Exception("Unhandled API response format: {$format}.");
                break;
        }

        return $response;
    }


    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }


    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }


    /**
     * @return string
     */
    public function getApiSecret()
    {
        return $this->apiSecret;
    }


    /**
     * @param string $apiSecret
     */
    public function setApiSecret($apiSecret)
    {
        $this->apiSecret = $apiSecret;
    }


    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }


    /**
     * @param string $baseUrl
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }


    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }


    /**
     * @param string $format
     */
    public function setFormat($format)
    {
        $this->format = strtolower($format);
    }

}