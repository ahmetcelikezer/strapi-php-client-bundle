<?php

declare(strict_types=1);

namespace Ahc\StrapiClientBundle\Resolver;

interface ResolverInterface
{
    /** @return mixed[] */
    public function resolve(): array;
}
