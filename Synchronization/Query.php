<?php

declare(strict_types=1);

namespace Ahc\StrapiClientBundle\Synchronization;

use Ahc\StrapiClientBundle\Exception\MissingCallException;

class Query
{
    public const EQUALS = 'eq';
    public const NOT_EQUALS = 'ne';
    public const LOWER_THAN = 'lt';
    public const GREATER_THAN = 'gt';
    public const LOWER_THAN_OR_EQUALS = 'lte';
    public const GREATER_THAN_OR_EQUALS = 'gte';
    public const INCLUDED_IN_AN_ARRAY_OF_VALUES = 'in';
    public const NOT_INCLUDED_IN_AN_ARRAY_OF_VALUES = 'nin';
    public const CONTAINS = 'contains';
    public const NOT_CONTAINS = 'ncontains';
    public const CONTAINS_CASE_SENSITIVE = 'containss';
    public const CONTAINS_NOT_CASE_SENSITIVE = 'ncontainss';

    public const SORT_ASC = 'asc';
    public const SORT_DESC = 'desc';

    /**
     * @var mixed[]
     */
    private array $conditions = [];

    private ?string $contentType = null;

    /**
     * @var mixed[]
     */
    private array $sortingRules = [];

    private ?int $limit = null;

    private string $uri;

    /**
     * @param string|int $value
     *
     * @return Query
     */
    public function where(string $field, $value, string $logic = self::EQUALS): self
    {
        $this->conditions[sprintf('%s_%s', $field, $logic)] = $value;

        return $this;
    }

    public function skip(int $skip): self
    {
        $this->conditions['_start'] = $skip;

        return $this;
    }

    public function contentType(string $contentType): self
    {
        $this->contentType = $contentType;

        return $this;
    }

    public function setLimit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @param string[] $sortingRules
     *
     * @return $this
     */
    public function sortBy(array $sortingRules): self
    {
        foreach ($sortingRules as $key => $rule) {
            $this->sortingRules[] = sprintf('%s:%s', $key, $rule);
        }

        return $this;
    }

    public function addSubType(string $type): self
    {
        $this->contentType .= '/'.$type;

        return $this;
    }

    public function getQueryString(): string
    {
        if (null === $this->contentType) {
            throw new MissingCallException('Target content type must be defined with "contentType()" method call. Current content type is null!');
        }

        return $this->uri = sprintf('%s?%s', $this->contentType, http_build_query($this->createQueryData()));
    }

    public function getContentType(): ?string
    {
        return $this->contentType;
    }

    /**
     * @return string[]|int[]
     */
    private function createQueryData(): array
    {
        $query['_limit'] = $this->limit;

        $query['_sort'] = $this->stringfySortingData($this->sortingRules);

        return array_merge($query, $this->conditions);
    }

    /**
     * @param string[] $sorting
     */
    private function stringfySortingData(array $sorting): ?string
    {
        $sortingString = null;

        foreach ($sorting as $item) {
            end($sorting) !== $item ? $sortingString .= $item.',' : $sortingString .= $item;
        }

        return $sortingString;
    }
}
