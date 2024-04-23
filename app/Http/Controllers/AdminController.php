<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use Illuminate\Support\Facades\Auth;

use App\Models\Appartement;

use App\Models\Demande;

use App\Models\Logement;

class AdminController extends Controller
{
    public function index()
    {
        if (Auth::id()) {
            $usertype = Auth()->user()->usertype;
            if ($usertype == 'visiteur') {
                $appartement = Appartement::all();
                return view('home.index', compact('appartement'));
            } else if ($usertype == 'admin') {
                return view('admin.index');
            } else if ($usertype == 'propriétaire') {
                // Ajoutez votre logique pour le cas où l'utilisateur est un propriétaire
                // Par exemple, vous pouvez rediriger vers la vue propriétaire.index
                return view('proprietaire.index');
            } else {
                return redirect()->back();
            }
        }
    }


    public function home()
    {
        $appartement = Appartement::all();
        return view('home.index', compact('appartement'));
    }

    public function create_appartement()
    {
        return view('admin.create_appartement');
    }
    public function add_appartement(Request $request)
    {
        $data = new Appartement;

        $data->nom = $request->nom;
        $data->description = $request->description;
        $data->RUE = $request->RUE;
        $data->ARRONDISSE = $request->ARRONDISSE;
        $data->ETAGE = $request->ETAGE;
        $data->TYPAPPART = $request->TYPAPPART;
        $data->PRIX_LOC = $request->PRIX_LOC;
        $data->PRIX_CHARG = $request->PRIX_CHARG;
        $data->ASCENSEUR = $request->ASCENSEUR;
        $data->PREAVIS = $request->PREAVIS;
        $data->DATE_LIBRE = $request->DATE_LIBRE;

        // Récupérer l'ID de l'utilisateur connecté
        $data->id_proprietaire = Auth::id();

        $image = $request->image;

        if ($image) {
            $imagename = time() . '.' . $image->getClientOriginalExtension();

            $request->image->move('appartement', $imagename);
            $data->image = $imagename;
        }

        $data->save();

        return redirect()->back();
    }

    public function view_appartement()
    {
        $id = Auth::user()->id;
        $data = Appartement::where('id_proprietaire', '=', $id)->get();
        return view('proprietaire.view_appartement', compact('data'));
    }

    public function appartement_delete($id)
    {
        $data = Appartement::find($id);
        $data->delete();

        return redirect()->back();
    }

    public function appartement_update($id)
    {
        $data = Appartement::find($id);
        return view('admin.update_appartement', compact('data'));
    }

    public function edit_appartement(Request $request, $id)
    {
        $data = Appartement::find($id);

        $data->nom = $request->nom;
        $data->description = $request->description;
        $data->RUE = $request->RUE;
        $data->ARRONDISSE = $request->ARRONDISSE;
        $data->ETAGE = $request->ETAGE;
        $data->TYPAPPART = $request->TYPAPPART;
        $data->PRIX_LOC = $request->PRIX_LOC;
        $data->PRIX_CHARG = $request->PRIX_CHARG;
        $data->ASCENSEUR = $request->ASCENSEUR;
        $data->PREAVIS = $request->PREAVIS;
        $data->DATE_LIBRE = $request->DATE_LIBRE;

        $image = $request->image;

        if ($image) {

            $imagename = time() . '.' . $image->getClientOriginalExtension();

            $request->image->move('appartement', $imagename);
            $data->image = $imagename;
        }

        $data->save();

        return redirect()->back();
    }

    public function demandes_appartement()
    {
        $user_id = Auth::id();
        $data = Demande::where('id_demandeur', $user_id)->get();
        return view('home.demandes_appartement', compact('data'));
    }

    function demandes()
    {
        $data = Demande::all();
        return view('admin.demande', compact('data'));
    }


    public function demandes_proprietaire()
    {
        // Récupérer l'ID de l'utilisateur connecté
        $id_proprietaire = Auth::id();

        // Récupérer les demandes liées aux appartements de ce propriétaire
        $data = Demande::whereHas('appartement', function ($query) use ($id_proprietaire) {
            $query->where('id_proprietaire', $id_proprietaire);
        })->get();

        return view('proprietaire.demande', compact('data'));
    }

    public function delete_demande($id)
    {

        $data = Demande::find($id);
        $data->delete();
        return redirect()->back();
    }
    public function Accepter($id)
    {
        $demande = Demande::find($id);

        $demande->statut = "Acceptée";

        $demande->save();

        return redirect()->back();
    }

    public function appartement_search(Request $request)
    {
        $search_text = $request->search;
        $prix_max = $request->prix_max; // Récupérer la valeur de prix_max depuis la requête

        // Commencez par construire la requête sans l'exécuter
        $query = Appartement::query()
            ->where('nom', 'LIKE', '%' . $search_text . '%')
            ->orWhere('ARRONDISSE', 'LIKE', '%' . $search_text . '%')
            ->orWhere('TYPAPPART', 'LIKE', '%' . $search_text . '%');

        // Vérifier si prix_max est défini et s'il est numérique
        if ($prix_max && is_numeric($prix_max)) {
            // Ajouter la condition pour le prix maximum à la requête
            $query->where('PRIX_LOC', '<=', $prix_max);
        }

        // Exécutez la requête et paginez les résultats
        $appartement = $query->paginate(10);

        // Retournez les résultats à la vue
        return view('home.index', compact('appartement'));
    }

    public function logement_search(Request $request)
    {
        $search_text = $request->search;
        $prix_max = $request->prix_max;
        $region = $request->region;
        $departement = $request->departement;
        $ville = $request->ville;
        $arrondissement = $request->arrondissement;

        $query = Logement::query();

        if ($search_text) {
            $query->where('nom', 'LIKE', '%' . $search_text . '%');
        }

        if ($prix_max && is_numeric($prix_max)) {
            $query->where('prix_loc', '<=', $prix_max);
        }

        if ($region) {
            $query->where('region', 'LIKE', '%' . $region . '%');
        }

        if ($departement) {
            $query->where('departement', 'LIKE', '%' . $departement . '%');
        }

        if ($ville) {
            $query->where('ville', 'LIKE', '%' . $ville . '%');
        }

        if ($arrondissement) {
            $query->where('arrondissement', 'LIKE', '%' . $arrondissement . '%');
        }

        $logements = $query->paginate(10);

        return view('home.index', compact('logements'));
    }
}
