<?php

namespace Ahc\StrapiClientBundle\Tests;

use Ahc\StrapiClientBundle\Factory\ResourceComponentFactory;
use PHPUnit\Framework\TestCase;

/**
 * @covers Ahc\StrapiClientBundle\Factory\ResourceComponentFactory
 */
class ResourceComponentFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $mockData = [
            '__component' => 'test:component',
            'id' => 13,
            'field1' => 'string',
            'field2' => 3,
            'field3' => ['array'=>'inside'],
        ];

        $resourceComponent = ResourceComponentFactory::create($mockData);

        $this->assertIsString($resourceComponent->getComponentType());
        $this->assertEquals($resourceComponent->getComponentType(), 'test:component');

        $this->assertIsInt($resourceComponent->getID());
        $this->assertEquals($resourceComponent->getID(), 13);

        $this->assertIsString($resourceComponent->get('field1'));
        $this->assertEquals($resourceComponent->get('field1'), 'string');

        $this->assertIsInt($resourceComponent->get('field2'));
        $this->assertEquals($resourceComponent->get('field2'), 3);

        $this->assertIsArray($resourceComponent->get('field3'));
        $this->assertEquals($resourceComponent->get('field3'), ['array'=>'inside']);
    }
}
