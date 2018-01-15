<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 11.01.18
 * Time: 13:44
 */

namespace App\Services;
use App\Http\Controllers\Traits\ParseDataTrait;
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
        $this->additionalRepository = $additionalRepository;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getAdditionals($id)
    {
        $additionals = $this->additionalRepository->findBy('competition_id', $id);
        if($additionals) {
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
}