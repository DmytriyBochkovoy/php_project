<?php

namespace It20Academy\App\Resources;

use It20Academy\App\Core\Resource;

class CarResource extends Resource
{
    public static function toArray ($resource) :array
    {
        return [
            'name' => $resource->name ?? null,
            'id' => $resource->id ?? null,
            'capacity' => $resource->capacity ?? null,
            'consumption' => $resource->consumption ?? null,
            'power' => $resource->power ?? null,
            'price' => $resource->price ?? null,
            'made_car' => $resource->made_car ?? null,
            'created_at' => $resource->created_at ?? null,
            'updated_at' => $resource->updated_at ?? null,
            'relations' => [
                'slides' => FileResource::collection($resource->relations['slides']),
                'avatar' => isset($resource->relations['avatar']) ? FileResource::toArray($resource->relations['avatar']) : null,
                'body_type' => $resource->relations['body_type'],
                'shift_box' => $resource->relations['shift_box'],
                'fuilType' => $resource->relations['fuilType'],
            ],
        ];
    }
}