<?php

namespace LolApplication\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use LolApplication\Library\RiotGames\ResourceObjects\BaseObject;
use LolApplication\Services\RiotGames\Exceptions\MappingException;

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

        // Find or create resource
        $identifier = array_search('id', $class::getResourceMap());
        if (property_exists($resource, $identifier)) {
            $obj = $class::findOrNew($resource->{$identifier});
        } else {
            $obj = new $class();
        }

        foreach ($class::getResourceMap() as $externalProp => $internalProp) {
            // Data types handler
            if (is_array($internalProp)) {
                $type = $internalProp['type'];
                switch ($type) {
                    case 'date':
                        $resource->$externalProp = Carbon::createFromTimestampMs($resource->$externalProp);
                        break;
                    default:
                        break;
                }
                $internalProp = $internalProp['key'];
            }

            // Set properties
            $obj->$internalProp = $resource->$externalProp;
        }
        return $obj;
    }
}
