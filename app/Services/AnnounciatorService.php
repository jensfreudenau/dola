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
use App\Traits\EmailTrait;

class AnnounciatorService
{
    /**
     * @var AnnounciatorRepositoryInterface
     */
    protected $announciatorRepository;
    protected $participatorService;
    protected $competitionService;
    protected $competition;
    protected $participators;
    protected $announciator;

    /**
     * AnnounciatorService constructor.
     * @param AnnounciatorRepositoryInterface $announciatorRepository
     * @param ParticipatorService $participatorService
     * @param CompetitionService $competitionService
     */
    public function __construct(AnnounciatorRepositoryInterface $announciatorRepository, ParticipatorService $participatorService, CompetitionService $competitionService)
    {
        $this->announciatorRepository = $announciatorRepository;
        $this->participatorService = $participatorService;
        $this->competitionService = $competitionService;
    }



    /**
     * @param $all
     * @return mixed
     */
    public function create($all)
    {
        return $this->announciatorRepository->create($all);
    }

    use EmailTrait;
    /**
     * @param $request
     * @return Announciator
     */
    public function processAnnouncement($request)
    {
        //wk finden
        $this->competition = $this->competitionService->find($request->competition_id);


        //melder registrieren
        $this->announciator = $this->announciatorRepository->create($request->all());
        //teilnehmer abhängig vom Melder registrieren
        $this->participatorService->create($request, $this->announciator->id, $this->competition->season);
        $participators = $this->participatorService->getParticipators();

        //Teilnehmer Informationen für seltec generieren
        $this->participatorService->listParticipatorForSeltec($this->competition, $participators);
        //email abschicken mit Teilnehmerliste
        $this->sendEmailWithCsvFile($this->participatorService->getSeltecCollection(), $this->competition, $participators);
        //email an Melder schicken
        $this->sendEmailToAnnounciator($this->announciator, $this->competition);

        return $this->announciator;
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

    /**
     * @param $id
     * @return mixed
     */
    public function findCompetition($id)
    {
        return $this->competitionService->find($id);
    }

    /**
     * @return mixed
     */
    public function getCompetionSelectable()
    {
        return $this->competitionService->getSelectable();
    }

    /**
     * @return mixed
     */
    public function getSelectFirst()
    {
        return $this->competitionService->getSelectFirst();
    }

}