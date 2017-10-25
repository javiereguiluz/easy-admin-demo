<?php

namespace AppBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;

class BackendTest extends WebTestCase
{
    /**
     * @dataProvider queryParametersProvider
     */
    public function testBackendPagesLoadCorrectly($queryParameters)
    {
        $client = $this->createAuthorizedClient();
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

    /**
     * Code copied from http://stackoverflow.com/a/27223293/2804294.
     *
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    private function createAuthorizedClient()
    {
        $client = static::createClient();
        $container = $client->getContainer();

        $session = $container->get('session');
        /** @var $userManager \FOS\UserBundle\Doctrine\UserManager */
        $userManager = $container->get('fos_user.user_manager');
        /** @var $loginManager \FOS\UserBundle\Security\LoginManager */
        $loginManager = $container->get('fos_user.security.login_manager');
        $firewallName = $container->getParameter('fos_user.firewall_name');

        $user = $userManager->findUserBy(array('username' => 'john.smith'));
        $loginManager->loginUser($firewallName, $user);

        // save the login token into the session and put it in a cookie
        $container->get('session')->set('_security_'.$firewallName,
            serialize($container->get('security.token_storage')->getToken()));
        $container->get('session')->save();
        $client->getCookieJar()->set(new Cookie($session->getName(), $session->getId()));

        return $client;
    }
}
