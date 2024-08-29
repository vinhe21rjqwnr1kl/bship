<?php

namespace App\Services\common;

use Illuminate\Support\Facades\Http;

class ReloadConfigService
{
    private string $url_reload_config;
    public function __construct()
    {
        $this->url_reload_config = config('api.url_reload_config');
    }

    public function reload_config()
    {
        return Http::get($this->url_reload_config)->json();
    }
}