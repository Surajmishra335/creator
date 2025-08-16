<?php

namespace App\Http\Controllers\Brand;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class FindCreatorController extends Controller
{
    public function index()
    {
        $social_platforms = DB::table('social_platforms_master')->orderBy('id', 'asc')
            ->get();
        return view('brand.find-creator', compact('social_platforms'));
    }
}