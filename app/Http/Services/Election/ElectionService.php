<?php

namespace App\Http\Services\Election;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\Position;
use App\Models\Vote;

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
}
