<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use App\Models\Video;
use Illuminate\Http\Request;

class RateController extends Controller
{
    /**
     * Dodaj ocenę dla filmu.
     */
    public function store(Request $request, Video $video)
    {
        $validated = $request->validate([
            'stars' => 'required|integer|min:1|max:5',
        ]);

        $rating = Rate::updateOrCreate(
            ['user_id' => auth()->id(), 'video_id' => $video->id],
            ['stars' => $validated['stars']]
        );

        return response()->json(['message' => 'Rating added successfully', 'rating' => $rating], 201);
    }

    /**
     * Zaktualizuj ocenę dla filmu.
     */
    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'stars' => 'required|integer|min:1|max:5',
        ]);

        $rating = Rate::where('user_id', auth()->id())
            ->where('video_id', $video->id)
            ->firstOrFail();

        $rating->update(['stars' => $validated['stars']]);

        return response()->json(['message' => 'Rating updated successfully', 'rating' => $rating]);
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

        return response()->json(['message' => 'Rating removed successfully']);
    }

}
