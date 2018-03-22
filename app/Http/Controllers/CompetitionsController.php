<?php

namespace App\Http\Controllers;


use App\Services\CompetitionService;
use Illuminate\Support\Facades\Request;


class CompetitionsController extends Controller
{
    protected $competitionRepository;

    public function __construct(CompetitionService $competitionService)
    {
        $this->competitionService = $competitionService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function track()
    {
        $season       = 'Bahn';
        $competitions = $this->competitionService->findBySeason($season);
        foreach ($competitions as $competition) {
            $competition->ageclasses =$competition->reduceClasses();
        }
        return view('front.competitions.list', compact('competitions', 'season'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function indoor()
    {
        $season       = 'Halle';
        $competitions = $this->competitionService->findBySeason($season);
        foreach ($competitions as $competition) {
            $competition->ageclasses =$competition->reduceClasses();
        }
        return view('front.competitions.list', compact('competitions', 'season'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function cross()
    {
        $competitions = $this->competitionService->findBySeason('cross');
        foreach ($competitions as $competition) {
            $competition->ageclasses =$competition->reduceClasses();
        }
        $season       = 'Strasse';
        return view('front.competitions.list', compact('competitions', 'season'));
    }

    public function details($id)
    {
        $competition = $this->competitionService->find($id);
        if (Request::wantsJson()) {
            $competition->name= $competition->organizer->address->name;
            $competition->classes= $competition->Disciplines;
            return response()->json($competition);
        }

        $additionals = app()->make('CompetitionService')->getAdditionals($id);
        return view('front.competitions.details', compact('competition', 'additionals'));
    }


    public function archive()
    {
        $archives = $this->competitionService->getArchive();
        return view('front.competitions.archive', compact('archives'));
    }

    public function showByClubId($id)
    {
        $competitions = $this->competitionService->findByClubId($id);
        foreach ($competitions as $competition) {
            $competition->Disciplines;
            $competition->Ageclasses;
        }
        return response()->json($competitions);
    }
}
