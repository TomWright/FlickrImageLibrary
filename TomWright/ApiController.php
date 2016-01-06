<?php

namespace TomWright;

use Whirlpool\Config;

abstract class ApiController extends BaseController
{

    protected $apiKey = null;

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Ensures that the current API Key is valid.
     *
     * @return bool
     * @throws \Exception
     */
    protected function checkApiKey()
    {
        $this->loadApiKey();

        $validApiKeys = Config::get('keys.apiKeys');
        if (! is_array($validApiKeys)) {
            throw new \Exception("No API keys could be found.");
        }

        if (! in_array($this->apiKey, $validApiKeys)) {
            $this->respond([
                'error' => 'Invalid API Key.',
            ], 400);
        }

        return true;
    }


    /**
     * Checks the $_REQUEST array for an API Key.
     */
    protected function loadApiKey()
    {
        $this->apiKey = null;
        $keyName = 'api_key';
        if (array_key_exists($keyName, $_REQUEST) && mb_strlen($_REQUEST[$keyName]) > 0) {
            $this->apiKey = $_REQUEST[$keyName];
        } else {
            $this->respond([
                'error' => 'Missing field: api_key.',
            ], 400);
        }
    }


    /**
     * Send an API response. Just an easy way to set a response code and json encode the output.
     *
     * @param array $data
     * @param int $responseCode
     */
    protected function respond(array $data, $responseCode = 200)
    {
        http_response_code($responseCode);
        echo json_encode($data);
        die;
    }

}