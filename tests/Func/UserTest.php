<?php

declare(strict_types=1);
namespace App\Tests\Func;


use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserTest extends WebTestCase

{

    protected function createAuthenticatedClient(): KernelBrowser
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
               "email":"descamps.honore@wanadoo.fr",
               "password":"password"
           }'
        );
        $data = json_decode($client->getResponse()->getContent(), true);
        //dd($data);
        $client->setServerParameter('HTTP_AUTHORIZATION', \sprintf('Bearer %s', $data['token']));
        $client->setServerParameter('CONTENT_TYPE', 'application/json');
        //dd($client);
        return $client;
    }

    //collectionOperation

    public function testGetUsers(): void
    {
        $client = $this->createAuthenticatedClient();
        $client->request('GET', 'admin/users');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testGetUsersByID(): void
    {
        $client = $this->createAuthenticatedClient();
        $client->request('GET', 'admin/users/2');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testArchiveUsers(): void
    {
        $client = $this->createAuthenticatedClient();
        $client->request('DELETE', 'admin/users/2');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testAddUsers(): void
    {
        $client = static::createClient();
        $client->request(
            'POST',
            'admin/users',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                "nom":"diop",
                "prenom":"aziz"
            }'
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
