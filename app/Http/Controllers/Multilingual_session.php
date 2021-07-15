<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Multilingual_session extends Controller
{
    public function store($type)
    {
        session()->put('multi_lang', $type);
        return redirect('/');
    }

}
