<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Page;
use App\Repositories\Page\PageRepositoryInterface;
use Illuminate\Http\Request;
use Session;


class PagesController extends Controller
{
    protected $pagerepository;

    public function __construct(PageRepositoryInterface $pageRepository)
    {
        $this->pagerepository = $pageRepository;
    }

    /**
     * Display the specified resource.
     *
     * @param $mnemonic
     * @return \Illuminate\View\View
     */
    public function show($mnemonic)
    {
        $page = $this->pagerepository->findBy('mnemonic', $mnemonic);
        return view('front.pages.show', compact('page'));
    }
}
