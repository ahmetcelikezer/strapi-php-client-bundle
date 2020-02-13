<?php

declare(strict_types=1);

namespace Ahc\StrapiClientBundle\Resource;

interface ContentTypeInterface
{
    public function getSystemFields(): SystemFields;

    public function getContentProperties(): ContentProperties;

    /** @return ComponentInterface[] */
    public function getFields(): array;

    /** @return ComponentInterface|mixed */
    public function getField(string $field);
}
