<?php

namespace LolApplication\Models;

use LolApplication\Library\RiotGames\ResourceObjects\BaseObject;
use LolApplication\Services\RiotGames\Exceptions\MappingException;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    /**
     * Maps the riot API resource into a workable model
     *
     * @param BaseObject $resource
     * @return BaseModel
     */
    public static function fromResourceObject(BaseObject $resource): BaseModel
    {
        $class = get_called_class();
        if (!method_exists($class, 'getResourceMap')) {
            throw new MappingException(
                'No mapping was provided for ' . $class . '. External Resource: ' . get_class($resource)
            );
        }

        $obj = new $class();
        foreach ($class::getResourceMap() as $externalProp => $internalProp) {
            $obj->$internalProp = $resource->$externalProp;
        }
        return $obj;
    }
}
