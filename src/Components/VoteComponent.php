<?php

namespace App\Components;

use App\Entity\Vote;
use App\Entity\Voter;
use App\Entity\Resolution;
use App\Repository\ResolutionRepository;
use App\Repository\VoteRepository;
use App\Repository\VoterRepository;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent('vote')]
class VoteComponent
{
    use DefaultActionTrait;

    #[LiveProp]
    public Resolution $resolution;

    #[LiveProp]
    public Voter $voter;

    public function __construct(
        private VoteRepository $voteRepository,
    ) {
    }

    #[LiveAction]
    public function vote(#[LiveArg] string $answer): void
    {
        $vote = new Vote();
        $vote->setAnswer($answer);
        $vote->setResolution($this->resolution);
        $vote->setVoter($this->voter);

        $this->voteRepository->add($vote, true);
    }

    public function getHasVoted(): bool
    {
        //retourne le résultat de la requête : si l'utilisateur a déjà voté pour cette résolution ?
        return (bool) $this->voteRepository->findOneBy(['voter' => $this->voter, 'resolution' => $this->resolution]);
    }
}
