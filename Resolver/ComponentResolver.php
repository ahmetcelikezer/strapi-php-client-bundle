<?php

declare(strict_types=1);

namespace Ahc\StrapiClientBundle\Resolver;

use Ahc\StrapiClientBundle\Factory\ResourceComponentFactory;
use Ahc\StrapiClientBundle\Resource\ContentProperties;

class ComponentResolver extends BaseResolver
{
    protected ContentProperties $properties;

    /** @var mixed[] */
    private array $fields;

    /** @param mixed[] $fields */
    public function __construct(array $fields, ContentProperties $properties)
    {
        $this->fields = $fields;
        $this->properties = $properties;
    }

    /** @return mixed[] */
    public function resolve(): array
    {
        $resolvedFields = [];

        foreach ($this->fields as $key => $field) {
            $type = $this->properties->getFieldType($key);
            if (self::DYNAMIC_ZONE === $type) {
                $resolvedFields[$key] = $this->resolveComponent($key);

                continue;
            }

            $resolvedFields[$key] = $field;
        }

        return $resolvedFields;
    }

    /** @return mixed[] */
    private function resolveComponent(string $key): array
    {
        $resolvedComponents = [];

        if ($this->hasMany($key)) {
            $components = $this->fields[$key];

            foreach ($components as $component) {
                $resolvedComponents[$component['__component']] = ResourceComponentFactory::create($component);
            }
        }

        return $resolvedComponents;
    }

    private function hasMany(string $key): bool
    {
        $field = $this->fields[$key];

        return \is_array($field) && \array_key_exists(0, $field) && !\array_key_exists('__component', $field);
    }
}
