<?php

namespace App\Http\Controllers\API;

use App\Models\Notes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotesController extends Controller
{
    private $note;

    public function __construct(Notes $note)
    {
        return $this->note = $note;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $notes = $this->note->where('user_id', $user->id)->paginate(10);

        return response()->json($notes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $requestData = $request->all();
        $requestData['user_id'] = $user->id;

        return $this->note->create($requestData);
    }

    /**
     * Display the specified resource.
     */
    public function show(Notes $note)
    {
        return $note;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notes $note)
    {
        $note->update($request->all());

        return $note;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notes $note)
    {
        return $note->delete();
    }
}
