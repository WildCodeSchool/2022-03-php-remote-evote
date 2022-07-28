<?php

namespace App\Services;

use App\Entity\College;
use App\Entity\Resolution;
use App\Repository\VoteRepository;
use App\Repository\VoterRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;

class ChartResults
{
    public function __construct(
        private VoteRepository $voteRepository,
        private VoterRepository $voterRepository
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
                $numAbstention = $votersRegistered - $totalVoters;
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
                // $numApprovedPercent = $vote['numApproved'] * 100 / $totalOfVoters;
                // $resultPercentage = round($numApprovedPercent * $vote['college']->getVotePercentage(), 2);
                $resultPercentage = round(100 * $vote['college']->getVotePercentage(), 2);
            } else {
                $isAdopted = false;
                // $numRejectedPercent = $totalOfVoters ? $vote['numRejected'] * 100 / $totalOfVoters : 0;
                // $resultPercentage = round($numRejectedPercent * $vote['college']->getVotePercentage(), 2);
                $resultPercentage = round(100 * $vote['college']->getVotePercentage(), 2);
            }
            $result[] = $this->formatResult($isAdopted, $resultPercentage);
        }
        usort($result, function ($result1, $result2) {
            return $result2['result'] <=> $result1['result'];
        });
        return $result[0] ?? $this->formatResult(false, 0);
    }

    public function getResultByVoter(Collection $resolutions): Collection
    {
        foreach ($resolutions as $resolution) {
            $numApproved = $this->calculateVotePercentageByAnswer($resolution, 'approved');
            $numRejected = $this->calculateVotePercentageByAnswer($resolution, 'rejected');
            $numAbstention = $this->calculateVotePercentageByAnswer($resolution, 'abstention');

            $voteResults = $this->formatVoteResult(
                $numApproved,
                $numRejected,
                $numAbstention
            );
            $resolution->setVoteResults($voteResults);
            $resolution->setFinalResult($this->calculateFinalResultByVoter($resolution));
        }
        return $resolutions;
    }

    public function calculateVotePercentageByAnswer(Resolution $resolution, string $answer): float
    {
        $percentageByVoter = $this->calculatePercentageByVoterNotGranted($resolution);
        $votes = $this->voteRepository->findBy([
            'resolution' => $resolution, 'answer' => $answer
        ]);
        $result = 0;
        foreach ($votes as $vote) {
            $result += $vote->getVoter()->getVotePercentage() > 0 ?
                $vote->getVoter()->getVotePercentage() :
                $percentageByVoter;
        }
        if ($answer === 'abstention') {
            $votersAbstained = $this->voterRepository->getVotersAbstained($resolution);
            foreach ($votersAbstained as $voter) {
                $result += $voter->getVotePercentage() > 0 ? $voter->getVotePercentage() : $percentageByVoter;
            }
        }
        return round($result * 100, 2);
    }

    private function calculatePercentageByVoterNotGranted(Resolution $resolution): float
    {
        $votersRegistered = count($resolution->getCampaign()->getVoters());
        $votersWithPercentage = $this->voterRepository->getVotersWithPercentagesGranted($resolution->getCampaign());

        $percentagesGranted = 0;
        foreach ($votersWithPercentage as $voter) {
            $percentagesGranted += $voter->getVotePercentage();
        }
        $votersNotGranted = $votersRegistered - count($votersWithPercentage);
        return  $votersNotGranted ?
            (1 - $percentagesGranted) / ($votersRegistered - count($votersWithPercentage)) :
            0;
    }

    /**
     * @todo
     */
    public function calculateFinalResultByVoter(Resolution $resolution): array
    {
        $rule = $resolution->getAdoptionRule();
        $vote = $resolution->getVoteResults();
        $totalOfVoters = $vote['numApproved'] + $vote['numRejected'];
        if (
            ($rule === 'simple-majority' && $vote['numApproved'] > $totalOfVoters / 2) ||
            ($rule === 'adoption-2/3' && $vote['numApproved'] > $totalOfVoters * 2 / 3 ) ||
            ($rule === 'adoption-3/4' && $vote['numApproved'] > $totalOfVoters * 3 / 4 )
        ) {
            $isAdopted = true;
            $resultPercentage = round($vote['numApproved'] * 100 / $totalOfVoters, 2);
        } else {
            $isAdopted = false;
            $resultPercentage = $totalOfVoters ? round($vote['numRejected'] * 200 / $totalOfVoters, 2) : 0;
        }

        return $this->formatResult($isAdopted, $resultPercentage);
    }

    private function formatVoteResult(
        int|float $numApproved,
        int|float $numRejected,
        int|float $numAbstention,
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
}
