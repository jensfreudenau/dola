<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Record;
use App\Models\Best;
use App\Repositories\Record\RecordRepositoryInterface;
use Illuminate\Http\Request;
use Session;

class RecordsController extends Controller
{
    protected $recordRepository;

    public function __construct(RecordRepositoryInterface $recordRepository)
    {
        $this->recordRepository = $recordRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $kreisFemales = $this->recordRepository->getKreisRecords('f');
        $kreisMales   = $this->recordRepository->getKreisRecords('m');
        $females      = $this->recordRepository->getNonKreisRecords('f');
        $males        = $this->recordRepository->getNonKreisRecords('m');
        return view('front.records.index', compact('kreisFemales', 'kreisMales', 'females', 'males'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param $mnemonic
     * @return \Illuminate\View\View
     */
    public function record($mnemonic)
    {
        if(is_numeric($mnemonic))
        {
            return redirect('/records/record',301);
        }
        $record = $this->recordRepository->findByMnemonic($mnemonic);
        return view('front.records.detail', compact('record'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function best()
    {
            $bestYears  = Best::select('year')->where('sex', '=', 'f')->orderBy('year', 'desc')->distinct('year')->get();
            foreach ($bestYears as $bestYear) {
                $bestsFemale[]  = Best::select('year', 'filename')->where('sex', '=', 'f')->where('year', '=', $bestYear['year'])->orderBy('created_at', 'desc')->first();
            }
            $bestYears  = Best::select('year')->where('sex', '=', 'm')->orderBy('year', 'desc')->distinct('year')->get();
            foreach ($bestYears as $bestYear) {
                $bestsMale[]  = Best::select('year', 'filename')->where('sex', '=', 'm')->where('year', '=', $bestYear['year'])->orderBy('created_at', 'desc')->first();
            }
        return view('front.records.best', compact('bestsFemale','bestsMale'));
    }
}
