<?php

namespace MadBoy\BigCommerceAPI;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

abstract class BigCommerceClient
{
    abstract public function getStoreHash();

    abstract public function getAccessToken();

    public function client(): PendingRequest
    {
        return Http::withHeaders([
            'x-auth-token' => $this->getAccessToken(),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ]);
    }
}