<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use LolApplication\Services\RiotGames\RiotGamesService;

class SummonerResourceTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    public $serviceProvider;

    protected function setUp()
    {
        parent::setUp();
        $this->serviceProvider = resolve(RiotGamesService::class);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetSummoner()
    {
        $summoner = $this->serviceProvider->getSummoner('purefoton');

        $this->assertTrue(!empty($summoner));
    }

    public function testSummonerHasLeague()
    {
        $summoner = $this->serviceProvider->getSummoner('purefoton');
        $this->assertTrue(!$summoner->leagues->isEmpty());
    }
}
