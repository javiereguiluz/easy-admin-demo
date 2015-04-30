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

    public function testLogo()
    {
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/admin/');

        $this->assertEquals('ACME Backend', $crawler->filter('#header-logo a')->text());
        $this->assertEquals('/admin/', $crawler->filter('#header-logo a')->attr('href'));
        $this->assertEquals('medium', $crawler->filter('#header-logo a')->attr('class'));
    }

    public function testMainMenuItems()
    {
        $menuItems = array(
            'Categories' => '/admin/?entity=Category&action=list&view=list',
            'Images' => '/admin/?entity=Image&action=list&view=list',
            'Purchases' => '/admin/?entity=Purchase&action=list&view=list',
            'Purchase Items' => '/admin/?entity=PurchaseItem&action=list&view=list',
            'Products' => '/admin/?entity=Product&action=list&view=list',
        );

        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/admin/');

        $i = 0;
        foreach ($menuItems as $label => $url) {
            $this->assertEquals($label, $crawler->filter('#header-menu li a')->eq($i)->text());
            $this->assertEquals($url, $crawler->filter('#header-menu li a')->eq($i)->attr('href'));

            $i++;
        }
    }
}
