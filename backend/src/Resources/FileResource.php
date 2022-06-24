<?php

namespace It20Academy\App\Resources;

use It20Academy\App\Core\Resource;

class FileResource extends Resource
{
    public static function toArray ($resource) :array
    {
        return [
            'name' => $resource->name ?? null,
            'id' => $resource->id ?? null,
            'url' => "http://localhost{$resource->url}" ?? null,
            'car_id' => $resource->car_id ?? null,
            'category' => $resource->category ?? null,
            'made_car' => $resource->made_car ?? null,
            'created_at' => $resource->created_at ?? null,
            'updated_at' => $resource->updated_at ?? null,
        ];
    }
}