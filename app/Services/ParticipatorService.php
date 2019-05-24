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
use Illuminate\Support\Str;

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
        $participators = [];
        foreach ($request->discipline as $disciplineKey => $discipline) {
            foreach ($discipline as $participatorNumber => $disciplineId) {
                $participator[$participatorNumber]['prename']     = $request->vorname[$disciplineKey];
                $participator[$participatorNumber]['lastname']    = $request->nachname[$disciplineKey];
                $participator[$participatorNumber]['birthyear']   = $request->jahrgang[$disciplineKey];
                $participator[$participatorNumber]['ageclass_id'] = $request->ageclass[$disciplineKey];
                $participator[$participatorNumber]['clubname']    = $request->clubname[$disciplineKey];

                if ($season == 'cross') {
                    $participator[$participatorNumber]['discipline_cross'] = $disciplineId;
                    $participator[$participatorNumber]['discipline_id']    = null;
                } else {
                    $participator[$participatorNumber]['discipline_cross'] = null;
                    $participator[$participatorNumber]['discipline_id']    = $disciplineId;
                }
                $participator[$participatorNumber]['best_time'] = $this->besttime($request, $disciplineKey, $participatorNumber);
                $participators[]                                = $participator[$participatorNumber];
            }
        }
        return $participators;
    }

    /**
     * @param $request
     * @param $disciplineKey
     * @param $participatorNumber
     * @return string
     */
    private function besttime($request, $disciplineKey, $participatorNumber) : string
    {
        //Zeit
        if ($request->bestzeit_h[$disciplineKey][$participatorNumber] != null
                || $request->bestzeit_m[$disciplineKey][$participatorNumber] != null
                || $request->bestzeit_s[$disciplineKey][$participatorNumber] != null
                || $request->bestzeit_ms[$disciplineKey][$participatorNumber] != null
        ) {
            return $this->handleTime($request->bestzeit_h, $request->bestzeit_m, $request->bestzeit_s, $request->bestzeit_ms, $participatorNumber, $disciplineKey);
        }

        //Metrisch
        if ($request->bestweite_m[$disciplineKey][$participatorNumber] != null
                || $request->bestweite_cm[$disciplineKey][$participatorNumber] != null
        ) {
            return $this->handleMetric($request->bestweite_m, $request->bestweite_cm, $participatorNumber, $disciplineKey);
        }
        //Punkte
        if ($request->bestweite_punkte[$disciplineKey][$participatorNumber] != null) {
            return $request->bestweite_punkte;
        }

        return '0';
    }

    /**
     * @param $meter
     * @param $centimeter
     * @param $participatorNumber
     * @param $disciplineKey
     * @return string
     */
    private function handleMetric($meter, $centimeter, $participatorNumber, $disciplineKey) : string
    {
        $metric = 'M,CM';
        $M      = 0;
        $CM     = 0;
        if ($meter[$disciplineKey][$participatorNumber] != null) {
            $M = $meter[$disciplineKey][$participatorNumber];
        }
        if ($centimeter[$disciplineKey][$participatorNumber] != null) {
            $CM = $centimeter[$disciplineKey][$participatorNumber];
        }
        $metric = Str::replaceFirst('M', $M, $metric);
        $metric = Str::replaceFirst('CM', $CM, $metric);

        return $metric;
    }

    /**
     * @param $hour
     * @param $minute
     * @param $seconds
     * @param $millis
     * @param $participatorNumber
     * @param $disciplineKey
     * @return string
     */
    private function handleTime($hour, $minute, $seconds, $millis, $participatorNumber, $disciplineKey) : string
    {
        $time = 'H:M:S,MS';
        $h    = '00';
        if ($hour[$disciplineKey][$participatorNumber] != null) {
            $h = $hour[$disciplineKey][$participatorNumber];
        }
        $min = '00';
        if ($minute[$disciplineKey][$participatorNumber] != null) {
            $min = $minute[$disciplineKey][$participatorNumber];
        }
        $sec = '00';
        if ($seconds[$disciplineKey][$participatorNumber] != null) {
            $sec = $seconds[$disciplineKey][$participatorNumber];
        }
        $ms = '00';
        if ($millis[$disciplineKey][$participatorNumber] != null) {
            $ms = $millis[$disciplineKey][$participatorNumber];
        }
        $time = Str::replaceFirst('H',  $h,   $time);
        $time = Str::replaceFirst('M',  $min, $time);
        $time = Str::replaceFirst('S',  $sec, $time);
        $time = Str::replaceFirst('MS', $ms,  $time);

        return $time;
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