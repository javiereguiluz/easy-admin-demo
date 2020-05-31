<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BackendTest extends WebTestCase
{
    public function testBackendPagesLoadCorrectly(): void
    {
        $client = static::createClient();

        $urls = [
            '/admin?crudAction=index&crudId=04488af',
            '/admin?crudAction=index&crudId=04488af&page=2',
            '/admin?crudAction=index&crudId=04488af&query=categ',
            '/admin?crudAction=detail&crudId=04488af&entityId=1',
            '/admin?crudAction=edit&crudId=04488af&entityId=1',
            '/admin?crudAction=index&crudId=d76a8a6',
            '/admin?crudAction=index&crudId=d76a8a6&page=2',
            '/admin?crudAction=index&crudId=d76a8a6&query=lorem',
            '/admin?crudAction=detail&crudId=d76a8a6&entityId=1',
            '/admin?crudAction=edit&crudId=d76a8a6&entityId=1',
        ];

        foreach ($urls as $url) {
            $client->request('GET',  $url);
            self::assertResponseIsSuccessful();
        }
    }
}
