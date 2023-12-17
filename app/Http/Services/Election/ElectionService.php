<?php

namespace App\Http\Services\Election;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\Position;
use App\Models\Vote;
use Symfony\Component\HttpFoundation\Response;

class ElectionService
{
    public function __construct(private Election $election, private Vote $vote, private Position $position, private Candidate $candidate)
    {

    }

    public function getElections()
    {
        $election = $this->election;
        $data = $election->getElections();
        return $data ?? [];
    }

    public function storeElectionData($data, $positions)
    {
        try {
            $election = $this->election;
            $userId = getUserInfo()->id;
            $data['created_by'] = $userId;
            if($election->createNewElectionRequest($data)) {
                return [Response::HTTP_OK, "Election Request Stored Successfully."];
            }
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage()];
        }
    }
}
