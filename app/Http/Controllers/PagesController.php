<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;

use App\Repositories\Page\PageRepositoryInterface;
use App\Services\PageService;



class PagesController extends Controller
{
    protected $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
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
        $ageclasses = $this->pageService->loadAgeclasses();
        return view('front.pages.ageclasses', compact('ageclasses'));
    }
}
