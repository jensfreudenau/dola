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
use App\Models\HashLogin;
use App\Repositories\Announciator\AnnounciatorRepositoryInterface;
use App\Repositories\HashLogin\HashLoginRepositoryInterface;
use App\Traits\EmailTrait;

class AnnounciatorService
{
    /**
     * @var AnnounciatorRepositoryInterface
     */
    protected $announciatorRepository;
    /**
     * @var HashLoginRepositoryInterface
     */
    protected $hashLoginRepository;
    /**
     * @var ParticipatorService
     */
    protected $participatorService;
    /**
     * @var CompetitionService
     */
    protected $competitionService;

    protected $competition;
    protected $participators;
    protected $announciator;
    /**
     * @var AgeclassService
     */
    protected $ageclassService;
    /**
     * @var DisciplineService
     */
    protected $disciplineService;


    /**
     * AnnounciatorService constructor.
     * @param AnnounciatorRepositoryInterface $announciatorRepository
     * @param HashLoginRepositoryInterface $hashLoginRepository
     * @param ParticipatorService $participatorService
     * @param CompetitionService $competitionService
     * @param AgeclassService $ageclassService
     * @param DisciplineService $disciplineService
     */
    public function __construct(
            AnnounciatorRepositoryInterface $announciatorRepository,
            HashLoginRepositoryInterface $hashLoginRepository,
            ParticipatorService $participatorService,
            CompetitionService $competitionService,
            AgeclassService $ageclassService,
            DisciplineService $disciplineService
    ) {
        $this->announciatorRepository = $announciatorRepository;
        $this->hashLoginRepository = $hashLoginRepository;
        $this->participatorService    = $participatorService;
        $this->competitionService     = $competitionService;
        $this->ageclassService     = $ageclassService;
        $this->disciplineService     = $disciplineService;
    }


    /**
     * @param $all
     * @return mixed
     */
    public function create($all) {
        return $this->announciatorRepository->create($all);
    }

    use EmailTrait;
    /**
     * @param $request
     * @return Announciator
     */
    public function processAnnouncement($request): Announciator {
        //wk finden
        $this->competition = $this->competitionService->find($request->competition_id);

        //melder registrieren
        $this->announciator = $this->announciatorRepository->create($request->all());
        //teilnehmer abhängig vom Melder registrieren
        $this->participatorService->create($request, $this->announciator->id, $this->competition->season);
        $participators = $this->participatorService->getParticipators();

        //Teilnehmer Informationen für seltec generieren
        $this->participatorService->listParticipatorForSeltec($this->competition);
        //email abschicken mit Teilnehmerliste
        $this->sendEmailWithCsvFile($this->participatorService->getSeltecCollection(), $this->competition, $participators);
        //email an Melder schicken
        $this->sendEmailToAnnounciator($this->announciator, $this->competition);

        return $this->announciator;
    }

    /**
     * @param $announciatorId
     * @return array
     */
    public function listParticipators($announciatorId) {
        $announciator = $this->announciatorRepository->find($announciatorId);
        $competition  = $this->competitionService->find($announciator->competition_id);

        return (['announciator' => $announciator, 'competition' => $competition]);
    }

    /**
     * @param $competitionId
     * @return mixed
     */
    public function findCompetition($competitionId)
    {
        return $this->competitionService->find($competitionId);
    }

    /**
     * @return mixed
     */
    public function getCompetionSelectable() {
        $select = $this->competitionService->getSelectable();
        $select->prepend('Bitte ausw&auml;hlen', 0);

        return $select;
    }

    public function findHash($hash) {
         if($hashLogin = $this->hashLoginRepository->findBy('hash', $hash)){
             if($hashLogin->active) {
                 return $hashLogin;
             }
         }
         return false;
    }

    public function prepareAgeclasses($request)
    {
        $ageclassAr = [];
        foreach ($request->ageclass as $key=> $ageclass) {
            $ageclassAr[$key] = $this->ageclassService->getIdByLADV($ageclass);

        }
        $request->merge([
                'ageclass' => $ageclassAr
        ]);
        return $request;
    }

    public function prepareDisciplines($request)
    {
        $disciplineAr = [];
        foreach ($request->discipline as $key => $discipline) {
            $disciplineAr[$key] = $this->disciplineService->getIdByShortname($discipline);
        }
        $request->merge([
                'discipline' => $disciplineAr
        ]);
        return $request;

    }
}