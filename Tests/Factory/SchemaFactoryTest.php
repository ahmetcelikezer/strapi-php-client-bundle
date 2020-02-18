<?php

namespace Ahc\StrapiClientBundle\Tests\Factory;

use Ahc\StrapiClientBundle\Factory\SchemaFactory;
use PHPUnit\Framework\TestCase;

/**
 * @covers Ahc\StrapiClientBundle\Factory\SchemaFactory
 */
class SchemaFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $mockData = [
            'modelType' => 'Model Type',
            'connection' => 'Connection',
            'collectionName' => 'Collection Name',
            'info' => ['info_key'=>'info_value'],
            'options' => ['option_key'=>'option_value'],
            'attributes' => ['attribute_key'=>['attribute_value']],
        ];

        $schema = SchemaFactory::create($mockData);

        $this->assertIsString($schema->getModelType());
        $this->assertEquals($schema->getModelType(), 'Model Type');

        $this->assertIsString($schema->getConnection());
        $this->assertEquals($schema->getConnection(), 'Connection');

        $this->assertIsString($schema->getCollectionName());
        $this->assertEquals($schema->getCollectionName(), 'Collection Name');

        $this->assertIsArray($schema->getInfo());
        $this->assertEquals($schema->getInfo(), ['info_key'=>'info_value']);

        $this->assertIsArray($schema->getOptions());
        $this->assertEquals($schema->getOptions(), ['option_key'=>'option_value']);

        $this->assertIsArray($schema->getAttributes());
        $this->assertEquals($schema->getAttributes(), ['attribute_key'=>['attribute_value']]);

        $this->assertIsArray($schema->getAttribute('attribute_key'));
        $this->assertEquals($schema->getAttribute('attribute_key'), ['attribute_value']);

    }
}