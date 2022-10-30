<?php 

namespace App\Controller;

use App\Repository\VoteRepository;

class AddVote
{ 
    /**
     * @var VoteRepository
     */
    protected $voteRepository;

    public function __construct(VoteRepository $voteRepository)
    {
        $this->voteRepository = $voteRepository;
    }

    /**
     * @param int|null $userId
     * @param int|null $sellersId
     *
     * @throws Response
     */
    public function addVote($userId, $sellersId)
    {
        $this->voteRepository->castVote(1, $userId, $sellersId);
    }
}