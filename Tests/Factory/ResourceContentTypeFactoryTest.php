<?php

namespace Ahc\StrapiClientBundle\Tests\Factory;

use Ahc\StrapiClientBundle\Entity\ResourceContentType;
use Ahc\StrapiClientBundle\Factory\ResourceContentTypeFactory;
use Ahc\StrapiClientBundle\Resource\ContentProperties;
use Ahc\StrapiClientBundle\Resource\Schema;
use Ahc\StrapiClientBundle\Resource\SystemFields;
use PHPUnit\Framework\TestCase;

/**
 * @covers Ahc\StrapiClientBundle\Factory\ResourceContentTypeFactory
 */
class ResourceContentTypeFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $resourceContentType = self::getResourceContentType();

        $this->assertInstanceOf(SystemFields::class, $resourceContentType->getSystemFields());
        $this->assertInstanceOf(ContentProperties::class, $resourceContentType->getContentProperties());

        $this->assertEquals($resourceContentType->getSystemFields()->getId(), 1);

        $systemCreatedDate = $resourceContentType->getSystemFields()->getCreatedAt();
        $systemUpdatedDate = $resourceContentType->getSystemFields()->getUpdatedAt();

        $this->assertEquals($systemCreatedDate, new \DateTimeImmutable('2020-02-13T21:13:27.614Z'));
        $this->assertEquals($systemUpdatedDate, new \DateTimeImmutable('2020-02-13T21:13:27.614Z'));

        $this->assertEquals($resourceContentType->getContentProperties()->getUid(), 'application::test.test');

        $this->assertInstanceOf(Schema::class, $resourceContentType->getContentProperties()->getSchema());

        $this->assertEquals($resourceContentType->getContentProperties()->getSchema()->getModelType(), 'contentType');
        $this->assertEquals($resourceContentType->getContentProperties()->getSchema()->getConnection(), 'default');
        $this->assertEquals($resourceContentType->getContentProperties()->getSchema()->getCollectionName(), 'tests');
        $this->assertEquals($resourceContentType->getContentProperties()->getSchema()->getInfo(), ['name'=>'Test']);
        $this->assertEquals($resourceContentType->getContentProperties()->getSchema()->getOptions(), ['increments'=>true,'timestamps'=>['created_at','updated_at']]);
        $this->assertEquals($resourceContentType->getContentProperties()->getSchema()->getAttributes(), [ 'id' => ['type'=>'integer'],'title'=>['type'=>'string'],'buttons'=>['type'=>'dynamiczone','components'=>['button.button-with-icon']],'ctaSection'=>['type'=>'component','repeatable'=>false,'component'=>'cta.cta'],'created_at'=>['type'=>'timestamp'],'updated_at'=>['type'=>'timestamp']]);
        $this->assertEquals($resourceContentType->getContentProperties()->getSchema()->getAttribute('buttons'), ['type'=>'dynamiczone', 'components'=>['button.button-with-icon']]);

        $this->assertEquals($resourceContentType->getContentProperties()->getFieldType('title'), 'string');
        $this->assertEquals($resourceContentType->getContentProperties()->getIsDisplayed(), true);
        $this->assertEquals($resourceContentType->getContentProperties()->getLabel(), 'Tests');
        $this->assertEquals($resourceContentType->getContentProperties()->getName(), 'Test');
    }

    private static function getResourceContentType(): ResourceContentType
    {
        $rawContents =  json_decode(file_get_contents(__DIR__.'/../data/raw-contents.json'), true);

        return ResourceContentTypeFactory::create($rawContents);
    }
}