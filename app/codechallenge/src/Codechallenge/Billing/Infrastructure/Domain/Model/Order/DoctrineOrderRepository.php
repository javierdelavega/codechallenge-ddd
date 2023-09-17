<?php

namespace App\Codechallenge\Billing\Infrastructure\Domain\Model\Order;

use App\Codechallenge\Auth\Domain\Model\UserId;
use App\Codechallenge\Billing\Domain\Model\Order\Order;
use App\Codechallenge\Billing\Domain\Model\Order\OrderRepository;
use App\Codechallenge\Billing\Domain\Model\Order\OrderId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository for manage the orders using Doctrine ORM
 */
class DoctrineOrderRepository extends ServiceEntityRepository implements OrderRepository
{
  private $entityManager;

  /**
   * Constructor
   * 
   * @param ManagerRegistry $registry doctrine manager registry
   */
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, Order::class);
    $this->entityManager = $this->getEntityManager();
  }

  /**
   * Adds a order and persist in the database
   * 
   * @param Order $order
   */
  public function save(Order $order)
  {
    $this->entityManager->persist($order);
    $this->entityManager->flush();
  }

  /**
   * Removes a order and delete from the database
   * 
   * @param Order $order
   */
  public function remove(Order $order)
  {
    $this->entityManager->remove($order);
    $this->entityManager->flush();
  }

  /**
   * Retrieves a order of the given id from the database
   * 
   * @param OrderId the id of the order
   * @return Order the Order with requested id
   */
  public function orderOfId(OrderId $orderId)
  {
    return $this->entityManager->find('App\Codechallenge\Billing\Domain\Model\Order\Order', $orderId);
  }

  /**
   * Retrieves the orders of the given user id
   * 
   * @param UserId the id of the user
   * @return Array the orders
   */
  public function ordersOfUser(UserId $userId) : Array
  {
      return $this->createQueryBuilder('o')
          ->andWhere('o.userId = :userId')
          ->setParameter('userId', $userId->id())
          ->getQuery()
          ->getResult()
      ;
  }

  /**
   * Gets a new unique Order id
   * 
   * @return OrderId
   */
  public function nextIdentity()
  {
    return new OrderId();
  }
}