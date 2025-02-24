<?php

namespace App\Http\Api\V1\Controllers;

use App\Models\Set;
use App\Models\Flashcard;
use Illuminate\Http\Request;

class FlashcardController extends BaseController
{
    public function store(Request $request)
    {
        $request->validate([
            'set_id' => 'required|exists:sets,id',
            'term' => 'required|string',
            'definition' => 'required|string',
            'image' => 'nullable|string'
        ]);

        $flashcard = Flashcard::create($request->all());
        return $this->sendResponse($flashcard, 'Flashcard created successfully');
    }

    public function createSet(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'visibility' => 'required|in:public,private'
        ]);

        $set = Set::create([
            'user_id' => auth()->id(),
            ...$request->all()
        ]);

        return $this->sendResponse($set, 'Set created successfully');
    }

    public function getSet($id)
    {
        $set = Set::with('flashcards')->findOrFail($id);
        return $this->sendResponse($set, 'Set retrieved successfully');
    }
}
