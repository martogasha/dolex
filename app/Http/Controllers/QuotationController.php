<?php

namespace App\Http\Controllers;

use App\Exceptions\Controller;

class QuotationController extends Controller
{
    public function createInvoice(){
        return view('admin.createInvoice');
    }
}
