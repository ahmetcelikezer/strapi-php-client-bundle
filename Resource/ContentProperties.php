<?php

declare(strict_types=1);

namespace Ahc\StrapiClientBundle\Resource;

class ContentProperties
{
    private string $uid;

    private string $name;

    private string $label;

    private bool $isDisplayed;

    private Schema $schema;

    public function __construct(
        string $uid,
        string $name,
        string $label,
        bool $isDisplayed,
        Schema $schema
    ) {
        $this->uid = $uid;
        $this->name = $name;
        $this->label = $label;
        $this->isDisplayed = $isDisplayed;
        $this->schema = $schema;
    }

    public function getUid(): string
    {
        return $this->uid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getIsDisplayed(): bool
    {
        return $this->isDisplayed;
    }

    public function getSchema(): Schema
    {
        return $this->schema;
    }

    public function getFieldType(string $field): string
    {
        return $this->schema->getAttribute($field)['type'];
    }
}
