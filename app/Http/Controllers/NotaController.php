<?php

/**
 * Antonio J.Sánchez 
 * curso 2019/20
 */

namespace App\Http\Controllers;

use App\Models\Nota ;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    //
    public function view()
    {
    	return view('notas.ver') ;
    }

    public function ver(Request $req)
    {
        
        $idt = $req->input('id') ;

        $Nota = Nota::where('idTab', $idt)->get();

        // dd($Nota);
        return view('notas.ver', compact('Nota'));
    }


}
