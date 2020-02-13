<?php

declare(strict_types=1);

namespace Ahc\StrapiClientBundle\Factory;

use Ahc\StrapiClientBundle\Entity\ResourceContentType;
use Ahc\StrapiClientBundle\Resolver\ComponentResolver;

class ResourceContentTypeFactory implements StaticFactoryInterface
{
    /**
     * @param mixed[] $fields
     */
    public static function create(array $fields): ResourceContentType
    {
        $componentProperties = ContentPropertiesFactory::create($fields['contentProperties']);

        return new ResourceContentType(
            SystemFieldsFactory::create($fields['systemFields']),
            $componentProperties,
            (new ComponentResolver($fields['fields'], $componentProperties))->resolve()
        );
    }
}
