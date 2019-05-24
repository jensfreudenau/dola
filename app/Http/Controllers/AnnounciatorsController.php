<?php

namespace App\Http\Controllers;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use App\Services\AgeclassService;
use App\Services\AnnounciatorService;
use App\Services\CompetitionService;
use App\Services\DisciplineService;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;

class AnnounciatorsController extends Controller
{
    protected $announciatorService;
    protected $competitionRepository;
    /**
     * @var AgeclassService
     */
    private $ageclassService;
    /**
     * @var DisciplineService
     */
    private $disciplineService;
    /**
     * @var CompetitionService
     */
    private $competitionService;

    public function __construct(
        AnnounciatorService $announciatorService,
        AgeclassService $ageclassService,
        DisciplineService $disciplineService,
        CompetitionService $competitionService
    ) {
        $this->announciatorService = $announciatorService;
        $this->ageclassService     = $ageclassService;
        $this->disciplineService   = $disciplineService;
        $this->competitionService  = $competitionService;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $id
     * @return \Illuminate\View\View
     */
    public function create($id = false)
    {
        $competition = '';
        $disciplines = '';
        if (false !== $id) {
            $competition = $this->competitionService->find($id);
            if(null === $competition) {
                return Redirect::to('/', 301);
            }
            $disciplines = $this->disciplineService->getPluck($competition);
            $disciplineFormat = $this->disciplineService->getPluckFormat($competition);
        }
        $ageclasses        = $this->ageclassService->getAgeclassesPluck($competition);
        $competitionselect = $this->announciatorService->getCompetionSelectable();

        return view(
            'front.announciators.create',
            compact('competition', 'competitionselect', 'disciplines', 'ageclasses', 'disciplineFormat')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        try {
            $announciator = $this->announciatorService->processAnnouncement($request);
            $cookie       = Cookie::make('announciators_id', $announciator->id);

            return redirect()->action('AnnounciatorsController@listParticipator')->withCookie($cookie);
        } catch (\Exception $exception) {
            Bugsnag::notifyException($exception);
            if ($request->wantsJson()) {
                return response()->json(
                    [
                        'error' => true,
                        'message' => $exception->getMessageBag(),
                    ]
                );
            }
            $message = $exception->getMessage();

            return Redirect::back()->withInput()->withErrors(array('user_name' => $message));
        }
    }

    public function listParticipator()
    {
        $announciatorId = Cookie::get('announciators_id', 0);
        if (0 == $announciatorId) {
            return redirect()->action('HomeController@index');
        }
        $list = $this->announciatorService->listParticipators($announciatorId);

        return view('front.announciators.list', compact('list'));
    }
}
