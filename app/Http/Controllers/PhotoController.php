<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PhotoController extends Controller
{
    public function store(Request $request, Card $card)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Je moet ingelogd zijn.'], 401);
        }

        $validator = Validator::make($request->all(), [
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            Log::error('Validatiefout bij foto-upload voor kaart ' . $card->id . ': ' . $validator->errors()->first());
            return response()->json([
                'message' => 'De foto is niet geldig. Zorg dat het een afbeelding is (jpg, png) en niet groter dan 2MB.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // ✅ Check eerst of deze kaart al in bezit is (voor punten + voorkomen duplicates)
            $alreadyOwned = $user->cards()->where('cards.id', $card->id)->exists();

            // 1) Zorg dat pivot bestaat (owned)
            $user->cards()->syncWithoutDetaching([
                $card->id => [
                    'acquired_at' => now()->toDateString(),
                ],
            ]);

            // 2) Haal de bestaande pivot op (zodat we oude foto kunnen verwijderen)
            $ownedCard = $user->cards()
                ->where('cards.id', $card->id)
                ->first();

            $oldPivotImage = $ownedCard?->pivot?->image_url;

            // 3) Bewaar naar public/images/cardimages
            $file = $request->file('photo');

            $dir = public_path('images/cardimages');
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            // ✅ unieke filename (iets netter)
            $ext = $file->getClientOriginalExtension();
            $filename = Str::uuid()->toString() . '.' . $ext;

            $file->move($dir, $filename);

            $relativePath = 'images/cardimages/' . $filename;

            // 4) Oude pivot foto verwijderen (alleen als het een lokale file is)
            if ($oldPivotImage && !str_starts_with($oldPivotImage, 'http')) {
                $oldFullPath = public_path($oldPivotImage);
                if (file_exists($oldFullPath)) {
                    @unlink($oldFullPath);
                }
            }

            // 5) Pivot updaten (foto opslaan bij user_cards)
            $user->cards()->updateExistingPivot($card->id, [
                'image_url' => $relativePath,
            ]);

            // ✅ 6) Alleen bij eerste keer verzamelen: punten +15
            if (!$alreadyOwned && method_exists($user, 'awardPoints')) {
                $user->awardPoints(15, 'card_collected', $card, [
                    'source' => 'photo_upload',
                ]);
            }

            session()->flash('success', 'Foto succesvol geüpload en gekoppeld aan jouw kaart!');

            return response()->json([
                'message' => 'Foto succesvol geüpload!',
                'redirect_url' => route('cards.show', $card),
            ]);

        } catch (\Exception $e) {
            Log::error('Fout bij uploaden van foto voor kaart ' . $card->id . ': ' . $e->getMessage());

            return response()->json([
                'message' => 'De upload is mislukt op de server. Probeer het opnieuw.',
            ], 500);
        }
    }
}
