<?php

/*
 * This file is part of the Doctrine-TestSet project created by
 * https://github.com/MacFJA
 *
 * For the full copyright and license information, please view the LICENSE
 * at https://github.com/MacFJA/Doctrine-TestSet
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Model\Shipment;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Order
 *
 * @author MacFJA
 *
 * @ORM\Table(name="order")
 * @ORM\Entity
 */
class Order {
    /**
     * The order increment id. This identifier will be use in all communication between teh customer and the store.
     * @var integer
     * @ORM\Column(type="integer", name="increment_id")
     */
    public $incrementId = null;

    /**
     * The Unique id of the order
     * @var string
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="guid")
     */
    public $guid = null;

    /**
     * The day of the delivery
     * @var \DateTime
     * @ORM\Column(type="date")
     */
    public $deliverySelected = null;

    /**
     * The purchase date in the customer timezone
     * @var \DateTime
     * @ORM\Column(type="datetimetz")
     */
    public $purchaseAt = null;

    /**
     * The shipping information
     * @var Shipment
     * @ORM\Column(type="object")
     */
    public $shipping = null;

    /**
     * The customer preferred time of the day for the delivery
     * @var \DateTime
     * @ORM\Column(type="time")
     */
    public $preferredDeliveryHour = null;

    /**
     * The customer billing address.
     * @var array
     * @ORM\Column(type="json_array")
     */
    public $billingAddress = array();
    /**
     * Items that have been ordered
     * @var OrderItem[]
     * @ORM\ManyToMany(targetEntity="OrderItem")
     * @ORM\JoinTable(name="order_order_item",
     *      joinColumns={@ORM\JoinColumn(name="order_id", referencedColumnName="guid")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="item_id", referencedColumnName="id", unique=true)}
     *      )
     */
    public $orderedItems;

    /**
     * Constructor of the Order class.
     * (Initialize some fields)
     */
    function __construct()
    {
        //Initialize orderedItems as a Doctrine Collection
        $this->orderedItems = new ArrayCollection();
        //Initialize purchaseAt to now (useful for new order, override by existing one)
        $this->purchaseAt = new \DateTime();
        $this->deliverySelected = new \DateTime('+2 days');
        $this->preferredDeliveryHour = new \DateTime('14:00');
        $this->incrementId = $this->generateIncrementId();
    }

    /**
     * Set the address where the customer want its billing
     * @param array $billingAddress
     */
    public function setBillingAddress($billingAddress)
    {
        $this->billingAddress = $billingAddress;
    }

    /**
     * Get the customer billing address
     * @return array
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * Set the day of delivery
     * @param \DateTime $deliverySelected
     */
    public function setDeliverySelected($deliverySelected)
    {
        $this->deliverySelected = $deliverySelected;
    }

    /**
     * Get the day when the customer want to be deliver
     * @return \DateTime
     */
    public function getDeliverySelected()
    {
        return $this->deliverySelected;
    }

    /**
     * Set the order increment id
     * @param int $incrementId
     */
    public function setIncrementId($incrementId)
    {
        $this->incrementId = $incrementId;
    }

    /**
     * Get the order increment id
     * @return int
     */
    public function getIncrementId()
    {
        return $this->incrementId;
    }

    /**
     * Set all items ordered
     * @param OrderItem[] $orderedItems
     */
    public function setOrderedItems($orderedItems)
    {
        $this->orderedItems = $orderedItems;
    }

    /**
     * Get all ordered items
     * @return OrderItem[]
     */
    public function getOrderedItems()
    {
        return $this->orderedItems;
    }

    /**
     * Set the delivery hour
     * @param \DateTime $preferredDeliveryHour
     */
    public function setPreferredDeliveryHour($preferredDeliveryHour)
    {
        $this->preferredDeliveryHour = $preferredDeliveryHour;
    }

    /**
     * Get the delivery hour
     * @return \DateTime
     */
    public function getPreferredDeliveryHour()
    {
        return $this->preferredDeliveryHour;
    }

    /**
     * Set the date when the order have been created
     * @param \DateTime $purchaseAt
     */
    public function setPurchaseAt($purchaseAt)
    {
        $this->purchaseAt = $purchaseAt;
    }

    /**
     * Get the date of the order
     * @return \DateTime
     */
    public function getPurchaseAt()
    {
        return $this->purchaseAt;
    }

    /**
     * Set the shipping information
     * @param Shipment $shipping
     */
    public function setShipping($shipping)
    {
        $this->shipping = $shipping;
    }

    /**
     * Get the shipping information
     * @return Shipment
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * Generate an increment id base on the store id and teh current date
     * @param int $storeId
     * @return string
     */
    public function generateIncrementId($storeId=1) {
        $uid = date('YmdHi');
        return sprintf('%d%O13d', $storeId, $uid);
    }

    /** {@inheritdoc} */
    function __toString()
    {
        return 'Order #'.$this->getIncrementId();
    }
}
