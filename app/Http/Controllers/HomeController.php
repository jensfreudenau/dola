<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Http\Requests;
use App\Repositories\Competition\CompetitionRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

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
        foreach ($lastcompetitions as $lastcompetition) {
            $lastcompetition->ageclasses = $lastcompetition->reduceClasses();
        }
        return view('front.home', compact('competitions','lastcompetitions'));
    }
}
