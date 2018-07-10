<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Address\AddressRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class AddressesController extends Controller
{
    protected $addressRepository;

    public function __construct(AddressRepositoryInterface $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    public function index()
    {
        if (! Gate::allows('address_access')) {
            return abort(401);
        }

        $addresses = $this->addressRepository->getAll();
        return view('admin.addresses.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if (! Gate::allows('address_edit')) {
            return abort(401);
        }
        return view('admin.addresses.create');
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
        if (! Gate::allows('address_access')) {
            return abort(401);
        }
        $address = $this->addressRepository->findById($id);

        return view('admin.addresses.show', compact('address'));
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
        if (! Gate::allows('address_edit')) {
            return abort(401);
        }
        $requestData = $request->all();

        $this->addressRepository->create($requestData);

        return redirect('admin/addresses');
    }

    public function edit($id)
    {
        if (!Gate::allows('address_access')) {
            return abort(401);
        }
        $address = $this->addressRepository->findById($id);
        return view('admin.addresses.edit', compact('address'));
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
        if (! Gate::allows('address_edit')) {
            return abort(401);
        }
        $requestData = $request->all();
        $address = $this->addressRepository->findById($id);
        $address->update($requestData);
        return redirect('admin/addresses');
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
        $this->addressRepository->delete($id);
        Session::flash('flash_message', 'Addresse gelöscht!');

        return redirect('admin/addresses');
    }
}
