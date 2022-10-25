<?php 

namespace App\Controller;

use App\Entity\User;
use App\Entity\Vote;
use App\Repository\VoteRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;

class AddVote
{ 
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var User
     */
    private $user;

    /**
     * @var VoteRepository
     */
    protected $voteRepository;

    public function __construct(
        EntityManager $entityManager,
        User $user,
        VoteRepository $voteRepository,
    )
    {
        $this->entityManager = $entityManager;
        $this->user = $user;
        $this->voteRepository = $voteRepository;
    }

    public function userCanVote(): bool
    {
        $vote = $this->voteRepository->findOneBy([
            'user' => $this->user,
        ]);

        if ($vote instanceof Vote) {
            return false;
        }

        return true;
    }

    /**
     * @param int $voteValue
     * @param int|null $userId
     * @param int|null $sellersId
     *
     * @throws Response
     */
    protected function castVote(int $voteValue, $userId, $sellersId)
    {
        if (!$this->userCanVote()) {
            throw new Response('Vous ne pouvez pas voter pour ce vendeur car vous n\'êtes pas connecté');
        }
        else {
            $vote = new Vote();
            $vote->setVote($voteValue);
            $vote->setIdUserVote($userId);
            $vote->setIdUserVote($sellersId);

            $this->entityManager->persist($vote);
            $this->entityManager->flush();
        }
    }

    /**
     * @param int|null $userId
     * @param int|null $sellersId
     *
     * @throws Response
     */
    public function addVote($userId, $sellersId)
    {
        $this->castVote(1, $userId, $sellersId);
    }

    /**
     * @param int|null $userId
     * @param int|null $sellersId
     *
     * @throws Response
     */
    public function removeVote($userId, $sellersId)
    {
        $this->castVote(0, $userId, $sellersId);
    }

    /**
     * @param int $sellersId
     */
    public function getTotalVotes($sellersId): int
    {
        $votes = $this->voteRepository->findBy(['idUserVote' => $sellersId]);
        $totalVotes = 0;
        foreach ($votes as $vote) {
            $totalVotes += $vote->isVote();
        }

        return $totalVotes;
    }

}