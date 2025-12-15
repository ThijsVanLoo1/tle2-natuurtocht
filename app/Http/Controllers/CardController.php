<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\NatureItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CardController extends Controller
{

    public function show(Card $card)
    {
        $user = auth()->user();

        $ownedCard = $user?->cards()->where('cards.id', $card->id)->first();

        $owned = (bool)$ownedCard;

        $location = "Schiebroekse Polder";
        $season = "Herfst";

        return view('cards.show', [
            'card' => $card,
            'ownedCard' => $ownedCard, // <-- belangrijk
            'location' => $location,
            'season' => $season,
            'owned' => $owned,
        ]);
    }

    public function makeCardShiny(int $id)
    {
        $shinyCard = DB::table('user_cards')
            ->where('card_id', '=', $id)
            ->get()
            ->first();

        //Here the variable of 'is_shiny' needs to set to true, then the card will be shiny
        json_encode($shinyCard, true);
//        dd( $shinyCard);
        (array)$shinyCard['is_shiny'] = true;
        return redirect()->route('natuur-dex.index');
    }


}
