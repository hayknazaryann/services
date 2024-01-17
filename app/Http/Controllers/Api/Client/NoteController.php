<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Note\StoreRequest;
use App\Http\Requests\Client\Note\UpdateRequest;
use App\Http\Resources\Note\NoteResource;
use App\Models\Note;
use App\Services\NoteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class NoteController extends Controller
{
    /**
     * @param NoteService $noteService
     */
    public function __construct(
        protected NoteService $noteService
    )
    {

    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return $this->noteService->userNotes($request->user());
    }


    /**
     * Store a newly created resource in storage.
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        return $this->noteService->create($request->user(), $request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateRequest $request
     * @param Note $note
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Note $note): JsonResponse
    {
        return $this->noteService->update($request->user(), $note, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     * @param Note $note
     * @return JsonResponse
     */
    public function destroy(Request $request, Note $note): JsonResponse
    {
        return $this->noteService->delete($request->user(), $note);
    }

}
