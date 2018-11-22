<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use LolApplication\Services\RiotGames\RiotGamesService;

class SummonerResourceTest extends TestCase
{
    public $serviceProvider;

    protected function setUp()
    {
        $this->serviceProvider = new RiotGamesService(env('RIOT_GAMES_API_KEY', ''));
        parent::setUp();
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
}
