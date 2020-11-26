<?php


declare(strict_types=1);

namespace App\Tests\Func;


use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfilTest extends WebTestCase

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
               "email":"dominique48@yahoo.fr",
               "password":"password"
           }'
        );
        $data = json_decode($client->getResponse()->getContent(), true);
        //dd($data);
        $client->setServerParameter('HTTP_AUTHORIZATION', \sprintf('Bearer %s', $data['token']));
        $client->setServerParameter('CONTENT_TYPE', 'application/json');
        //dd($client)
        return $client;
    }

    //collectionOperation

    public function testGetProfils(): void
    {
        $client = $this->createAuthenticatedClient();
        $client->request('GET', 'admin/profils');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testGetUsersByID(): void
    {
        $client = $this->createAuthenticatedClient();
        $client->request('GET', 'admin/profils/1');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testArchiveProfils(): void
    {
        $client = $this->createAuthenticatedClient();
        $client->request('DELETE', 'admin/profils/1');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testAddProfils(): void
    {
        $client = $this->createAuthenticatedClient();
        $client->request(
            'POST',
            'admin/profils',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                "libelle":"admin"
            }'
        );
        //dd($client);
        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}
