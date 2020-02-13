<?php

declare(strict_types=1);

namespace Ahc\StrapiClientBundle\Resource;

class Mapper
{
    private const CONTENT_SYSTEM_FIELDS = [
        'id',
        'created_at',
        'updated_at',
    ];

    private const COMPONENT_IDENTIFIER_FIELDS = [
        '__component',
        'id',
    ];

    /**
     * @param string[] $contentType
     * @param mixed[]  $components
     *
     * @return mixed[]
     */
    public static function mapResourceContent(array $contentType, array $components): array
    {
        $fields = [];

        foreach ($components as $component) {
            $key = $component['id'];

            $systemFields = self::getSystemFields($component);
            $component = self::unsetSystemFields($component, $systemFields);

            if (false === isset($fields['contentProperties'])) {
                $fields[$key]['contentProperties'] = $contentType;
            }
            $fields[$key]['fields'] = $component;
            $fields[$key]['systemFields'] = $systemFields;
        }

        return $fields;
    }

    /**
     * @param mixed[] $component
     *
     * @return mixed[]
     */
    public static function mapResourceComponent(array $component): array
    {
        $mappedComponent = self::getIdentifierFields($component);
        $component = self::unsetIdentifierFields($component);

        $mappedComponent['fields'] = $component;

        return $mappedComponent;
    }

    /**
     * @param mixed[] $component
     *
     * @return mixed[]
     */
    private static function getSystemFields(array $component): array
    {
        $systemFields = [];

        foreach (self::CONTENT_SYSTEM_FIELDS as $systemField) {
            if (true === \array_key_exists($systemField, $component)) {
                $systemFields[$systemField] = $component[$systemField];
            }
        }

        return $systemFields;
    }

    /**
     * @param mixed[] $component
     * @param mixed[] $systemFields
     *
     * @return mixed[]
     */
    private static function unsetSystemFields(array $component, array $systemFields): array
    {
        foreach (array_keys($component) as $field) {
            if (\array_key_exists($field, $systemFields)) {
                unset($component[$field]);
            }
        }

        return $component;
    }

    /**
     * @param mixed[] $component
     *
     * @return mixed[]
     */
    private static function getIdentifierFields(array $component): array
    {
        $identifierFields = [];

        foreach (self::COMPONENT_IDENTIFIER_FIELDS as $field) {
            if (\array_key_exists($field, $component)) {
                $identifierFields[$field] = $component[$field];
            }
        }

        return $identifierFields;
    }

    /**
     * @param mixed[] $component
     *
     * @return mixed[]
     */
    private static function unsetIdentifierFields(array $component): array
    {
        foreach (self::COMPONENT_IDENTIFIER_FIELDS as $field) {
            if (\array_key_exists($field, $component)) {
                unset($component[$field]);
            }
        }

        return $component;
    }
}
