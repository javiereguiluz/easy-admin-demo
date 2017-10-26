<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity
 * @Vich\Uploadable
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64)
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $email;

    /**
     * @var Purchase[]
     *
     * @ORM\OneToMany(targetEntity="Purchase", mappedBy="buyer", cascade={"remove"})
     */
    private $purchases;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * It only stores the name of the file which stores the contract subscribed
     * by the user.
     *
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $contract;

    /**
     * This unmapped property stores the binary contents of the file which stores
     * the contract subscribed by the user.
     *
     * @Vich\UploadableField(mapping="user_contracts", fileNameProperty="contract")
     *
     * @var File
     */
    private $contractFile;

    public function __toString()
    {
        return (string) $this->username;
    }

    public function __construct()
    {
        $this->active = false;
        $this->purchases = new ArrayCollection();
        $this->isActive = true;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set active.
     *
     * @param bool $active
     *
     * @return User
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param Purchase[] $purchases
     */
    public function setPurchases($purchases)
    {
        $this->purchases = $purchases;
    }

    /**
     * @return Purchase[]
     */
    public function getPurchases()
    {
        return $this->purchases;
    }

    /**
     * @param File $contract
     */
    public function setContractFile(File $contract = null)
    {
        $this->contractFile = $contract;
    }

    /**
     * @return File
     */
    public function getContractFile()
    {
        return $this->contractFile;
    }

    /**
     * @param string $contract
     */
    public function setContract($contract)
    {
        $this->contract = $contract;
    }

    /**
     * @return string
     */
    public function getContract()
    {
        return $this->contract;
    }
}
