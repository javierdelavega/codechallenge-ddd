<?php

namespace App\Codechallenge\Billing\Domain\Model\Order;

use Symfony\Component\Uid\Uuid;
//use Ramsey\Uuid\Uuid;

/**
 * Value Object for Order id management
 */
class OrderId
{
  private $id;

  /**
   * Constructor
   * 
   * @param Uuid|null an Uuid order identity
   */
  public function __construct($id = null)
  {
    $this->id = $id ? :Uuid::v4();
    //$this->id = $id ? :Uuid::uuid4()->toString();

  }

  /**
   * Static method for create an ItemId object
   * 
   * @param Uuid|null an Uuid item identity
   * @return OrderId new OrderId object
   */
  public static function create($anId = null ) : OrderId
  {
    return new static($anId);
  }

  /**
   * Get the id string
   * 
   * @return string the id string
   */
  public function __toString() : string
  {
      return $this->id;
  }

  /**
   * Get the id
   * 
   * @return string the id Uuid
   */
  public function id() : string
  {
      return $this->id;
  }

  /**
   * Compare given OrderId with this OrderId
   * 
   * @param OrderId $orderId the order id to compare
   * @return bool true if the id are equals, false if different
   */
  public function equals(OrderId $orderId) : bool
  {
    return $this->id() === $orderId->id();
  }

}