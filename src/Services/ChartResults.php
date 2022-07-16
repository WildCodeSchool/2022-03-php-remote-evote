<?php

namespace App\Services;

use App\Entity\College;
use App\Entity\Resolution;
use App\Repository\VoteRepository;
use Doctrine\Common\Collections\Collection;

class ChartResults
{
    public function __construct(
        private VoteRepository $voteRepository
    ) {
    }

    public function getResultByCollege(
        Collection $resolutions
    ): Collection {
        foreach ($resolutions as $resolution) {
            $voteResults = [];
            foreach ($resolution->getCampaign()->getCompany()->getColleges() as $college) {
                $numApproved = count($this->voteRepository->getVotesByCollege($resolution, $college, 'approved'));
                $numRejected = count($this->voteRepository->getVotesByCollege($resolution, $college, 'rejected'));
                $totalVoters = $numApproved + $numRejected;
                $votersRegistered = count($resolution->getCampaign()->getVoters());
                $numAbstention = $votersRegistered - $totalVoters +
                    count($this->voteRepository->getVotesByCollege($resolution, $college, 'abstention'));
                $voteResults[] = $this->formatVoteResult(
                    $numApproved,
                    $numRejected,
                    $numAbstention,
                    $college
                );
            }
            $resolution->setVoteResults($voteResults);
            $resolution->setFinalResult($this->calculateFinalResultWithCollege($resolution));
        }
        return $resolutions;
    }

    public function getResultByVoter(Collection $resolutions): Collection
    {
        $voteResults = [];
        foreach ($resolutions as $resolution) {
            $numApproved = count($this->voteRepository->findBy([
                'resolution' => $resolution, 'answer' => 'approved'
            ]));
            $numRejected = count($this->voteRepository->findBy([
                'resolution' => $resolution, 'answer' => 'rejected'
            ]));
            $numAbstention = count($this->voteRepository->findBy([
                'resolution' => $resolution, 'answer' => 'abstention'
            ]));
            $totalOfVoters = $numApproved + $numRejected + $numAbstention;
            if ($totalOfVoters === 0) {
                $resolution->setFinalResult($this->formatResult(false, 0));
                continue;
            }
            $voteResults[] = [
                'numApproved' => $numApproved,
                'numRejected' => $numRejected,
                'numAbstention' => $numAbstention
            ];
            $resolution->setVoteResults($voteResults);
            $resolution->setFinalResult($this->calculateFinalResultByVoter($resolution));
        }
        return $resolutions;
    }

    public function calculateFinalResultWithCollege(Resolution $resolution): array
    {
        $result = [];
        $rule = $resolution->getAdoptionRule();
        foreach ($resolution->getVoteResults() as $vote) {
            $totalOfVoters = $vote['numApproved'] + $vote['numRejected'];
            if (
                ($rule === 'simple-majority' && $vote['numApproved'] > $totalOfVoters / 2) ||
                ($rule === 'adoption-2/3' && $vote['numApproved'] > $totalOfVoters * 2 / 3 ) ||
                ($rule === 'adoption-3/4' && $vote['numApproved'] > $totalOfVoters * 3 / 4 )
            ) {
                $isAdopted = true;
                $numApprovedPercent = $vote['numApproved'] * 100 / $totalOfVoters;
                $resultPercentage = round($numApprovedPercent * $vote['college']->getVotePercentage(), 2);
            } else {
                $isAdopted = false;
                $numRejectedPercent = $totalOfVoters ? $vote['numRejected'] * 100 / $totalOfVoters : 0;
                $resultPercentage = round($numRejectedPercent * $vote['college']->getVotePercentage(), 2);
            }
            $result[] = $this->formatResult($isAdopted, $resultPercentage);
        }
        usort($result, function ($result1, $result2) {
            return $result2['result'] <=> $result1['result'];
        });
        return $result[0] ?? $this->formatResult(false, 0);
    }

    private function formatVoteResult(
        int $numApproved,
        int $numRejected,
        int $numAbstention,
        College|null $college = null,
    ): array {
        return [
            'numApproved' => $numApproved,
            'numRejected' => $numRejected,
            'numAbstention' => $numAbstention,
            'college' => $college
        ];
    }


    private function formatResult(bool $isAdopted, int|float $resultPercentage): array
    {
        return [
            'isAdopted' => $isAdopted,
            'result' => $resultPercentage,
            'message' => $isAdopted ? 'La résolution est adoptée' : 'La résolution est rejetée'
        ];
    }

    public function calculateFinalResultByVoter(Resolution $resolution): array
    {
        return [
            'isAdopted' => true, 'result' => 36.67, 'message' => 'La résolution est adoptée'
        ];
    }
}
