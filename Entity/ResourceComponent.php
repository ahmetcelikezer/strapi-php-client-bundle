<?php

declare(strict_types=1);

namespace Ahc\StrapiClientBundle\Entity;

use Ahc\StrapiClientBundle\Resource\ComponentInterface;

class ResourceComponent implements ComponentInterface
{
    private string $componentType;

    private string $id;

    /** @var mixed[] */
    private array $fields;

    /**
     * ResourceComponent constructor.
     *
     * @param mixed[] $fields
     */
    public function __construct(
        string $componentType,
        string $id,
        array $fields
    ) {
        $this->componentType = $componentType;
        $this->id = $id;
        $this->fields = $fields;
    }

    public function getComponentType(): string
    {
        return $this->componentType;
    }

    public function getID(): string
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $field)
    {
        return $this->fields[$field];
    }
}
