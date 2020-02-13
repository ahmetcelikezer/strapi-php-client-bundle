<?php

declare(strict_types=1);

namespace Ahc\StrapiClientBundle\Factory;

use Ahc\StrapiClientBundle\Exception\MalformedParameterException;
use Ahc\StrapiClientBundle\Resource\SystemFields;

class SystemFieldsFactory implements StaticFactoryInterface
{
    /**
     * @param mixed[] $fields
     *
     * @throws MalformedParameterException
     */
    public static function create(array $fields): SystemFields
    {
        return new SystemFields(
            (string) $fields['id'],
            self::convertStringToDatetime($fields['created_at']),
            self::convertStringToDatetime($fields['updated_at'])
        );
    }

    private static function convertStringToDatetime(string $datetimeString): \DateTimeImmutable
    {
        $datetime = date_create_immutable($datetimeString);

        if (false !== $datetime) {
            return $datetime;
        }

        throw new MalformedParameterException(sprintf('%s is malformed! It must be type of "%s"', $datetimeString, \DateTimeImmutable::class));
    }
}
