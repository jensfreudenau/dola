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
        $competition = $competition = $this->competitionRepository->findById($id);
        $additionals = Additional::where('external_id', '=', $competition->id)->get();
        return view('front.competitions.details', compact('competition', 'additionals'));
    }

    use ParseDataTrait;
    public function archive()
    {
        foreach ($this->competitionRepository->seasons as $season) {
            $path              = 'public/' . Config::get('constants.Results') . '/' . $season;
            $files             = Storage::files($path);
            $archives[$season] = $this->listdir_by_date($files);
        }
        return view('front.competitions.archive', compact('archives'));
    }
}
