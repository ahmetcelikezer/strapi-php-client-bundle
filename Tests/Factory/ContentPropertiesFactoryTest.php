<?php

namespace Ahc\StrapiClientBundle\Tests;

use Ahc\StrapiClientBundle\Factory\ContentPropertiesFactory;
use Ahc\StrapiClientBundle\Resource\ContentProperties;
use Ahc\StrapiClientBundle\Resource\Schema;
use PHPUnit\Framework\TestCase;

/**
 * @covers Ahc\StrapiClientBundle\Factory\ContentPropertiesFactory
 */
class ContentPropertiesFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $mockData['uid'] = 'page:test';
        $mockData['name'] = 'Name';
        $mockData['label'] = 'Label';
        $mockData['isDisplayed'] = false;
        $mockData['schema'] = [
            'modelType',
            'connection',
            'collectionName',
            ['info_key'=>'info'],
            ['options_key'=>'options'],
            ['attributes_key'=>'attributes'],
        ];
        $contentProperties = ContentPropertiesFactory::create($mockData);

        $this->assertInstanceOf(ContentProperties::class, $contentProperties);

        $this->assertIsString($contentProperties->getUid());
        $this->assertEquals($contentProperties->getUid(), 'page:test');

        $this->assertIsString($contentProperties->getName());
        $this->assertEquals($contentProperties->getName(), 'Name');

        $this->assertIsString($contentProperties->getLabel());
        $this->assertEquals($contentProperties->getLabel(), 'Label');

        $this->assertIsBool($contentProperties->getIsDisplayed());
        $this->assertEquals($contentProperties->getIsDisplayed(), false);

        $this->assertInstanceOf(Schema::class, $contentProperties->getSchema());
    }
}