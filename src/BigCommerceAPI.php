<?php

namespace MadBoy\BigCommerceAPI;

use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Config;
use MadBoy\BigCommerceAPI\Facades\BigClient;

abstract class BigCommerceAPI
{
    protected ?string $endPoint = null;

    private ?string $baseURL = null;

    private ?string $apiVersion = null;

    private bool $validatedResponse = true;

    private function getBaseUrl()
    {
        if ($this->baseURL)
            return $this->baseURL;
        return $this->baseURL = Config::get('bigcommerce-api-laravel.base_url');
    }

    /**
     * @throws Exception
     */
    public function client(): PendingRequest
    {
        return BigClient::client();
    }

    private function getStoreHash(): string
    {
        return BigClient::getStoreHash();
    }

    public function generateUrl($end_point, $id = null): string
    {
        return $this->getBaseUrl() . $this->getStoreHash() . '/' . $this->getApiVersion() . '/' . $end_point . ($id ? ('/' . $id) : '');
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

        if (!$this->validatedResponse)
            return $response;

        if ($response->status() == 200)
            return json_decode($response->body(), true);

        return false;
    }

    public function paginate(int $page = 1, int $per_page = 15, array $query_data = [])
    {
        $response = $this->client()->get($this->generateUrl($this->endPoint), array_merge($query_data, ['page' => $page, 'limit' => $per_page]));

        if (!$this->validatedResponse)
            return $response;

        if ($response->status() == 200)
            return json_decode($response->body(), true);

        return false;
    }

    public function get(int|string $id, $query_data = null)
    {
        $response = $this->client()->get($this->generateUrl($this->endPoint, $id), $query_data);

        if (!$this->validatedResponse)
            return $response;

        if ($response->status() == 200)
            return json_decode($response->body(), true);

        return false;
    }

    public function create($form_data = [])
    {
        $response = $this->client()->post($this->generateUrl($this->endPoint), $form_data);

        if (!$this->validatedResponse)
            return $response;

        if ($response->status() == 200)
            return json_decode($response->body(), true);

        return false;
    }

    public function update(int|string $id, $form_data = [])
    {
        $response = $this->client()->put($this->generateUrl($this->endPoint, $id), $form_data);

        if (!$this->validatedResponse)
            return $response;

        if ($response->status() == 200)
            return json_decode($response->body(), true);

        return false;
    }

    public function updateMultiple($form_data = [])
    {
        $response = $this->client()->put($this->generateUrl($this->endPoint), $form_data);

        if (!$this->validatedResponse)
            return $response;

        if ($response->status() == 200)
            return json_decode($response->body(), true);

        return false;
    }

    public function delete(int|string $id)
    {
        $response = $this->client()->delete($this->generateUrl($this->endPoint, $id));

        if (!$this->validatedResponse)
            return $response;

        if ($response->status() == 200)
            return json_decode($response->body(), true);

        if ($response->status() == 204)
            return true;

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

        if (!$this->validatedResponse)
            return $response;

        if ($response->status() == 200)
            return json_decode($response->body(), true);

        return false;
    }

    /**
     * @return string
     */
    public function getApiVersion(): string
    {
        return $this->apiVersion;
    }

    /**
     * @param string $apiVersion
     * @return BigCommerceAPI
     */
    public function setApiVersion(string $apiVersion): self
    {
        $this->apiVersion = $apiVersion;
        return $this;
    }

    /**
     * @return BigCommerceAPI
     */
    public function withoutValidation(): self
    {
        $this->validatedResponse = false;
        return $this;
    }
}
