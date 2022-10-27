<?php

namespace App\Repository;

use App\Entity\Vote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;

/**
 * @extends ServiceEntityRepository<Vote>
 *
 * @method Vote|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vote|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vote[]    findAll()
 * @method Vote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vote::class);
    }

    private function userCanVote($userId): bool
    {
        if ($userId === null) {
            return false;
        }

        return true;
    }

    private function userHasAlreadyVoted($userId, $sellerId): bool
    {
        $vote = $this->findOneBy([
            'IdUser' => $userId,
            'idUserVote' => $sellerId,
        ]);

        if ($vote === null) {
            return false;
        }

        return true;
    }

    public function save(Vote $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Vote $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param int $voteValue
     * @param int|null $userId
     * @param int|null $sellersId
     *
     * @throws Response
     */
    public function castVote(int $voteValue, $userId, $sellersId)
    {
        if (!$this->userCanVote($userId)) {
            throw new Response('Vous ne pouvez pas voter pour ce vendeur car vous n\'êtes pas connecté');
        }
        else if($this->userHasAlreadyVoted($userId, $sellersId)) {
            $vote = $this->findOneBy([
                'IdUser' => $userId,
                'idUserVote' => $sellersId,
            ]);

            $this->remove($vote, true);
        }
        else {
            $vote = new Vote();
            $vote->setVote($voteValue);
            $vote->setIdUser($userId);
            $vote->setIdUserVote($sellersId);

            $this->save($vote, true);
        }
    }
}
