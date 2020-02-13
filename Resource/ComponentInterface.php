<?php

declare(strict_types=1);

namespace Ahc\StrapiClientBundle\Resource;

interface ComponentInterface
{
    public function getComponentType(): string;

    public function getID(): string;

    /** @return mixed */
    public function get(string $field);
}
