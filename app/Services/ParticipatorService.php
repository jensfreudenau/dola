<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 05.01.18
 * Time: 16:29
 */

namespace App\Services;

use App\Repositories\Participator\ParticipatorRepositoryInterface;

class ParticipatorService
{
    /**
     * @var ParticipatorRepositoryInterface
     */
    protected $participatorRepository;
    /**
     * @var array $participators
     */
    protected $participators;
    protected $seltecCollection = [];

    public function __construct(ParticipatorRepositoryInterface $participatorRepository)
    {
        $this->participatorRepository = $participatorRepository;
    }

    /**
     * @param $request
     * @param $announciatorId
     * @param $season
     */
    public function create($request, $announciatorId, $season)
    {
        $participators = [];
        foreach ($request->vorname as $key => $item) {
            $participators[$key]['prename'] = $item;
        }
        foreach ($request->nachname as $key => $item) {
            $participators[$key]['lastname'] = $item;
        }
        foreach ($request->jahrgang as $key => $item) {
            $participators[$key]['birthyear'] = $item;
        }
        foreach ($request->ageclass as $key => $item) {
            $participators[$key]['ageclass_id'] = $item;
        }
        foreach ($request->clubname as $key => $item) {
            $participators[$key]['clubname'] = $item;
        }
        foreach ($request->discipline as $key => $item) {
            if($season == 'cross') {
                $participators[$key]['discipline_cross'] = $item;
                $participators[$key]['discipline_id'] = null;
            }
            else {
                $participators[$key]['discipline_cross'] = null;
                $participators[$key]['discipline_id'] = $item;
            }
        }
        foreach ($request->bestzeit as $key => $item) {
            $participators[$key]['best_time'] = $item;
        }

        foreach ($participators as $participator) {
            $participator['announciator_id'] = $announciatorId;
            $this->participators[] = $this->participatorRepository->create($participator);
        }
    }

    /**
     * convert participator information into seltec reading
     * @param $competition
     */
    public function listParticipatorForSeltec($competition)
    {
        foreach ($this->participators as $key => $participator) {
            $this->seltecCollection[$key]['BIB']        = 1;
            $this->seltecCollection[$key]['Code']       = '';
            $this->seltecCollection[$key]['Event']      = $competition->header;
            $this->seltecCollection[$key]['Team']       = $participator->clubname;
            $this->seltecCollection[$key]['telephone']  = $participator->Announciator->telephone;
            $this->seltecCollection[$key]['street']     = $participator->Announciator->street;
            $this->seltecCollection[$key]['city']       = $participator->Announciator->city;
            $this->seltecCollection[$key]['Forename']   = $participator->prename;
            $this->seltecCollection[$key]['Name']       = $participator->lastname;
            $this->seltecCollection[$key]['Value']      = $participator->best_time;
            $this->seltecCollection[$key]['YOB']        = $participator->birthyear;
            $this->seltecCollection[$key]['discipline'] = (is_object($participator->discipline) ? $participator->discipline->ladv : $participator->discipline_cross);
            $this->seltecCollection[$key]['ageclass']   = (is_object($participator->ageclass) ? $participator->ageclass->dlv : $participator->ageclass_id);
        }
    }

    /**
     * @return array seltecCollection
     */
    public function getSeltecCollection()
    {
        return $this->seltecCollection;
    }

    /**
     * @return mixed
     */
    public function getParticipators()
    {
        return $this->participators;
    }

    public function sendCsvFile($competition)
    {
        $this->participators = $competition->participators;
        $this->listParticipatorForSeltec($competition);
        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0'
            , 'Content-type' => 'text/csv'
            , 'Content-Disposition' => 'attachment; filename=participators.csv'
            , 'Expires' => '0'
            , 'Pragma' => 'public'
        ];
        $list = $this->getSeltecCollection();
        # add headers for each column in the CSV download
        array_unshift($list, array_keys($list[0]));
        $callback = function () use ($list) {
            $FH = fopen('php://output', 'w');
            foreach ($list as $row) {
                fputcsv($FH, $row);
            }
            fclose($FH);
        };
        return response()->stream($callback, 200, $headers);
    }
}