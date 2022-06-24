<?php

namespace It20Academy\App\Core;

class Resource
{
    public static function toArray ($resource) :array
    {
        return [];
    }

    public static function collectionToJson ($resources)
    {
        $data = static::collection($resources);

        return json_encode([
            'data' => $data,
        ]);
    }

    public static function collection ($resources) :array
    {
        return array_map(function ($item) {
            return static::toArray($item);
        }, $resources);
    }

    public static function toJson ($resource) {
        return json_encode([
            'data' => static::toArray($resource),
        ]);
    }
}