<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 19.01.18
 * Time: 16:37
 */

namespace App\Services;

use App\Http\Controllers\Traits\ParseDataTrait;
use App\Models\Competition;
use App\Repositories\Additional\AdditionalRepositoryInterface;
use App\Repositories\Competition\CompetitionRepositoryInterface;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class CompetitionService
{
    protected $competitionRepository;
    protected $additionalRepository;

    public function __construct(CompetitionRepositoryInterface $competitionRepository, AdditionalRepositoryInterface $additionalRepository)
    {
        $this->competitionRepository = $competitionRepository;
        $this->additionalRepository  = $additionalRepository;
    }

    /**
     * @param $competitionId
     * @return mixed
     */
    public function getAdditionals($competitionId)
    {
        $additionals = $this->additionalRepository->findBy('competition_id', $competitionId);
        if ($additionals) {
            return $additionals->get();
        }
        return false;
    }

    public function getElapsed()
    {

    }

    use ParseDataTrait;

    public function getArchive()
    {
        $archives = array();
        foreach ($this->competitionRepository->seasons as $season) {
            $files             = Storage::files('public/' . Config::get('constants.Results') . '/' . $season);
            $archives[$season] = $this->listdir_by_date($files);
        }
        return $archives;
    }

    /**
     * @param $submitData
     * @param Competition $competition
     */
    public function saveAdditionals($submitData, Competition $competition)
    {
        if (!empty($submitData['keyvalue'])) {
            foreach ($submitData['keyvalue'] as $key => $keyVal) {
                $this->additionalRepository->updateOrCreate(
                    ['id'             => $key,
                     'competition_id' => $competition->id],
                    ['key'      => $keyVal['key'],
                     'value'    => $keyVal['value'],
                     'mnemonic' => $competition->season,
                    ]
                );
            }
        }
    }

    public function find($competition_id)
    {
        return $this->competitionRepository->find($competition_id);
    }

    public function getSelectFirst()
    {
        return Competition::where('submit_date', '>=', date('Y-m-d'))->where('register', '=', 0)->orderBy('start_date', 'asc')->limit(1)->get();
    }

    public function getSelectable()
    {
        return Competition::where('submit_date', '>=', date('Y-m-d'))->where('register', '=', 0)->orderBy('start_date', 'asc')->get()->pluck('header', 'id');
    }
}