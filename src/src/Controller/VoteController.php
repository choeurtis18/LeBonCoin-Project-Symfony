<?php

namespace App\Controller;

use App\Controller\AddVote;
use App\Entity\Annonce;
use App\Entity\User;
use App\Entity\Vote;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class VoteControlller extends AbstractController
{
    /**
     * @var AddVote
     */
    private $voteManager;

    /**
     * @var Annonce
     */
    private $seller;

     /**
     * @var User
     */
    private $user;

    /**
     * @var Vote
     */
    private $vote;

    public function __construct (
        Annonce $seller,
        User $user,
        AddVote $voteManager,
        Vote $vote
    ) {
        $this->seller = $seller;
        $this->user = $user;
        $this->vote = $vote;
        $this->voteManager = $voteManager;
    }

     /**
     * @param int $userId
     * @param int $sellersId
     *
     * @return Response
     */
    public function upvoteAction(
        int $userId,
        int $sellerId,
    ) {
        $userId = $this->user->getId();
        $sellerId = $this->seller->getIdUser();

        return $this->voteManager->addVote($userId, $sellerId);
    }

     /**
     * @param int $userId
     * @param int $sellersId
     *
     * @return Response
     */
    public function downvoteAction(
        int $userId,
        int $sellerId,
    ) {
        $userId = $this->user->getId();
        $sellerId = $this->seller->getIdUser();

        return $this->voteManager->removeVote($userId, $sellerId);
    }

    public function renderVoteAction(
        int $userId,
        int $sellerId,
    ) {
        $userId = $this->user->getId();
        $sellerId = $this->seller->getIdUser();

        $vote = $this->vote->getVote($userId, $sellerId);

        return $this->render('vote.html.twig', [
            'vote' => $vote,
        ]);
    }

}