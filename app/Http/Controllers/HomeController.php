<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Appartement;

use App\Models\Demande;

class HomeController extends Controller
{
    public function appartement_details($id)
    {
        $appartement = Appartement::find($id);

        return view('home.appartement_details', compact('appartement'));
    }

    public function add_demande(Request $request, $id)
    {

        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'date|after:startDate',


        ]);
        $data = new Demande;
        $data->appartement_id = $id;

        $data->nom = $request->lastname;
        $data->prenom = $request->firstname;
        $data->email = $request->email;
        $data->numero_telephone = $request->phone;
        $data->arrivee = $request->startDate;
        $data->depart = $request->endDate;
        $data->id_demandeur = Auth::id();

        $data->save();

        return redirect()->back()->with('message', 'La demande a été envoyée avec succès');
    }
}
