<?php

namespace App\Http\Controllers;

use App\Repositories\Competition\CompetitionRepositoryInterface;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
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
    public function index()
    {
        $competitions = $this->competitionRepository->getFutured()->take(5);
        $lastcompetitions = $this->competitionRepository->getElapsed()->take(5);
        return view('front.home', compact('competitions','lastcompetitions'));
    }
}
