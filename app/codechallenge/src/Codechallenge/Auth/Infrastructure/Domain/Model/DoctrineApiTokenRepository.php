<?php

namespace App\Codechallenge\Auth\Infrastructure\Domain\Model;

//use Doctrine\ORM\EntityManagerInterface;

use App\Codechallenge\Auth\Domain\Model\ApiTokenRepository;
use App\Codechallenge\Auth\Domain\Model\ApiToken;
use App\Codechallenge\Auth\Domain\Model\ApiTokenId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository for manage security access tokens for api access using Doctrine ORM
 */
class DoctrineApiTokenRepository extends ServiceEntityRepository implements ApiTokenRepository
{
  protected $em;
  private $entityManager;

  /**
   * Constructor
   * 
   * @param ManagerRegistry $registry
   */
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, ApiToken::class);
    $this->entityManager = $this->getEntityManager();
  }

  /**
   * Adds a token and persist in the database
   * 
   * @param ApiToken $apiToken
   */
  public function save(ApiToken $apiToken)
  {
    $this->entityManager->persist($apiToken);
    $this->entityManager->flush();
  }

  /**
   * Removes a token and delete from the database
   * 
   * @param ApiToken $apitoken
   */
  public function remove(ApiToken $apiToken)
  {
    $this->entityManager->remove($apiToken);
    $this->entityManager->flush();
  }

  /**
   * Retrieves a token of the given id
   * 
   * @param ApiTokenId the id of the token
   * @return ApiToken|null the ApiToken with requested id
   */
  public function tokenOfId(ApiTokenId $apiTokenId) : ApiToken|null
  {
    return $this->entityManager->find('App\Codechallenge\Auth\Domain\Model\ApiToken', $apiTokenId);
  }

  /**
   * Retrieves a token of the given token string
   * 
   * @param string the token string of the token
   * @return ApiToken|null
   */
  public function tokenOfToken(string $token) : ApiToken|null
  {
      return $this->createQueryBuilder('t')
          ->andWhere('t.token = :token')
          ->setParameter('token', $token)
          ->getQuery()
          ->getOneOrNullResult()
      ;
  }

  /**
   * Gets a new unique ApiToken id
   * 
   * @return ApiTokenId
   */
  public function nextIdentity()
  {
    return new ApiTokenId();
  }
}