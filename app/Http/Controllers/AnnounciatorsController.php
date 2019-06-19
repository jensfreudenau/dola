<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use App\Traits\FileUploadTrait;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use App\Services\AgeclassService;
use App\Services\AnnounciatorService;
use App\Services\DisciplineService;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AnnounciatorsController extends Controller
{
    /**
     * @var AnnounciatorService
     */
    protected $announciatorService;

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
            DisciplineService $disciplineService
    ) {
        $this->announciatorService = $announciatorService;
        $this->ageclassService     = $ageclassService;
        $this->disciplineService   = $disciplineService;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $id
     * @return \Illuminate\View\View
     */
    public function create($id = false)
    {
        $competition      = '';
        $disciplines      = '';
        $disciplineFormat = '';
        if (false !== $id) {
            $competition = $this->announciatorService->findCompetition($id);
            if (null === $competition) {
                return Redirect::to('/', 301);
            }
            $disciplines      = $this->disciplineService->getPluck($competition);
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
            $announciator = $this->announciatorService->processAnnouncement($request, false);
            $cookie       = Cookie::make('announciators_id', $announciator->id);

            return redirect()->action('AnnounciatorsController@listParticipator')->withCookie($cookie);
        } catch (\Exception $exception) {
            Bugsnag::notifyException($exception);
            if ($request->wantsJson()) {
                return response()->json(
                        [
                                'error'   => true,
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

    public function mass($hash)
    {
        if (!$this->announciatorService->findHash($hash)) {
            return redirect()->route('home');
        }
        $competitionselect = $this->announciatorService->getCompetionSelectable();

        return view('front.announciators.mass', compact('competitionselect', 'hash'));


    }

    public function massupload(Request $request)
    {
        $announciator = $this->announciatorService->findHash($request->hash);
        if (!$announciator) {
            return redirect()->route('home');
        }
        if (0 == $request->competition_id) {
            return Redirect::to('announciators/mass/'.$request->hash, 301);
        }
        $competition            = $this->announciatorService->findCompetition($request->competition_id);
        $disciplines            = $this->disciplineService->getPluck($competition);
        $ageclasses             = $this->ageclassService->getAgeclassesPluck($competition);
        $ageclassesJson         = $this->ageclassService->createJson($competition);
        $disciplinesJson        = $this->disciplineService->createJson($competition);
        $personalBestFormatJson = $this->disciplineService->createPersonalBestJson($competition);

        return view('front.announciators.massupload', compact('personalBestFormatJson', 'disciplines', 'ageclasses', 'competition', 'announciator', 'ageclassesJson', 'disciplinesJson'));

    }



    public function masssave(Request $request)
    {
        $competition = $this->announciatorService->findCompetition($request->competition_id);
        foreach ($competition->disciplines as $discipline) {
            $this->disciplines[] = $discipline->shortname;
        }
        foreach ($competition->ageclasses as $ageclass) {
            $this->ageclasses[] = $ageclass->ladv;
        }

        try {
            $request      = $this->announciatorService->prepareAgeclasses($request);
            $request      = $this->announciatorService->prepareDisciplines($request);

            $announciator = $this->announciatorService->processAnnouncement($request, true);
            $cookie       = Cookie::make('announciators_id', $announciator->id);

             return redirect()->action('AnnounciatorsController@listParticipator')->withCookie($cookie);
         } catch (\Exception $exception) {
             Bugsnag::notifyException($exception);
             if ($request->wantsJson()) {
                 return response()->json(
                         [
                                 'error'   => true,
                                 'message' => $exception->getMessageBag(),
                         ]
                 );
             }
             $message = $exception->getMessage();
             return Redirect::back()->withInput()->withErrors(array('user_name' => $message));
         }
    }

    use FileUploadTrait;

    public function uploader(Request $request, $id)
    {
        if (!Gate::allows('competition_access')) {
            return abort(401);
        }
        $competition                = $this->competitionService->find($id);
        $path                       = 'public/'.$request->type.'/'.$competition->season;
        $uploads                    = $this->saveFiles($request, $path);
        $requests                   = $request->all();
        $requests['competition_id'] = $id;
        $requests['type']           = $request->type;
        $requests['filename']       = $uploads->uploader;
        Upload::create($requests);

        return response()->json(
                $uploads
        );
    }


}
