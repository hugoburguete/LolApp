<?php

namespace LolApplication\Providers;

use Illuminate\Support\ServiceProvider;

use LolApplication\Services\RiotGames\RiotGamesService;
use LolApplication\Services\RiotGames\RiotGamesInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(RiotGamesInterface::class, function($app) {
            $riotGamesService = new RiotGamesService(config('services.riotgames.apiKey'));

            // Additional Setup (if needed)

            return $riotGamesService;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
