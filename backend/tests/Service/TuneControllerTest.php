<?php

namespace App\Tests\Service;

use App\Tests\Utils\FixtureAwareCaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TuneControllerTest extends WebTestCase
{
    use FixtureAwareCaseTrait;
    public function testAssertTrue():void {
        $this->assertTrue(true);
    }
    public function testIfResponseIsSuccessful(): void
    {
        $client = static::createClient();
        FixtureAwareCaseTrait::loadFixturesWithContainer(static::getContainer(), 'tunes');
        echo('OKAY');
        $crawler = $client->request('GET', '/api/tune');
        $this->assertResponseIsSuccessful();
    }
    public function testGetTune(): void
    {
        $client = static::createClient();

        FixtureAwareCaseTrait::loadFixturesWithContainer(static::getContainer(), "tunes");

        $client->request('GET', '/api/tune?filter=Thriller');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertJson($response->getContent());

        $result = json_decode($response->getContent(), true);
        $this->assertCount(1, $result);
        $this->assertEquals('Michael Jackson', $result[0]['author']);
    }
}
