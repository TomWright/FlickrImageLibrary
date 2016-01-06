<?php

use TomWright\ApiController;
use Whirlpool\Config;

class FlickrController extends ApiController
{

    protected $flickrSecret;
    protected $flickrApiKey;

    public function __construct()
    {
        parent::__construct();

        $this->flickrApiKey = Config::get('keys.flickrKey');
        $this->flickrSecret = Config::get('keys.flickrSecret');
    }


    /**
     * Public facing API call to return the details of images pulled via the flickr API.
     * @param int $limit
     * @param int $offset
     */
    public function fetchImagesAction($limit = 10, $offset = 0)
    {
        $this->respond([
            'message' => 'Made it!',
        ]);
    }

}