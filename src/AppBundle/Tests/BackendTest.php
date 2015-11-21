<?php

namespace AppBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;

class BackendTest extends WebTestCase
{
    /**
     * @dataProvider queryParametersProvider
     */
    public function testBackendPagesLoadCorrectly($queryParameters)
    {
        $client = self::createClient();
        $client->request('GET', '/admin/?'.http_build_query($queryParameters));

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function queryParametersProvider()
    {
        return array(
            array(
                array('action' => 'list', 'entity' => 'Category'),
            ),
            array(
                array('action' => 'list', 'entity' => 'Category', 'page' => 2),
            ),
            array(
                array('action' => 'search', 'entity' => 'Category', 'query' => 'cat'),
            ),
            array(
                array('action' => 'show', 'entity' => 'Category', 'id' => 1),
            ),
            array(
                array('action' => 'edit', 'entity' => 'Category', 'id' => 1),
            ),

            array(
                array('action' => 'list', 'entity' => 'Product'),
            ),
            array(
                array('action' => 'list', 'entity' => 'Product', 'page' => 2),
            ),
            array(
                array('action' => 'search', 'entity' => 'Product', 'query' => 'lorem'),
            ),
            array(
                array('action' => 'show', 'entity' => 'Product', 'id' => 1),
            ),
            array(
                array('action' => 'edit', 'entity' => 'Product', 'id' => 1),
            ),
        );
    }
}
