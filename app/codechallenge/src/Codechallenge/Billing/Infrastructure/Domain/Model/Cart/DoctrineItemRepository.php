<?php

namespace App\Codechallenge\Billing\Infrastructure\Domain\Model\Cart;


use App\Codechallenge\Billing\Domain\Model\Cart\Item;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository for manage the items of the cart using Doctrine ORM
 */
class DoctrineItemRepository extends ServiceEntityRepository
{
  private $entityManager;

  /**
   * Constructor
   * 
   * @param ManagerRegistry the doctrine manager registry
   */
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, Item::class);
    $this->entityManager = $this->getEntityManager();
  }

  /**
   * Add a item and persist in the database
   * 
   * @param Item $item the item
   */
  public function save(Item $item)
  {
    $this->entityManager->persist($item);
    $this->entityManager->flush();
  }

  /**
   * Remove a cart and delete from the database
   * 
   * @param Item $item the item
   */
  public function remove(Item $item)
  {
    $this->entityManager->remove($item);
    $this->entityManager->flush();
  }

}