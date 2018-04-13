<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;

use App\Repositories\Page\PageRepositoryInterface;
use App\Services\AgeclassService;
use App\Services\PageService;



class PagesController extends Controller
{
    protected $pageService;
    protected $ageclassService;

    public function __construct(PageService $pageService, AgeclassService $ageclassService)
    {
        $this->pageService = $pageService;
        $this->ageclassService = $ageclassService;
    }

    /**
     * Display the specified resource.
     *
     * @param $mnemonic
     * @return \Illuminate\View\View
     */
    public function show($mnemonic)
    {
        $page = $this->pageService->findMnemonic($mnemonic);
        return view('front.pages.show', compact('page'));
    }

    public function ageclasses()
    {
        $ageclasses = $this->ageclassService->loadAgeclasses();
        return view('front.pages.ageclasses', compact('ageclasses'));
    }
}
