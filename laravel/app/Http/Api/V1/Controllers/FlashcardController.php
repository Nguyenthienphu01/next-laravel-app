<?php

namespace App\Http\Api\V1\Controllers;

use App\Models\Flashcard;
use Illuminate\Http\Request;

class FlashcardController extends BaseController
{
    public function store(Request $request)
    {
        $request->validate([
            'set_id' => 'required|exists:sets,id',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'term' => 'required|string',
            'definition' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $flashcard = new Flashcard();
        $flashcard->set_id = $request->set_id;
        $flashcard->title = $request->title;
        $flashcard->description = $request->description;
        $flashcard->term = $request->term;
        $flashcard->definition = $request->definition;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/flashcards'), $imageName);
            $flashcard->image = 'images/flashcards/' . $imageName;
        }

        $flashcard->save();

        return response()->json([
            'message' => 'Flashcard created successfully',
            'data' => $flashcard
        ], 201);
    }
}
