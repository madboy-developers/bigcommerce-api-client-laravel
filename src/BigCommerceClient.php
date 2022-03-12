<?php

namespace MadBoy\BigCommerceAPI;

use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class BigCommerceClient
{
    private ?string $store_hash;

    private ?string $access_token;

    /**
     * @return string|null
     */
    public function getStoreHash(): ?string
    {
        return $this->store_hash;
    }

    /**
     * @param string|null $store_hash
     */
    public function setStoreHash(?string $store_hash): void
    {
        $this->store_hash = $store_hash;
    }

    /**
     * @return string|null
     */
    public function getAccessToken(): ?string
    {
        return $this->access_token;
    }

    /**
     * @param string|null $access_token
     */
    public function setAccessToken(?string $access_token): void
    {
        $this->access_token = $access_token;
    }

    /**
     * @throws Exception
     */
    public function client(): PendingRequest
    {
        if ($this->getStoreHash())
            throw new Exception('Store hash is not set. Please set store hash.');

        if ($this->getAccessToken())
            throw new Exception('Store Access Token is not set. Please set store access token.');

        return Http::withHeaders([
            'x-auth-token' => $this->getAccessToken(),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ]);
    }
}