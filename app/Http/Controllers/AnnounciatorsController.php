<?php

namespace App\Http\Controllers;

use App\Models\Ageclass;
use App\Services\AnnounciatorService;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Session;

class AnnounciatorsController extends Controller
{
    protected $announciatorService;

    public function __construct( AnnounciatorService $announciatorService)
    {
        $this->announciatorService = $announciatorService;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $id
     * @return \Illuminate\View\View
     */
    public function create($id = '')
    {
        if (empty($id)) {
            $competition = $this->announciatorService->getSelectFirst();
            $id          = $competition[0]->id;
        }
        $competition       = $this->announciatorService->findCompetition($id);
        $disciplines       = $competition->disciplines->pluck('shortname', 'id')->toArray();
        if('cross' == $competition->season) {
            $ageclasses = Ageclass::orderBy('name', 'asc')->pluck('shortname', 'id')->toArray();
        }
        else {
            $ageclasses = $competition->ageclasses->pluck('shortname', 'id')->toArray();
        }
        $competitionselect = $this->announciatorService->getCompetionSelectable();
        return view('front.announciators.create', compact('competition', 'competitionselect', 'disciplines', 'ageclasses'));
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

//        try {
            $announciator = $this->announciatorService->processAnnouncement($request);
            $cookie = Cookie::make('announciators_id', $announciator->id);
            return redirect()->action('AnnounciatorsController@listParticipator')->withCookie($cookie);
//        } catch (\Exception $e) {
//            if ($request->wantsJson()) {
//                return response()->json([
//                                            'error'   => true,
//                                            'message' => $e->getMessageBag()
//                                        ]);
//            }
//            $message = $e->getMessage();
//            dump($message = $e->getMessage());
////            return Redirect::back()->withInput()->withErrors(array('user_name' => $message));
////            return redirect()->back()->withErrors()->withInput();
//        }
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
