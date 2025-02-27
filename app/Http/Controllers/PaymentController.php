<?php

namespace App\Http\Controllers;

use Stripe;
use Session;
use App\Models\Show;
use Illuminate\Http\Request;
use App\Models\Representation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * payment view
     */
    public function index()
    {
        return view('home');
    }

    /**
     * payment view
     */
    public function handleGet()
    {
        return view('payment.payment');
    }

    /**
     * handling payment with POST
     */
    public function handlePost($id,Request $request)
    {
        $mininumPlace = 100;  //Le minimum de place que l'on vend en avant première.(salle inconnue NULL)   TODO   choisir
        $qty = $request->session()->get('qty');
        $price = $request->session()->get('price');
        $name = $request->session()->get('show')->title;
        $show = $request->session()->get('show');
        $date = $request->session()->get('date');
        $user = Auth::id();
        $representations = $request->session()->get('representations');

        $representations = DB::table('representations')->where([
            ['show_id', '=', $show->id],
            ['location_id', '=', $show->location_id],
        ])->get();


        foreach($representations as $representation){
            if(isset($representation->when))
            {
                if(Carbon::parse($representation->when)->format('d/m/Y') == $date){
                    $places = $representation->places;
                }
            }
        }


        $noLocation = false;

        if(($places - $qty) >= 0)
        {

            try {
                    Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

                    Stripe\Charge::create ([
                        'amount' => $price * 100,
                        'currency' => "EUR",
                        'source' => $request->stripeToken,
                        'description' => "Paiement de votre réservation pour la pièce ".$name." au Théatre.",
                    ]);

                    DB::table('representation_user')->insert([
                        ['user_id' => $user, 'representation_id' => $representations[0]->id],
                    ]);

                    $representation = Representation::find($representations[0]->id);
                    $representation->places = $places - $qty;
                    $representation->save();

                    if($representation->location_id === NULL || $show->location_id === NULL)
                    {
                        $noLocation = true;
                    }

                    return view('show.confirmation',[
                        'show' => $show,
                        'message' => "Le paiement de votre réservation a été éffectué",
                        'representations' => $representations,
                        'date' => $date,
                        'price' => $price,
                        'qty' => $qty,
                        'title' => $name,
                        'noLocation' => $noLocation,
                    ]);
                } catch(\Exception $ex) {
                    $collaborateurs = [];

                    foreach($show->artistTypes as $at) {
                        $collaborateurs[$at->type->type][] = $at->artist;
                    }

                    return view('show.show',[
                        'show' => $show,
                        'message' => "Une erreur est survenue",
                        'representations' => $representations,
                        'collaborateurs' => $collaborateurs,
                    ]);
                }
        } else {
            $collaborateurs = [];

            foreach($show->artistTypes as $at) {
                $collaborateurs[$at->type->type][] = $at->artist;
            }

            return view('show.show',[
                'show' => $show,
                'message' => "Plus de places disponibles",
                'representations' => $representations,
                'collaborateurs' => $collaborateurs,
            ]);
        }
    }
}
