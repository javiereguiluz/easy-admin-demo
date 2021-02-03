<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class LoadCategories extends Fixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 20;
    }

    public function load(ObjectManager $manager)
    {
        foreach (range(0, 9) as $i) {
            $category = new Category();
            $category->setName('Category #'.$i);

            $this->addReference('category-'.$i, $category);
            $manager->persist($category);
        }

        $manager->flush();

        foreach (range(0, 99) as $i) {
            $category = new Category();
            $category->setName('Subcategory #'.$i);
            $category->setParent($this->getReference('category-'.($i % 10)));

            $this->addReference('subcategory-'.$i, $category);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
