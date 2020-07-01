<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BackendTest extends WebTestCase
{
    /**
     * @dataProvider urlsProvider
     */
    public function testBackendPagesLoadCorrectly(string $url): void
    {
        $client = static::createClient();

        $client->request('GET',  $url);
        self::assertResponseIsSuccessful();
    }

    public function urlsProvider(): array
    {
        return [
            ['/admin?crudAction=index&crudId=1885af8'],
            ['/admin?crudAction=index&crudId=1885af8&page=2'],
            ['/admin?crudAction=index&crudId=1885af8&query=categ'],
            ['/admin?crudAction=detail&crudId=1885af8&entityId=1'],
            ['/admin?crudAction=edit&crudId=1885af8&entityId=1'],
            ['/admin?crudAction=index&crudId=0243a3c'],
            ['/admin?crudAction=index&crudId=0243a3c&page=2'],
            ['/admin?crudAction=index&crudId=0243a3c&query=lorem'],
            ['/admin?crudAction=detail&crudId=0243a3c&entityId=1'],
            ['/admin?crudAction=edit&crudId=0243a3c&entityId=1'],
        ];
    }
}
