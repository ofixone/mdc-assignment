<?php

namespace App\Providers;

use App\Model\Contract\Validation\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Validator::class, function () {
            return new \App\Model\Validation\Validator();
        });
    }
}
