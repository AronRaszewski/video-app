<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use App\Models\Video;
use Illuminate\Http\Request;

class RateController extends Controller
{

    public function rate(Request $request, Video $video) {
        $validated = $request->validate([
            'rate' => 'required|integer|min:1|max:5',
        ]);

        $user = $request->user();

        $isCreated = false;

        // Sprawdź czy ocena istnieje
        $rate = Rate::where('user_id', $user->id)->where('video_id', $video->id)->first();

        // Jeśli nie - utwórz
        if ($rate === null) {
            $rate = new Rate();
            $rate->user()->associate($user);
            $rate->video()->associate($video);

            $isCreated = true;
        }


        // Zapisz do bazy danych
        $rate->rate = $validated['rate'];
        $rate->save();

        $message = $isCreated ? 'Dziękujemy za ocenienie filmu' : 'Pomyślnie zmieniono ocenę';

        // Wyślij wiadomość użytkownikowi
        return response()->json(['message' => $message]);
    }

    /**
     * Dodaj ocenę dla filmu.
     */
    public function store(Request $request, Video $video)
    {
        $validated = $request->validate([
            'rate' => 'required|integer|min:1|max:5',
        ]);

        if ($video->author->id === $request->user()->id) {
            return response()->json(['message' => 'Nie możesz oceniać własnych filmów'], 403);
        }

        $rate = new Rate(['rate' => $validated['rate']]);
        $rate->video()->associate($video);
        $rate->user()->associate($request->user());
        $rate->save();

        return response()->json(['message' => 'Dziękujemy za ocenienie filmu']);
    }

    /**
     * Zaktualizuj ocenę dla filmu.
     */
    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'rate' => 'required|integer|min:1|max:5',
        ]);

        $rating = Rate::where('user_id', auth()->id())
            ->where('video_id', $video->id)
            ->firstOrFail();

        $rating->update(['rate' => $validated['rate']]);

        return response()->json(['message' => 'Zmieniono ocenę', 'rating' => $rating]);
    }

    /**
     * Usuń ocenę dla filmu.
     */
    public function destroy(Video $video)
    {
        $rating = Rate::where('user_id', auth()->id())
            ->where('video_id', $video->id)
            ->firstOrFail();

        $rating->delete();

        return response()->json(['message' => 'Usunięto ocenę']);
    }

}
