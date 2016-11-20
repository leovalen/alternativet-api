<?php

namespace App\Console\Commands;

use Condorcet\Candidate;
use Condorcet\Election;
use Illuminate\Console\Command;
use Condorcet\Condorcet;


class CountElection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'election:count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Count an election';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $election = new Election();

        $candidates = [
            1 => new Candidate('Bjørnar Moxnes'),
            2 => new Candidate('Kari Elisabeth Kaski'),
            3 => new Candidate('Lan Marie Nguyen Berg'),
            4 => new Candidate('Abid Raja'),
            5 => new Candidate('Per Sandberg'),
        ];

        foreach ($candidates as $candidate) {
            $election->addCandidate($candidate);
        }

        $votes = [
            [$candidates[1], $candidates[3], $candidates[2]],
            [$candidates[1], $candidates[3], $candidates[4]],
            [$candidates[1], $candidates[2], $candidates[4]],
            [$candidates[1], $candidates[2]],
            [$candidates[1], $candidates[2],  $candidates[4]],
            [$candidates[5]],
            [$candidates[1], $candidates[2],  $candidates[5]],
            [$candidates[1], $candidates[5]],
            [$candidates[1]],
            [$candidates[1]],
            [$candidates[2], $candidates[1], $candidates[3], $candidates[4]],
            [$candidates[2], $candidates[3], $candidates[4], $candidates[1], $candidates[5]],
            [$candidates[5], $candidates[4],  $candidates[3]],
        ];

        foreach ($votes as $vote) {
            $election->addVote($vote);
        }

        $result = $election->getResult('RankedPairs');
        Condorcet::format($result);
    }
}
