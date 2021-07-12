<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Exercises\StoreExerciseRequest;
use App\Http\Requests\Exercises\UpdateExerciseRequest;
use App\Http\Resources\ExerciseResource;
use App\Models\Exercise;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ExerciseController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/exercises",
     *      operationId="getExercises",
     *      tags={"Exercises"},
     *      summary="Get list of exercises",
     *      description="Returns list of exercises",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/ExerciseResource")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *     @OA\Response(
     *          response=500,
     *          description="Error",
     *     ),
     * )
     */
    public function index(): JsonResponse
    {
        return new JsonResponse(ExerciseResource::collection(Exercise::all()));
    }

    /**
     * @OA\Get(
     *      path="/api/exercises/{id}",
     *      operationId="getExerciseById",
     *      tags={"Exercises"},
     *      summary="Get exercise information",
     *      description="Returns exercise data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Exercise id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/ExerciseResource")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Error",
     *     ),
     * )
     */
    public function get(int $id): JsonResponse
    {
        try {
            $user = new ExerciseResource(Exercise::findOrFail($id));
        } catch (ModelNotFoundException $exception) {
            return new JsonResponse([
                $exception->getMessage(),
                $exception->getTraceAsString(),
                'Exercise by id ' . $id . ' not found',
            ], 404);
        }
        return new JsonResponse($user);
    }

    /**
     *
     * @OA\Post(
     *     path="/api/exercises",
     *     operationId="storeExercise",
     *     tags={"Exercises"},
     *     summary="Store new exercise",
     *     description="Returns new created exercise",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreExerciseRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ExerciseResource")
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *         response=500,
     *         description="Error",
     *     ),
     * )
     * @param StoreExerciseRequest $request
     *
     * @return JsonResponse
     */
    public function store(StoreExerciseRequest $request): JsonResponse
    {
        $user = Exercise::create($request->validated());
        return new JsonResponse(new ExerciseResource($user), 201);
    }

    /**
     * Update resource.
     *
     * @OA\PUT(
     *     path="/api/exercises/{id}",
     *     operationId="updateExercise",
     *     tags={"Exercises"},
     *     summary="Update exercise",
     *     description="Returns updated exercise",
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateExerciseRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ExerciseResource")
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *         response=500,
     *         description="Error",
     *     ),
     * )
     * @param UpdateExerciseRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateExerciseRequest $request, int $id): JsonResponse
    {
        try {
            Exercise::findOrFail($id)->update($request->validated());
        } catch (ModelNotFoundException $exception) {
            return new JsonResponse([
                $exception->getMessage(),
                $exception->getTraceAsString(),
                'message' => 'Can not update exercise by id ' . $id,
            ], 404);
        }

        return new JsonResponse(
            [
                'message' => "Exercise - {$id} is updated",
                'success' => true,
            ], 202);
    }

    /**
     * Delete resource from storage.
     *
     * @OA\Delete(
     *      path="/api/exercises/{id}",
     *      operationId="deleteExercise",
     *      tags={"Exercises"},
     *      summary="Delete existing exercise",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Exercise id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        try {
            Exercise::findOrFail($id)->delete();
        } catch (ModelNotFoundException $exception) {
            return new JsonResponse([
                $exception->getMessage(),
                $exception->getTraceAsString(),
                'message' => 'Can not delete exercise by id ' . $id,
            ], 404);
        }

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
