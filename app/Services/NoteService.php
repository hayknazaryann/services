<?php

namespace App\Services;

use App\Http\Resources\Note\NoteResource;
use App\Models\Note;
use App\Models\User;
use App\Repositories\Interfaces\NoteInterface;
use App\Traits\ApiControllerTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NoteService
{
    use ApiControllerTrait;

    /**
     * @param NoteInterface $noteRepository
     */
    public function __construct(
        protected NoteInterface $noteRepository
    )
    {
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function userNotes(User $user): JsonResponse
    {
        $notes = $this->noteRepository->getUserNotes($user);
        return $this->successResponse(
            data: [
                'notes' => NoteResource::collection($notes),
                'meta'  => [
                    'current_page' => $notes->currentPage(),
                    'last_page'    => $notes->lastPage()
                ]
            ],
        );
    }

    /**
     * @return JsonResponse
     */
    public function paginate(): JsonResponse
    {
        $notes = $this->noteRepository->paginate(9);
        return $this->successResponse(
            data: [
                'notes' => NoteResource::collection($notes),
                'meta'  => [
                    'current_page' => $notes->currentPage(),
                    'last_page'    => $notes->lastPage()
                ]
            ],
        );
    }

    /**
     * @param User $user
     * @param array $data
     * @return JsonResponse
     */
    public function create(User $user, array $data): JsonResponse
    {
        try {
            if (!$user->can('create', Note::class)) {
                return $this->errorResponse(
                    message: 'Forbidden !',
                    statusCode: 403
                );
            }

            DB::beginTransaction();
            $data['user_id'] = $user->id;
            $note = $this->noteRepository->create($data);
            DB::commit();
            return $this->successResponse(
                data: ['note' => (new NoteResource($note))],
                message: __('Note created successfully'),
                statusCode: 201
            );
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Note create error: ' . $exception->getMessage());
            return $this->errorResponse(
                message: __('Something went wrong !')
            );
        }
    }

    /**
     * @param User $user
     * @param Note $note
     * @param array $data
     * @return JsonResponse
     */
    public function update(User $user, Note $note, array $data): JsonResponse
    {
        try {
            if (!$user->can('update', $note)) {
                return $this->errorResponse(
                    message: 'Forbidden !',
                    statusCode: 403
                );
            }
            DB::beginTransaction();
            $this->noteRepository->update($note, $data);
            DB::commit();
            return $this->successResponse(
                data: ['note' => (new NoteResource($note))],
                message: __('Note updated successfully'),
                statusCode: 201
            );
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Note update error: ' . $exception->getMessage());
            return $this->errorResponse(
                message: __('Something went wrong !')
            );
        }
    }

    /**
     * @param User $user
     * @param Note $note
     * @return JsonResponse
     */
    public function delete(User $user, Note $note): JsonResponse
    {
        try {
            if (!$user->can('delete', $note)) {
                return $this->errorResponse(
                    message: 'Forbidden !',
                    statusCode: 403
                );
            }

            $this->noteRepository->delete($note);
            return $this->successResponse(
                data: [],
                message: __('Note deleted successfully'),
            );
        } catch (\Exception $exception) {
            Log::error('Note delete error: ' . $exception->getMessage());
            return $this->errorResponse(
                message: __('Something went wrong !')
            );
        }
    }
}
