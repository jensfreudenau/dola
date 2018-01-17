<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Page;
use App\Repositories\Page\PageRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Session;

class PagesController extends Controller
{

    public function __construct(PageRepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (! Gate::allows('page_access')) {
            return abort(401);
        }

        $pages = Page::all();
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if (! Gate::allows('page_edit')) {
            return abort(401);
        }
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        if (! Gate::allows('page_edit')) {
            return abort(401);
        }
        $requestData = $request->all();

        $this->pageRepository->create($requestData);

        Session::flash('flash_message', 'Page added!');

        return redirect('admin/pages');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        if (! Gate::allows('page_access')) {
            return abort(401);
        }
        $page = $this->pageRepository->find($id);

        return view('admin.pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        if (! Gate::allows('page_edit')) {
            return abort(401);
        }
        $page = $this->pageRepository->find($id);

        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        if (! Gate::allows('page_edit')) {
            return abort(401);
        }
        $requestData = $request->all();
        
        $page = $this->pageRepository->find($id);
        $page->update($requestData);

        Session::flash('flash_message', 'Page updated!');

        return redirect('admin/pages');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        if (! Gate::allows('page_edit')) {
            return abort(401);
        }
        Page::destroy($id);

        Session::flash('flash_message', 'Page deleted!');

        return redirect('admin/pages');
    }
}
