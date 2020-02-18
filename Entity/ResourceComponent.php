<?php

declare(strict_types=1);

namespace Ahc\StrapiClientBundle\Entity;

use Ahc\StrapiClientBundle\Resource\ComponentInterface;

class ResourceComponent implements ComponentInterface
{
    private string $componentType;

    private int $id;

    /** @var mixed[] */
    private array $fields;

    /**
     * ResourceComponent constructor.
     *
     * @param mixed[] $fields
     */
    public function __construct(
        string $componentType,
        int $id,
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

    public function getID(): int
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
