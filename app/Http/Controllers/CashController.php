<?php

namespace App\Http\Controllers;

use App\Exceptions\Controller;
use App\Models\Cash;
use App\Models\Mik;
use Illuminate\Support\Facades\Http;

class CashController extends Controller
{
    public function index(){
        $cashs = Cash::all();
        $mikrotiks = Mik::all();
        return view('admin.cash',[
            'cashs'=>$cashs,
            'mikrotiks'=>$mikrotiks
        ]);
    }
    public function test(){
        return view('admin.ttt');
    }
    public function testOne(){
        $posts = Http::post("https://test.synatechafrica.com/clients");
        return $posts;
    }
}
