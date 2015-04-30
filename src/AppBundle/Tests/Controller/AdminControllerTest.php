<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AdminControllerTest extends WebTestCase
{
    public function testIndexRedirectsToTheFirstEntityListing()
    {
        $client = static::createClient();
        $client->request('GET', '/admin/');

        $this->assertEquals(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());
        $this->assertEquals(
            '/admin/?action=list&entity=Category',
            $client->getResponse()->getTargetUrl()
        );
    }
}
