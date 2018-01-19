<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Repositories\Page\PageRepository;
use App\Validators\PageValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Input;
use Session;

class PagesController extends Controller
{
    protected $repository;

    public function __construct(PageRepository $repository, PageValidator $validator)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (!Gate::allows('page_access')) {
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
        if (!Gate::allows('page_edit')) {
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
        if (!Gate::allows('page_edit')) {
            return abort(401);
        }
        $this->repository->create($request->all());
        return redirect('admin/pages');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        if (!Gate::allows('page_access')) {
            return abort(401);
        }
        $page = $this->repository->find($id);
        if (request()->wantsJson()) {
            return response()->json(['data' => $page]);
        }
        return view('admin.pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        if (!Gate::allows('page_edit')) {
            return abort(401);
        }
        $page = $this->repository->find($id);
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id)
    {
        if (!Gate::allows('page_edit')) {
            return abort(401);
        }
        $this->repository->update(Input::all(), $id);
        return redirect('admin/pages');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        if (!Gate::allows('page_edit')) {
            return abort(401);
        }
        $this->repository->delete($id);
        return redirect('admin/pages');
    }
}
