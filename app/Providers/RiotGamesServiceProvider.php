<?php

namespace LolApplication\Providers;

use Illuminate\Support\ServiceProvider;

use LolApplication\Services\RiotGames\RiotGamesService;
use LolApplication\Services\RiotGames\RiotGamesInterface;
use LolApplication\Library\RiotGames\Resources\SummonerResource;

class RiotGamesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $repoDir = dirname(__DIR__).'/Library/RiotGames/Resources/';
        $filesArray = dirToArray($repoDir);
        $this->registerRiotGamesLibraryResources($filesArray);

        $this->app->singleton(RiotGamesInterface::class, function($app) {
            $riotGamesService = new RiotGamesService();
            return $riotGamesService;
        });
    }

    /**
     * Registers resources from the riot games library
     *
     * @param array $filesArray
     * @param string $base
     * @return void
     */
    public function registerRiotGamesLibraryResources($filesArray, $base = 'LolApplication\Library\RiotGames\Resources\\')
    {
        foreach ($filesArray as $key => $location) {
            if (is_array($location)) {
                // We're dealing with a directory.
                if (!in_array($key, $this->excludedDirectories)) {
                    $this->loadClasses($location, $base.$key.'\\');
                }
            }
            else {
                $class = str_replace('.php', '', $location);
                $class = $base . $class;
                $this->app->singleton($class, function($app) use ($class) {
                    return new $class(config('services.riotgames.apiKey'));
                });
            }
        }
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
