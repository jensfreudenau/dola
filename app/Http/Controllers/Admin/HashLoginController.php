<?php

namespace App\Http\Controllers\Admin;

use App\Models\Competition;
use App\Models\HashLogin;
use App\Repositories\HashLogin\HashLoginRepositoryInterface;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HashLoginController extends Controller
{
    /**
     * @var HashLoginRepositoryInterface
     */
    protected $hashLoginRepository;

    public function __construct(HashLoginRepositoryInterface $hashLoginRepository)
    {
        $this->hashLoginRepository = $hashLoginRepository;
    }

    public function index()
    {
        if (!Gate::allows('hashes_access')) {
            return abort(401);
        }
        $hashes = $this->hashLoginRepository->getAll();

        return view('admin.hashes.index', compact('hashes'));
    }
    public function show()
    {
        return redirect()->route('admin.hashes.index');
    }
    /**
     * Show the form for creating new organizer.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('hashes_create')) {
            return abort(401);
        }
        $hashes = '';

        return view('admin.hashes.create', compact('hashes'));
    }

    /**
     * Store a newly created Team in storage.
     *
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Gate::allows('hashes_create')) {
            return abort(401);
        }

        $this->hashLoginRepository->create([
                'email'  => $request->email,
                'active' => $request->active,
                'name' => $request->name,
                'hash'   => hash('md5', $request->email),
        ]);

        return redirect()->route('admin.hashes.index');
    }

    /**
     *
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('hashes_edit')) {
            return abort(401);
        }
        $hash = $this->hashLoginRepository->find($id);

        return view('admin.hashes.edit', compact('hash'));
    }

    public function destroy($id)
    {
        if (!Gate::allows('hashes_delete')) {
            return abort(401);
        }
        $hash = $this->hashLoginRepository->find($id);
        $hash->delete();

        return redirect()->route('admin.hashes.index');
    }

    /**
     * Update Team in storage.
     *
     * @param UpdateTeamsRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!Gate::allows('hashes_edit')) {
            return abort(401);
        }

        $hash = $this->hashLoginRepository->find($id);
        $hash->active = $request->has('active');
        $hash->update($request->all());

        return redirect()->route('admin.hashes.index');
    }

    /**
     * Delete all selected hashes at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('hashes_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = HashLogin::whereIn('id', $request->input('ids'))->get();
            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }
}
