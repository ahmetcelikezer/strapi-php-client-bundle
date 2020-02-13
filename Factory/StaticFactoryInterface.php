<?php

declare(strict_types=1);

namespace Ahc\StrapiClientBundle\Factory;

interface StaticFactoryInterface
{
    /**
     * @param mixed[] $fields
     *
     * @return mixed
     */
    public static function create(array $fields);
}
