<?php

namespace MadBoy\BigCommerceAPI;

use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

abstract class BigCommerceAPI
{
    protected ?string $endPoint;

    public BigCommerceClient $bigCommerceClient;

    private ?string $base_url;

    private ?string $api_version;

    public function __construct()
    {
        $this->bigCommerceClient = App::make('bigcommerce-client');
    }

    private function getBaseUrl()
    {
        if ($this->base_url)
            return $this->base_url;
        return $this->base_url = Config::get('bigcommerce-api-laravel.base_url');
    }

    /**
     * @throws Exception
     */
    public function client(): PendingRequest
    {
        return $this->bigCommerceClient->client();
    }

    public function generateUrl($end_point, $id = null): string
    {
        return $this->getBaseUrl() . $this->bigCommerceClient->getStoreHash() . '/' . $this->getApiVersion() . '/' . $end_point . ($id ? ('/' . $id) : '');
    }

    public function query(string $endPoint = null): self
    {
        if ($endPoint)
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

    public function paginate(int $page = 1, int $per_page = 15, array $query_data = [])
    {
        $response = $this->client()->get($this->generateUrl($this->endPoint), array_merge($query_data, ['page' => $page, 'limit' => $per_page]));
        if ($response->status() == 200)
            return json_decode($response->body(), true);

        return false;
    }

    public function get(int $id, $query_data = null)
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

    public function update(int $id, $form_data = [])
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

    public function delete(int $id)
    {
        $response = $this->client()->delete($this->generateUrl($this->endPoint, $id));
        if ($response->status() == 200)
            return json_decode($response->body(), true);

        return false;
    }

    public function deleteMultiple(array $ids = [])
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

    /**
     * @return string|null
     */
    public function getApiVersion(): ?string
    {
        return $this->api_version;
    }

    /**
     * @param string|null $api_version
     */
    public function setApiVersion(?string $api_version): void
    {
        $this->api_version = $api_version;
    }
}
