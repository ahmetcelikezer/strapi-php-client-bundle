<?php

declare(strict_types=1);

namespace Ahc\StrapiClientBundle\Factory;

use Ahc\StrapiClientBundle\Resource\Schema;

class SchemaFactory implements StaticFactoryInterface
{
    /**
     * @param mixed[] $fields
     */
    public static function create(array $fields): Schema
    {
        return new Schema(
            (string) $fields['modelType'],
            (string) $fields['connection'],
            (string) $fields['collectionName'],
            (array) $fields['info'],
            (array) $fields['options'],
            (array) $fields['attributes']
        );
    }
}
