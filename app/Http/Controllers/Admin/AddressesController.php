<?php

namespace App\Http\Controllers\Admin;

use App\Address;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AddressesController extends Controller
{
    public function index()
    {
        if (! Gate::allows('address_access')) {
            return abort(401);
        }

        $addresses = Address::all();
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
        $address = Address::findOrFail($id);

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

        Address::create($requestData);

        return redirect('admin/addresses');
    }

    public function edit($id)
    {
        if (!Gate::allows('address_access')) {
            return abort(401);
        }
        $address = Address::findOrFail($id);
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
        $address = Address::findOrFail($id);
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
        Address::destroy($id);

        Session::flash('flash_message', 'Page deleted!');

        return redirect('admin/pages');
    }
}
