<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ParseDataTrait;
use App\Models\Additional;
use App\Models\Competition;
use App\Http\Requests;
use App\Repositories\Competition\CompetitionRepositoryInterface;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class CompetitionsController extends Controller
{
    protected $competitionRepository;

    public function __construct(CompetitionRepositoryInterface $competitionRepository)
    {
        $this->competitionRepository = $competitionRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function track()
    {
        $season       = 'Bahn';
        $competitions = $this->competitionRepository->findBySeason($season);
        return view('front.competitions.track', compact('competitions', 'season'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function indoor()
    {
        $season       = 'Halle';
        $competitions = $this->competitionRepository->findBySeason($season);
        return view('front.competitions.track', compact('competitions', 'season'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function cross()
    {
        $competitions = $this->competitionRepository->findBySeason('cross');
        $season       = 'Strasse';
        return view('front.competitions.track', compact('competitions', 'season'));
    }

    public function details($id)
    {
        $competition = $this->competitionRepository->findById($id);
        $additionals = app()->make('CompetitionService')->getAdditionals($id);
        return view('front.competitions.details', compact('competition', 'additionals'));
    }

    use ParseDataTrait;
    public function archive()
    {
        $archives = app()->make('CompetitionService')->getArchive();
        return view('front.competitions.archive', compact('archives'));
    }
}
