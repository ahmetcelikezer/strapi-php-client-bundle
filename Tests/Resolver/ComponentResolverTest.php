<?php

namespace Ahc\StrapiClientBundle\Tests\Resolver;

use Ahc\StrapiClientBundle\Factory\ResourceContentTypeFactory;
use Ahc\StrapiClientBundle\Resolver\ComponentResolver;
use PHPUnit\Framework\TestCase;

/**
 * @covers Ahc\StrapiClientBundle\Resolver\ComponentResolver
 */
class ComponentResolverTest extends TestCase
{
    public function testResolve(): void
    {
        $mockData = self::getMockData();
        $componentResolver = new ComponentResolver($mockData['fields'], $mockData['contentProperties']);

        $resolvedArray = $componentResolver->resolve();
        var_dump($resolvedArray);
        $this->assertArrayHasKey('title', $resolvedArray);
        $this->assertArrayHasKey('buttons', $resolvedArray);
        $this->assertArrayHasKey('ctaSection', $resolvedArray);

        $this->assertArrayHasKey('id', $resolvedArray['ctaSection']);
        $this->assertArrayHasKey('title', $resolvedArray['ctaSection']);
        $this->assertArrayHasKey('subtitle', $resolvedArray['ctaSection']);
        $this->assertArrayHasKey('button', $resolvedArray['ctaSection']);

        $this->assertArrayHasKey('id', $resolvedArray['ctaSection']['button']);
        $this->assertArrayHasKey('title', $resolvedArray['ctaSection']['button']);
        $this->assertArrayHasKey('url', $resolvedArray['ctaSection']['button']);
        $this->assertArrayHasKey('page', $resolvedArray['ctaSection']['button']);
        $this->assertArrayHasKey('button_type', $resolvedArray['ctaSection']['button']);
        $this->assertArrayHasKey('icon', $resolvedArray['ctaSection']['button']);

        $this->assertContains('Base Test', $resolvedArray);

        $this->assertEquals($resolvedArray['ctaSection']['id'], 3);
    }

    private static function getMockData(): array
    {
        $data = [];

        $content =  ResourceContentTypeFactory::create(json_decode(file_get_contents(__DIR__.'/../data/raw-contents.json'), true));

        $data['fields'] = $content->getFields();
        $data['contentProperties'] = $content->getContentProperties();

        return $data;
    }

}