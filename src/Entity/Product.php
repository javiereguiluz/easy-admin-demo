<?php

/*
 * This file is part of the Doctrine-TestSet project created by
 * https://github.com/MacFJA
 *
 * For the full copyright and license information, please view the LICENSE
 * at https://github.com/MacFJA/Doctrine-TestSet
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class Product.
 *
 * @author MacFJA
 *
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Product
{
    /**
     * The identifier of the product.
     *
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id = null;

    /**
     * The creation date of the product.
     *
     * @var \DateTime
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $createdAt = null;

    /**
     * List of tags associated to the product.
     *
     * @var string[]
     * @ORM\Column(type="simple_array")
     */
    private $tags = array();

    /**
     * The EAN 13 of the product. (type set to string in PHP due to 32 bit limitation).
     *
     * @var string
     * @ORM\Column(type="bigint")
     */
    private $ean;

    /**
     * Indicate if the product is enabled (available in store).
     *
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $enabled = false;

    /**
     * It only stores the name of the image associated with the product.
     *
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $image;

    /**
     * This unmapped property stores the binary contents of the image file
     * associated with the product.
     *
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="image")
     *
     * @var File
     */
    private $imageFile;

    /**
     * Features of the product.
     * Associative array, the key is the name/type of the feature, and the value the data.
     * Example:<pre>array(
     *     'size' => '13cm x 15cm x 6cm',
     *     'bluetooth' => '4.1'
     * )</pre>.
     *
     * @var array
     * @ORM\Column(type="array")
     */
    private $features = array();

    /**
     * The price of the product.
     *
     * @var float
     * @ORM\Column(type="float")
     */
    private $price = 0.0;

    /**
     * The name of the product.
     *
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * The description of the product.
     *
     * @var string
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * List of categories where the products is
     * (Owning side).
     *
     * @var Category[]
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="products")
     * @ORM\JoinTable(name="product_category")
     */
    private $categories;

    /**
     * @var PurchaseItem[]
     * @ORM\OneToMany(targetEntity="PurchaseItem", mappedBy="product", cascade={"remove"})
     */
    private $purchasedItems;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    /**
     * Add a category in the product association.
     * (Owning side).
     *
     * @param $category Category the category to associate
     */
    public function addCategory($category)
    {
        if ($this->categories->contains($category)) {
            return;
        }

        $this->categories->add($category);
        $category->addProduct($this);
    }

    /**
     * Remove a category in the product association.
     * (Owning side).
     *
     * @param $category Category the category to associate
     */
    public function removeCategory($category)
    {
        if (!$this->categories->contains($category)) {
            return;
        }

        $this->categories->removeElement($category);
        $category->removeProduct($this);
    }

    /**
     * Set the description of the product.
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * The the full description of the product.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Define the EAN code of the product.
     *
     * @param string $ean
     */
    public function setEan($ean)
    {
        $this->ean = $ean;
    }

    /**
     * Get the EAN code.
     *
     * @return string
     */
    public function getEan()
    {
        return $this->ean;
    }

    /**
     * Set if the product is enable.
     *
     * @param bool $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * Is the product enabled?
     *
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Alias of getEnabled.
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->getEnabled();
    }

    /**
     * Set the list of features.
     * The parameter is an associative array (key as type, value as data.
     *
     * @param array $features
     */
    public function setFeatures($features)
    {
        $this->features = $features;
    }

    /**
     * Get all product features.
     *
     * @return array
     */
    public function getFeatures()
    {
        return $this->features;
    }

    /**
     * @param File $image
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the product name.
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Retrieve the name of the product.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the price.
     *
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Get the price of the product.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the list of the tags.
     *
     * @param \string[] $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * Get the list of tags associated to the product.
     *
     * @return \string[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Get all associated categories.
     *
     * @return Category[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set all categories of the product.
     *
     * @param Category[] $categories
     */
    public function setCategories($categories)
    {
        // This is the owning side, we have to call remove and add to have change in the category side too.
        foreach ($this->getCategories() as $category) {
            $this->removeCategory($category);
        }
        foreach ($categories as $category) {
            $this->addCategory($category);
        }
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get the id of the product.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @param PurchaseItem[] $purchasedItems
     */
    public function setPurchasedItems($purchasedItems)
    {
        $this->purchasedItems = $purchasedItems;
    }

    /**
     * @return PurchaseItem[]
     */
    public function getPurchasedItems()
    {
        return $this->purchasedItems;
    }
}
