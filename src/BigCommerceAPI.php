<?php

namespace MadBoy\BigCommerceAPI;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Config;

abstract class BigCommerceAPI
{
    protected $endPoint;

    /**
     * @var BigCommerceClient
     */
    public $bigCommerceClient;

    private $base_url;

    private $api_version;

    public function __construct()
    {
        $class_name = Config::get('bigcommerce-api-laravel.big_client');
        if ($class_name) {
            $this->bigCommerceClient = new $class_name();
        } else {
            $this->bigCommerceClient = new class extends BigCommerceClient {

                public function getStoreHash()
                {
                    return Config::get('bigcommerce-api-laravel.api_config.store_hash');
                }

                public function getAccessToken()
                {
                    return Config::get('bigcommerce-api-laravel.api_config.access_token');
                }
            };
        }
    }

    private function getBaseUrl()
    {
        if ($this->base_url)
            return $this->base_url;
        return $this->base_url = Config::get('bigcommerce-api-laravel.base_url');
    }

    private function getApiVersion()
    {
        if ($this->api_version)
            return $this->api_version;
        return $this->api_version = Config::get('bigcommerce-api-laravel.api_version');
    }

    public function switchApiVersion($version)
    {
        if ($version != 'v2' && $version != 'v3')
            return $this;

        $this->api_version = $version;
        return $this;
    }

    public function client(): PendingRequest
    {
        return $this->bigCommerceClient->client();
    }

    public function generateUrl($end_point, $id = null): string
    {
        return $this->getBaseUrl() . $this->bigCommerceClient->getStoreHash() . '/' . $this->getApiVersion() . '/' . $end_point . ($id ? ('/' . $id) : '');
    }

    public function query($endPoint): self
    {
        $this->endPoint = $endPoint;
        return $this;
    }

    public function all($query_data = null)
    {
        $response = $this->client()->get($this->generateUrl($this->endPoint), $query_data);
        if ($response->status() == 200)
            return json_decode($response->body(), true);

        return false;
    }

    public function paginate($page = 1, $per_page = 15, $query_data = [])
    {
        $response = $this->client()->get($this->generateUrl($this->endPoint), array_merge($query_data, ['page' => $page, 'limit' => $per_page]));
        if ($response->status() == 200)
            return json_decode($response->body(), true);

        return false;
    }

    public function get($id, $query_data = null)
    {
        $response = $this->client()->get($this->generateUrl($this->endPoint, $id), $query_data);
        if ($response->status() == 200)
            return json_decode($response->body(), true);

        return false;
    }

    public function create($form_data = [])
    {
        $response = $this->client()->post($this->generateUrl($this->endPoint), $form_data);
        if ($response->status() == 200)
            return json_decode($response->body(), true);

        return false;
    }

    public function update($id, $form_data = [])
    {
        $response = $this->client()->put($this->generateUrl($this->endPoint, $id), $form_data);
        if ($response->status() == 200)
            return json_decode($response->body(), true);

        return false;
    }

    public function updateMultiple($form_data = [])
    {
        $response = $this->client()->put($this->generateUrl($this->endPoint), $form_data);
        if ($response->status() == 200)
            return json_decode($response->body(), true);

        return false;
    }

    public function delete($id)
    {
        $response = $this->client()->delete($this->generateUrl($this->endPoint, $id));
        if ($response->status() == 200)
            return json_decode($response->body(), true);

        return false;
    }

    public function deleteMultiple($ids = [])
    {
        $ids_string = '?id:in[]=';
        $first = true;
        foreach ($ids as $id) {
            $ids_string .= ($first ? '' : ',') . $id;
            if ($first)
                $first = false;
        }
        $response = $this->client()->delete($this->generateUrl($this->endPoint) . $ids_string);
        if ($response->status() == 200)
            return json_decode($response->body(), true);

        return false;
    }

    public static function makeQuery()
    {
        return (new static);
    }
}
