<?php

namespace App\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;

class LoadUsers extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    public function getOrder()
    {
        return 10;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $encoder = $this->container->get('security.password_encoder');

        foreach (range(0, 19) as $i) {
            $user = new User();
            $user->setUsername('user'.$i);
            $user->setEmail('user'.$i.'@example.com');
            $user->setActive(true);
            $user->setContract('contract'.($i % 5).'.pdf');

            $this->addReference('user-'.$i, $user);
            $manager->persist($user);
        }

        // 'John Smith' is the admin user allowed to access the EasyAdmin Demo
        $user = new User();
        $user->setUsername('john.smith');
        $user->setEmail('john.smith@example.com');
        $user->setActive(true);
        $user->setContract('contract0.pdf');
        $manager->persist($user);
        $manager->flush();
    }
}
