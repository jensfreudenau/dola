<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Page;
use Illuminate\Http\Request;
use Session;

class PagesController extends Controller
{
     /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($mnemonic)
    {
        $page = Page::where('mnemonic', '=', $mnemonic)->first();

        return view('front.pages.show', compact('page'));
    }


}
