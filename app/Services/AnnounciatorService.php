<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 19.01.18
 * Time: 15:18
 */

namespace App\Services;

use App\Mail\EnrolReceived;
use App\Models\Announciator;
use App\Models\Competition;
use App\Repositories\Announciator\AnnounciatorRepositoryInterface;
use Illuminate\Support\Facades\Mail;

class AnnounciatorService
{
    /**
     * @var array
     */
    protected $rules = [
        'flightNumber'       => 'required',
        'status'             => 'required|flightstatus',
        'arrival.datetime'   => 'required|date',
        'arrival.iataCode'   => 'required',
        'departure.datetime' => 'required|date',
        'departure.iataCode' => 'required',
    ];

    /**
     * @var AnnounciatorRepositoryInterface
     */
    protected $announciatorRepository;
    protected $participatorService;
    protected $competitionService;

    /**
     * AnnounciatorService constructor.
     * @param AnnounciatorRepositoryInterface $announciatorRepository
     * @param ParticipatorService $participatorService
     */
    public function __construct(AnnounciatorRepositoryInterface $announciatorRepository, ParticipatorService $participatorService, CompetitionService $competitionService)
    {
        $this->announciatorRepository = $announciatorRepository;
        $this->participatorService = $participatorService;
        $this->competitionService = $competitionService;
    }

    /**
     * @param $participators
     * @param Competition $competition
     */
    public function sendEmailWithCsvFile($participators, Competition $competition)
    {
        $list = array();
        foreach ($participators as $key => $participator) {
            $list[$key]['BIB']        = 1;
            $list[$key]['Code']       = '';
            $list[$key]['Event']      = $competition->header;
            $list[$key]['Team']       = $participator->Announciator->clubname;
            $list[$key]['telephone']  = $participator->Announciator->telephone;
            $list[$key]['street']     = $participator->Announciator->street;
            $list[$key]['city']       = $participator->Announciator->city;
            $list[$key]['Forename']   = $participator->prename;
            $list[$key]['Name']       = $participator->lastname;
            $list[$key]['Value']      = $participator->best_time;
            $list[$key]['YOB']        = $participator->birthyear;
            $list[$key]['discipline'] = $participator->discipline->dlv;
            $list[$key]['ageclass']   = $participator->ageclass->dlv;
        }
        $columnHeaders = array("BIB", "Code", "Event", "Team", "Telefon", "Straße", "Stadt", "Vorname", "Nachname", "Value", "YOB", "discipline", "ageclass");
        $filename      = 'teilnehmer.csv';
        $file          = fopen('php://temp', 'w+');
        fputcsv($file, $columnHeaders, ",", '"');
        foreach ($list as $row) {
            fputcsv($file, $row, ",", '"');
        }
        rewind($file);
        Mail::send('emails.registration', ['competition' => $competition, 'announciator' => $participators[0]->Announciator], function ($message) use ($file, $filename, $competition, $participators) {
            $message->to($competition->organizer->address->email)
                    ->from($participators[0]->Announciator->email)
                    ->subject('Teilnehmerliste ' . $competition->header);
            $message->attachData(stream_get_contents($file), $filename);
        });
        fclose($file);
    }

    /**
     * @param $all
     * @return mixed
     */
    public function create($all)
    {
        return $this->announciatorRepository->create($all);
    }

    /**
     * @param $request
     * @return Announciator
     */
    public function processAnnouncement($request)
    {
        //melder registrieren
        $announciator = $this->announciatorRepository->create($request->toArray());
        //teilnehmer abhängig vom Melder registrieren
        $this->participatorService->create($request, $announciator->id);
        //wk finden
        $competition = $this->competitionService->find($request->competition_id);
        //email abschicken mit Teilnehmerliste
        $this->sendEmailWithCsvFile($announciator->Participator, $competition);
        //email an Melder schicken
        $this->sendEmailToAnnounciator($announciator, $competition);

        return $announciator;
    }

    protected function sendEmailToAnnounciator($announciator, $competition)
    {
        Mail::send(new EnrolReceived($announciator, $competition));
    }

    /**
     * @param $id
     * @return array
     */
    public function listParticipators($id)
    {
        $announciator = $this->announciatorRepository->find($id);
        $competition = $this->competitionService->find($announciator->competition_id);
        return (['announciator' => $announciator, 'competition' => $competition]);
    }

    public function findCompetition($id)
    {
        return $this->competitionService->find($id);
    }

    public function getCompetionSelectable()
    {
        return $this->competitionService->getSelectable();
    }

    public function getSelectFirst()
    {
        return $this->competitionService->getSelectFirst();
    }
}