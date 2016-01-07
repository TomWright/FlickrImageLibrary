<?php

namespace TomWright\Curl;

class CurlRequest
{

    /**
     * @var string|null
     */
    protected $httpRequestType;

    /**
     * @var string|null
     */
    protected $url;

    /**
     * @var DataCollection
     */
    protected $dataCollection;

    public function __construct()
    {
        $this->dataCollection = new DataCollection();
    }


    /**
     * Clears out all of the stored parameters.
     */
    public function clearParams()
    {
        $this->dataCollection->clear();
    }


    /**
     * Add a new parameter to be used in the CURL request.
     * @param string $key
     * @param string|mixed $val
     */
    public function addParam($key, $val)
    {
        $param = new Parameter($key, $val);
        $this->dataCollection->add($param);
    }


    /**
     * Add an array of new parameters.
     * Must be in format (key => val)
     * @param array|Parameter[] $params
     */
    public function addParams(array $params)
    {
        foreach ($params as $key => $val) {
            $this->addParam($key, $val);
        }
    }


    /**
     * @return array|Parameter[]
     */
    public function getParams()
    {
        return $this->dataCollection->getAll();
    }


    /**
     * @return null|string
     */
    public function getHttpRequestType()
    {
        return $this->httpRequestType;
    }


    /**
     * @param null|string $httpRequestType
     */
    public function setHttpRequestType($httpRequestType)
    {
        $this->httpRequestType = strtoupper($httpRequestType);
    }


    /**
     * @return null|string
     */
    public function getUrl()
    {
        return $this->url;
    }


    /**
     * @param null|string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }


    /**
     * Execute a CURL request.
     * @param bool $returnResponse
     * @param bool $clearParams
     * @return mixed
     */
    public function execute($returnResponse = true, $clearParams = true)
    {
        $ch = curl_init();

        $params = $this->getPreparedParams();
        $url = $this->getUrl();

        $options = array(
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => $this->getHttpRequestType(),
            CURLOPT_RETURNTRANSFER => $returnResponse,
        );

        if ($options[CURLOPT_CUSTOMREQUEST] == 'GET') {
            $startChar = (parse_url($url, PHP_URL_QUERY)) ? '&' : '?';
            $url .= $this->buildQueryStringFromParams($params, $startChar);
        } else {
            $options[CURLOPT_POSTFIELDS] = $params;
        }

        $options[CURLOPT_URL] = $url;

        curl_setopt_array($ch, $options);

        $result = curl_exec($ch);

        if ($clearParams) {
            $this->clearParams();
        }

        return $result;
    }


    /**
     * Builds the query string for a GET request.
     * @param array $params These should already be urlencoded.
     * @param string $startCharacter
     * @return string
     */
    protected function buildQueryStringFromParams(array $params, $startCharacter = '?')
    {
        $result = $startCharacter;

        foreach ($params as $name => $value) {
            $result .= "{$name}=$value&";
        }

        $result = rtrim($result, '?&');

        return $result;
    }


    /**
     * Returns the url encoded parameters in an array.
     * @return array
     */
    protected function getPreparedParams()
    {
        $params = $this->getParams();
        $result = array();

        foreach ($params as $param) {
            $name = urlencode($param->getName());
            $value = urlencode($param->getValue());
            $result[$name] = $value;
        }

        return $result;
    }

}