<?php

declare(strict_types=1);

namespace Ahc\StrapiClientBundle\Entity;

use Ahc\StrapiClientBundle\Resource\ComponentInterface;
use Ahc\StrapiClientBundle\Resource\ContentProperties;
use Ahc\StrapiClientBundle\Resource\ContentTypeInterface;
use Ahc\StrapiClientBundle\Resource\SystemFields;

class ResourceContentType implements ContentTypeInterface
{
    private SystemFields $systemFields;

    private ContentProperties $contentProperties;

    /** @var ComponentInterface[] */
    private array $fields;

    /**
     * ResourceContentType constructor.
     *
     * @param mixed[] $fields
     */
    public function __construct(
        SystemFields $systemFields,
        ContentProperties $contentProperties,
        array $fields
    ) {
        $this->systemFields = $systemFields;
        $this->contentProperties = $contentProperties;
        $this->fields = $fields;
    }

    public function getSystemFields(): SystemFields
    {
        return $this->systemFields;
    }

    public function getContentProperties(): ContentProperties
    {
        return $this->contentProperties;
    }

    /**
     * @return ComponentInterface[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    public function getField(string $field)
    {
        return $this->fields[$field];
    }
}
