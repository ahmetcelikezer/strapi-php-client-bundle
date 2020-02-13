<?php

declare(strict_types=1);

namespace Ahc\StrapiClientBundle\Resource\Traits;

trait SluggableTrait
{
    private string $slug;

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }
}
