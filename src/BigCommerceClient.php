<?php

namespace MadBoy\BigCommerceAPI;

use Closure;
use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class BigCommerceClient
{
    private Closure $getStoreHash;

    private Closure $getAccessToken;

    private ?string $store_hash;

    private ?string $access_token;

    private string $environment;

    public function __construct()
    {
        $this->environment = Config::get('app.env');;
    }

    /**
     * @return string|null
     */
    public function getStoreHash(): ?string
    {
        if (!isset($this->store_hash))
            $this->store_hash = ($this->getStoreHash)();
        return $this->store_hash;
    }

    /**
     * @return string|null
     */
    public function getAccessToken(): ?string
    {
        if (!isset($this->access_token))
            $this->access_token = ($this->getAccessToken)();
        return $this->access_token;
    }

    /**
     * @param Closure $getStoreHash
     */
    public function setGetStoreHash(Closure $getStoreHash): void
    {
        $this->getStoreHash = $getStoreHash;
    }

    /**
     * @param Closure $getAccessToken
     */
    public function setGetAccessToken(Closure $getAccessToken): void
    {
        $this->getAccessToken = $getAccessToken;
    }

    /**
     * @throws Exception
     */
    public function client(): PendingRequest
    {
        if (!$this->getStoreHash())
            throw new Exception('Store hash is not set. Please set store hash.');

        if (!$this->getAccessToken())
            throw new Exception('Store Access Token is not set. Please set store access token.');

        if ($this->environment === 'local')
            return Http::withoutVerifying()->withHeaders([
                'x-auth-token' => $this->getAccessToken(),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]);

        return Http::withHeaders([
            'x-auth-token' => $this->getAccessToken(),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ]);
    }
}