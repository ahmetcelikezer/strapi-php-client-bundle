<?php

declare(strict_types=1);

namespace Ahc\StrapiClientBundle\Factory;

use Ahc\StrapiClientBundle\Resource\ContentProperties;

class ContentPropertiesFactory implements StaticFactoryInterface
{
    /**
     * @param mixed[] $fields
     */
    public static function create(array $fields): ContentProperties
    {
        return new ContentProperties(
            (string) $fields['uid'],
            (string) $fields['name'],
            (string) $fields['label'],
            (bool) $fields['isDisplayed'],
            SchemaFactory::create($fields['schema'])
        );
    }
}
