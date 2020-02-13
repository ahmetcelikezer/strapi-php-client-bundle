<?php

declare(strict_types=1);

namespace Ahc\StrapiClientBundle\Resource;

interface SluggableInterface
{
    public function getSlug(): string;
}
