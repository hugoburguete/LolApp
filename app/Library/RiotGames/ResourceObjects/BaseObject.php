<?php
namespace LolApplication\Library\RiotGames\ResourceObjects;

class BaseObject
{
    public static function fromJson(string $json)
    {
        $instance = new static();
        $properties = json_decode($json);
        foreach ($properties as $propKey => $propValue) {
            if (property_exists(static::class, $propKey)) {
                $instance->$propKey = $propValue;
            }
        }
        return $instance;
    }
}
