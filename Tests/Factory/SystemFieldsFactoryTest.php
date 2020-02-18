<?php

namespace Ahc\StrapiClientBundle\Tests\Factory;

use Ahc\StrapiClientBundle\Factory\SystemFieldsFactory;
use PHPUnit\Framework\TestCase;

/**
 * @covers Ahc\StrapiClientBundle\Factory\SystemFieldsFactory
 */
class SystemFieldsFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $systemFields = SystemFieldsFactory::create([
            'id' => 1881,
            'created_at' => '2020-02-13T21:13:27.614Z',
            'updated_at' => '2020-02-13T21:13:27.614Z',
        ]);

        $this->assertEquals($systemFields->getId(), 1881);
        $this->assertEquals($systemFields->getCreatedAt(), new \DateTimeImmutable('2020-02-13T21:13:27.614Z'));
        $this->assertEquals($systemFields->getUpdatedAt(), new \DateTimeImmutable('2020-02-13T21:13:27.614Z'));
    }
}