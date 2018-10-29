<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    //
    public function getTags(){
        $tags = DB::table('tags')->pluck('name');
        return response()->json($tags);
    }
}
