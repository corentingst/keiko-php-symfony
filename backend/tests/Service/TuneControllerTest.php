<?php

namespace App\Tests\Service;

use App\Tests\Utils\FixtureAwareCaseTrait;
use http\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\AbstractBrowser;
use Symfony\Component\HttpFoundation\Response;

class TuneControllerTest extends WebTestCase
{
    use FixtureAwareCaseTrait;
    public function testAssertTrue(): void
    {
        $this->assertTrue(true);
    }
    //protected function createAuthenticatedClient($email = 'corenting@theodo.fr', $password = 'theodo'): AbstractBrowser
    protected function createAuthenticatedClient($email = 'test@test', $password = 'TestPassword'): AbstractBrowser
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/login_check',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => $email,
                'password' => $password,
            ])
        );
//        fwrite(STDERR, print_r($client->getResponse()->getContent(), TRUE));

        $data = json_decode($client->getResponse()->getContent(), true);

        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }
    public function testGetPages()
    {
        $this->addToAssertionCount(1);
        echo "debut test";
        $client = $this->createAuthenticatedClient();
        $client->request('GET', '/api/tune');
        $this->assertResponseIsSuccessful();
    }


    public function testIfResponseIsSuccessful(): void
    {
        $client = static::createClient();
        FixtureAwareCaseTrait::loadFixturesWithContainer(static::getContainer(), 'tunes');
//        echo('OKAY');
        $crawler = $client->request('GET', '/api/tune');
        $this->assertResponseIsSuccessful();
    }

    public function testGetTune(): void
    {
        $client = static::createClient();

        FixtureAwareCaseTrait::loadFixturesWithContainer(static::getContainer(), "tunes");
        FixtureAwareCaseTrait::loadFixturesWithContainer(static::getContainer(), "users");

        $client->request('GET', '/api/tune?filter=Thriller');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertJson($response->getContent());

        $result = json_decode($response->getContent(), true);
        $this->assertCount(1, $result);
        $this->assertEquals('Michael Jackson', $result[0]['author']);
    }
}
