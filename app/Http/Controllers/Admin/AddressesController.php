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
}
