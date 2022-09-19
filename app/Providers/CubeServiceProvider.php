<?php

namespace App\Providers;

use App\Enums\Faces;
use App\Enums\Directions;
use App\Processors\CubeProcessor;
use App\Processors\CubeProcessorInterface;
use App\Repository\CubeRepository;
use App\Repository\CubeRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class CubeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CubeProcessorInterface::class, CubeProcessor::class);
        $this->app->bind(CubeRepositoryInterface::class, CubeRepository::class);

        $this->app->bind(Faces::class, function () {
            return new Faces(request('face'));
        });
        $this->app->bind(Directions::class, function () {
            return new Directions(request('direction'));
        });
    }
}
