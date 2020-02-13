<?php

declare(strict_types=1);

namespace Ahc\StrapiClientBundle\Resource;

class Schema
{
    private string $modelType;

    private string $connection;

    private string $collectionName;

    /** @var mixed[] */
    private array $info;

    /** @var mixed[] */
    private array $options;

    /** @var mixed[] */
    private array $attributes;

    /**
     * Schema constructor.
     *
     * @param mixed[] $info
     * @param mixed[] $options
     * @param mixed[] $attributes
     */
    public function __construct(
        string $modelType,
        string $connection,
        string $collectionName,
        array $info,
        array $options,
        array $attributes
    ) {
        $this->modelType = $modelType;
        $this->connection = $connection;
        $this->collectionName = $collectionName;
        $this->info = $info;
        $this->options = $options;
        $this->attributes = $attributes;
    }

    public function getModelType(): string
    {
        return $this->modelType;
    }

    public function getConnection(): string
    {
        return $this->connection;
    }

    public function getCollectionName(): string
    {
        return $this->collectionName;
    }

    /** @return mixed[] */
    public function getInfo(): array
    {
        return $this->info;
    }

    /** @return mixed[] */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @return mixed[]
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /** @return mixed[] */
    public function getAttribute(string $field): array
    {
        return $this->attributes[$field];
    }
}
