<?php

declare(strict_types=1);

namespace Ahc\StrapiClientBundle\Test;

use Ahc\StrapiClientBundle\Exception\MissingCallException;
use Ahc\StrapiClientBundle\Synchronization\Query;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Ahc\StrapiClientBundle\Synchronization\Query
 *
 * @internal
 */
final class QueryTest extends TestCase
{
    private Query $baseQuery;

    /*
     * Test if content type does not defined.
     */
    public function testContentTypeDoesNotSet(): void
    {
        $query = new Query();

        $this->expectException(MissingCallException::class);
        $query->getQueryString();
    }

    /*
     * Test all where options their single and multiple cases.
     */
    public function testSingleWhereDefaultLogic(): void
    {
        $query = $this->getQueryMethod();
        $query->where('test_field', 'test_value');

        static::assertSame($query->getQueryString(), 'test_content_types?test_field_eq=test_value');
    }

    public function testMultipleWhereDefaultLogic(): void
    {
        $query = $this->getQueryMethod();
        $query->where('test_field', 'test_value');
        $query->where('test_field2', 'test_value2');

        static::assertSame($query->getQueryString(), 'test_content_types?test_field_eq=test_value&test_field2_eq=test_value2');
    }

    public function testSingleWhereNotEqualsLogic(): void
    {
        $query = $this->getQueryMethod();
        $query->where('test_field', 'test_value', Query::NOT_EQUALS);

        static::assertSame($query->getQueryString(), 'test_content_types?test_field_ne=test_value');
    }

    public function testMultipleWhereNotEqualsLogic(): void
    {
        $query = $this->getQueryMethod();
        $query->where('test_field', 'test_value', Query::NOT_EQUALS);
        $query->where('test_field2', 'test_value2', Query::NOT_EQUALS);

        static::assertSame($query->getQueryString(), 'test_content_types?test_field_ne=test_value&test_field2_ne=test_value2');
    }

    public function testSingleWhereLowerThanLogic(): void
    {
        $query = $this->getQueryMethod();
        $query->where('test_field', 'test_value', Query::LOWER_THAN);

        static::assertSame($query->getQueryString(), 'test_content_types?test_field_lt=test_value');
    }

    public function testMultipleWhereLowerThanLogic(): void
    {
        $query = $this->getQueryMethod();
        $query->where('test_field', 'test_value', Query::LOWER_THAN);
        $query->where('test_field2', 'test_value2', Query::LOWER_THAN);

        static::assertSame($query->getQueryString(), 'test_content_types?test_field_lt=test_value&test_field2_lt=test_value2');
    }

    public function testSingleWhereGreaterThanLogic(): void
    {
        $query = $this->getQueryMethod();
        $query->where('test_field', 'test_value', Query::GREATER_THAN);

        static::assertSame($query->getQueryString(), 'test_content_types?test_field_gt=test_value');
    }

    public function testMultipleWhereGreaterThanLogic(): void
    {
        $query = $this->getQueryMethod();
        $query->where('test_field', 'test_value', Query::GREATER_THAN);
        $query->where('test_field2', 'test_value2', Query::GREATER_THAN);

        static::assertSame($query->getQueryString(), 'test_content_types?test_field_gt=test_value&test_field2_gt=test_value2');
    }

    public function testSingleWhereLowerThanOrEqualsLogic(): void
    {
        $query = $this->getQueryMethod();
        $query->where('test_field', 'test_value', Query::LOWER_THAN_OR_EQUALS);

        static::assertSame($query->getQueryString(), 'test_content_types?test_field_lte=test_value');
    }

    public function testMultipleWhereLowerThanOrEqualsLogic(): void
    {
        $query = $this->getQueryMethod();
        $query->where('test_field', 'test_value', Query::LOWER_THAN_OR_EQUALS);
        $query->where('test_field2', 'test_value2', Query::LOWER_THAN_OR_EQUALS);

        static::assertSame($query->getQueryString(), 'test_content_types?test_field_lte=test_value&test_field2_lte=test_value2');
    }

    public function testSingleWhereGreaterThanOrEqualsLogic(): void
    {
        $query = $this->getQueryMethod();
        $query->where('test_field', 'test_value', Query::GREATER_THAN_OR_EQUALS);

        static::assertSame($query->getQueryString(), 'test_content_types?test_field_gte=test_value');
    }

    public function testMultipleWhereGreaterThanOrEqualsLogic(): void
    {
        $query = $this->getQueryMethod();
        $query->where('test_field', 'test_value', Query::GREATER_THAN_OR_EQUALS);
        $query->where('test_field2', 'test_value2', Query::GREATER_THAN_OR_EQUALS);

        static::assertSame($query->getQueryString(), 'test_content_types?test_field_gte=test_value&test_field2_gte=test_value2');
    }

    public function testSingleWhereIncludedInArrayOrValuesLogic(): void
    {
        $query = $this->getQueryMethod();
        $query->where('test_field', 'test_value', Query::INCLUDED_IN_AN_ARRAY_OF_VALUES);

        static::assertSame($query->getQueryString(), 'test_content_types?test_field_in=test_value');
    }

    public function testMultipleWhereIncludedInArrayOrValuesLogic(): void
    {
        $query = $this->getQueryMethod();
        $query->where('test_field', 'test_value', Query::INCLUDED_IN_AN_ARRAY_OF_VALUES);
        $query->where('test_field2', 'test_value2', Query::INCLUDED_IN_AN_ARRAY_OF_VALUES);

        static::assertSame($query->getQueryString(), 'test_content_types?test_field_in=test_value&test_field2_in=test_value2');
    }

    public function testSingleWhereNotIncludedInArrayOrValuesLogic(): void
    {
        $query = $this->getQueryMethod();
        $query->where('test_field', 'test_value', Query::NOT_INCLUDED_IN_AN_ARRAY_OF_VALUES);

        static::assertSame($query->getQueryString(), 'test_content_types?test_field_nin=test_value');
    }

    public function testMultipleWhereNotIncludedInArrayOrValuesLogic(): void
    {
        $query = $this->getQueryMethod();
        $query->where('test_field', 'test_value', Query::NOT_INCLUDED_IN_AN_ARRAY_OF_VALUES);
        $query->where('test_field2', 'test_value2', Query::NOT_INCLUDED_IN_AN_ARRAY_OF_VALUES);

        static::assertSame($query->getQueryString(), 'test_content_types?test_field_nin=test_value&test_field2_nin=test_value2');
    }

    public function testSingleWhereContainsLogic(): void
    {
        $query = $this->getQueryMethod();
        $query->where('test_field', 'test_value', Query::CONTAINS);

        static::assertSame($query->getQueryString(), 'test_content_types?test_field_contains=test_value');
    }

    public function testMultipleWhereContainsLogic(): void
    {
        $query = $this->getQueryMethod();
        $query->where('test_field', 'test_value', Query::CONTAINS);
        $query->where('test_field2', 'test_value2', Query::CONTAINS);

        static::assertSame($query->getQueryString(), 'test_content_types?test_field_contains=test_value&test_field2_contains=test_value2');
    }

    public function testSingleWhereNotContainsLogic(): void
    {
        $query = $this->getQueryMethod();
        $query->where('test_field', 'test_value', Query::NOT_CONTAINS);

        static::assertSame($query->getQueryString(), 'test_content_types?test_field_ncontains=test_value');
    }

    public function testMultipleWhereNotContainsLogic(): void
    {
        $query = $this->getQueryMethod();
        $query->where('test_field', 'test_value', Query::NOT_CONTAINS);
        $query->where('test_field2', 'test_value2', Query::NOT_CONTAINS);

        static::assertSame($query->getQueryString(), 'test_content_types?test_field_ncontains=test_value&test_field2_ncontains=test_value2');
    }

    public function testSingleWhereContainsCaseSensitiveLogic(): void
    {
        $query = $this->getQueryMethod();
        $query->where('test_field', 'test_value', Query::CONTAINS_CASE_SENSITIVE);

        static::assertSame($query->getQueryString(), 'test_content_types?test_field_containss=test_value');
    }

    public function testMultipleWhereContainsCaseSensitiveLogic(): void
    {
        $query = $this->getQueryMethod();
        $query->where('test_field', 'test_value', Query::CONTAINS_CASE_SENSITIVE);
        $query->where('test_field2', 'test_value2', Query::CONTAINS_CASE_SENSITIVE);

        static::assertSame($query->getQueryString(), 'test_content_types?test_field_containss=test_value&test_field2_containss=test_value2');
    }

    public function testSingleWhereContainsNotCaseSensitiveLogic(): void
    {
        $query = $this->getQueryMethod();
        $query->where('test_field', 'test_value', Query::CONTAINS_NOT_CASE_SENSITIVE);

        static::assertSame($query->getQueryString(), 'test_content_types?test_field_ncontainss=test_value');
    }

    public function testMultipleWhereContainsNotCaseSensitiveLogic(): void
    {
        $query = $this->getQueryMethod();
        $query->where('test_field', 'test_value', Query::CONTAINS_NOT_CASE_SENSITIVE);
        $query->where('test_field2', 'test_value2', Query::CONTAINS_NOT_CASE_SENSITIVE);

        static::assertSame($query->getQueryString(), 'test_content_types?test_field_ncontainss=test_value&test_field2_ncontainss=test_value2');
    }

    public function testSkip(): void
    {
        $query = $this->getQueryMethod();

        $query->skip(1);

        static::assertSame($query->getQueryString(), 'test_content_types?_start=1');
    }

    public function testLimit(): void
    {
        $query = $this->getQueryMethod();

        $query->setLimit(15);

        static::assertSame($query->getQueryString(), 'test_content_types?_limit=15');
    }

    public function testSortBySingle(): void
    {
        $query = $this->getQueryMethod();

        $query->sortBy([
            'id' => Query::SORT_ASC,
        ]);

        static::assertSame(urldecode($query->getQueryString()), 'test_content_types?_sort=id:asc');
    }

    public function testSortByMultiple(): void
    {
        $query = $this->getQueryMethod();

        $query->sortBy([
            'id' => Query::SORT_ASC,
            'name' => Query::SORT_DESC,
        ]);

        static::assertSame(urldecode($query->getQueryString()), 'test_content_types?_sort=id:asc,name:desc');
    }

    public function testGetContentType(): void
    {
        $query = $this->getQueryMethod();

        static::assertSame($query->getContentType(), 'test_content_types');
    }

    private function getQueryMethod(): Query
    {
        if (false === isset($this->baseQuery)) {
            $this->baseQuery = (new Query())->contentType('test_content_types');
        }

        return $this->baseQuery;
    }
}
