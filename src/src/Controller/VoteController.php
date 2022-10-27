<?php

namespace App\Controller;

use App\Controller\AddVote;
use App\Entity\Annonce;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class VoteController extends AbstractController
{
     /**
     * @param int $userId
     * @param int $sellersId
     *
     * @return Response
     */
    #[Route('/annonce/{id}/vote', name: 'app_vote_action', methods: ['GET'])]
    public function vote_action(Annonce $annonceSeller, AddVote $voteManager) 
    {
        $userId = $this->getUser();
        $sellerId = $annonceSeller->getIdUser();

        $voteManager->addVote($userId, $sellerId);

        return $this->redirectToRoute('app_home');
    }

}