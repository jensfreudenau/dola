<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 05.01.18
 * Time: 16:29
 */

namespace App\Services;

use App\Helpers\Utils;
use App\Repositories\Participator\ParticipatorRepositoryInterface;

class ParticipatorService {
    /**
     * @var ParticipatorRepositoryInterface
     */
    protected $participatorRepository;
    /**
     * @var array $participators
     */
    protected $participators;
    protected $seltecCollection = [];

    public function __construct(ParticipatorRepositoryInterface $participatorRepository) {
        $this->participatorRepository = $participatorRepository;
    }

    /**
     * @param $request
     * @param $announciatorId
     * @param $season
     */
    public function create($request, $announciatorId, $season) {
        $participators = $this->createParticipatorPerDiscipline($request, $season);

        foreach ($participators as $participator) {
            $participator['announciator_id'] = $announciatorId;
            $this->participators[]           = $this->participatorRepository->create($participator);
        }
    }

    private function createParticipatorPerDiscipline($request, $season): array {
        foreach ($request->discipline as $disciplineKey => $discipline) {
            foreach ($discipline as $keyDisci => $disciplineId) {
                $participator[$keyDisci]['prename']     = $request->vorname[$disciplineKey];
                $participator[$keyDisci]['lastname']    = $request->nachname[$disciplineKey];
                $participator[$keyDisci]['birthyear']   = $request->jahrgang[$disciplineKey];
                $participator[$keyDisci]['ageclass_id'] = $request->ageclass[$disciplineKey];
                $participator[$keyDisci]['clubname']    = $request->clubname[$disciplineKey];

                if ($season == 'cross') {
                    $participator[$keyDisci]['discipline_cross'] = $disciplineId;
                    $participator[$keyDisci]['discipline_id']    = null;
                } else {
                    $participator[$keyDisci]['discipline_cross'] = null;
                    $participator[$keyDisci]['discipline_id']    = $disciplineId;
                }
                $participator[$keyDisci]['best_time'] = $request->bestzeit[$disciplineKey][$keyDisci];
                $participators[]                      = $participator[$keyDisci];
            }
        }

        return $participators;
    }

    /**
     * convert participator information into seltec reading
     * @param $competition
     */
    public function listParticipatorForSeltec($competition)
    {
        foreach ($this->participators as $key => $participator) {
            $this->seltecCollection[$key]['Forename']         = $participator->prename;
            $this->seltecCollection[$key]['Name']             = $participator->lastname;
            $this->seltecCollection[$key]['BIB']              = 1;
            $this->seltecCollection[$key]['Team']             = $participator->clubname;
            $this->seltecCollection[$key]['Ageclass']         = (is_object($participator->ageclass) ? $participator->ageclass->ladv : $participator->ageclass_id);
            $this->seltecCollection[$key]['Sex']              = is_object($participator->ageclass) ? Utils::first($participator->ageclass->ladv) : '';
            $this->seltecCollection[$key]['Discipline']       = (is_object($participator->discipline) ? $participator->discipline->dlv : $participator->discipline_cross);
            $this->seltecCollection[$key]['Value']            = $participator->best_time;
            $this->seltecCollection[$key]['Event']            = $competition->header;
            $this->seltecCollection[$key]['AnnounciatorName'] = $participator->Announciator->name;
            $this->seltecCollection[$key]['Email']            = $participator->Announciator->email;
            $this->seltecCollection[$key]['Telephone']        = $participator->Announciator->telephone;
            $this->seltecCollection[$key]['Street']           = $participator->Announciator->street;
            $this->seltecCollection[$key]['City']             = $participator->Announciator->city;
            $this->seltecCollection[$key]['Code']             = '';
            $this->seltecCollection[$key]['YOB']              = $participator->birthyear;
        }
    }

    /**
     * @return array seltecCollection
     */
    public function getSeltecCollection() {
        return $this->seltecCollection;
    }

    /**
     * @return mixed
     */
    public function getParticipators() {
        return $this->participators;
    }

    public function sendCsvFile($competition) {
        $this->participators = $competition->participators;
        $this->listParticipatorForSeltec($competition);
        $headers = [
                'Cache-Control'     => 'must-revalidate, post-check=0, pre-check=0'
            , 'Content-type'        => 'text/csv'
            , 'Content-Disposition' => 'attachment; filename=participators.csv'
            , 'Expires'             => '0'
            , 'Pragma'              => 'public',
        ];
        $list    = $this->getSeltecCollection();
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