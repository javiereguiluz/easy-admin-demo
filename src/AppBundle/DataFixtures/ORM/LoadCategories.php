<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Category;

class LoadCategories extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 10;
    }

    public function load(ObjectManager $manager)
    {
        foreach (range(1, 100) as $i) {
            $category = new Category();
            $category->setName('Parent Category #'.$i);

            $this->addReference('parent-category-'.$i, $category);
            $manager->persist($category);
        }

        $manager->flush();

        foreach (range(1, 100) as $i) {
            $category = new Category();
            $category->setName('Category #'.$i);
            $category->setParent($this->getReference('parent-category-'.$i));

            $this->addReference('category-'.$i, $category);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
