<?php

namespace App\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TuneControllerTest extends WebTestCase
{
    public function testAssertTrue():void {
        $this->assertTrue(true);
    }
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/tune');
        $this->assertResponseIsSuccessful();
    }
}
