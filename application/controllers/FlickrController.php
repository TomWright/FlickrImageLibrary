<?php

use TomWright\ApiController;
use Whirlpool\Config;
use TomWright\Flickr\Api;

class FlickrController extends ApiController
{

    protected $flickrSecret;
    protected $flickrApiKey;

    /**
     * @var Api
     */
    protected $flickrApi;

    public function __construct()
    {
        parent::__construct();

        $this->flickrApiKey = Config::get('keys.flickrKey');
        $this->flickrSecret = Config::get('keys.flickrSecret');

        $this->flickrApi = new Api($this->flickrApiKey, $this->flickrSecret);
    }


    /**
     * Public facing API call to return the details of images pulled via the flickr API.
     * @param int $page
     * @param int $perPage
     */
    public function fetchRecentImagesAction($page = 1, $perPage = 10)
    {
        $response = $this->flickrApi->getRecentPhotos($page, $perPage, array('owner_name', 'date_upload', 'description'));

        $this->respond($response);
    }

}