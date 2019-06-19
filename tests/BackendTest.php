<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BackendTest extends WebTestCase
{
    /**
     * @dataProvider queryParametersProvider
     */
    public function testBackendPagesLoadCorrectly(array $queryParameters): void
    {
        static::createClient()->request('GET', '/admin/', $queryParameters);
        self::assertResponseIsSuccessful();
    }

    public function queryParametersProvider(): array
    {
        return [
            [
                ['action' => 'list', 'entity' => 'Category'],
            ],
            [
                ['action' => 'list', 'entity' => 'Category', 'page' => 2],
            ],
            [
                ['action' => 'search', 'entity' => 'Category', 'query' => 'cat'],
            ],
            [
                ['action' => 'show', 'entity' => 'Category', 'id' => 1],
            ],
            [
                ['action' => 'edit', 'entity' => 'Category', 'id' => 1],
            ],

            [
                ['action' => 'list', 'entity' => 'Product'],
            ],
            [
                ['action' => 'list', 'entity' => 'Product', 'page' => 2],
            ],
            [
                ['action' => 'search', 'entity' => 'Product', 'query' => 'lorem'],
            ],
            [
                ['action' => 'show', 'entity' => 'Product', 'id' => 1],
            ],
            [
                ['action' => 'edit', 'entity' => 'Product', 'id' => 1],
            ],
        ];
    }
}
