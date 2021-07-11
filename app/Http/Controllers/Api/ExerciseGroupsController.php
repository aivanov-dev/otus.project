<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExerciseGroups\StoreExerciseGroupsRequest;
use App\Http\Resources\ExerciseGroupsResource;
use App\Models\ExerciseGroup;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ExerciseGroupsController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/exercise-groups",
     *      operationId="getExerciseGroups",
     *      tags={"ExerciseGroups"},
     *      summary="Get list of ExerciseGroups",
     *      description="Returns list of exercise-groups",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/ExerciseGroupsResource")
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
    public function all(): JsonResponse
    {
        $nodes = ExerciseGroup::get()->toFlatTree();
        return new JsonResponse(ExerciseGroupsResource::collection($nodes));
    }

    /**
     * @OA\Get(
     *      path="/api/exercise-groups/ancestors/{id}",
     *      operationId="getAncestorsById",
     *      tags={"ExerciseGroups"},
     *      summary="Get ancestors tree information",
     *      description="Returns excersices data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Excersice id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/UserResource")
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
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAncestors(int $id): JsonResponse
    {
        try {
            $ancestors = ExerciseGroupsResource::collection(ExerciseGroup::defaultOrder()->ancestorsAndSelf($id));
        } catch (ModelNotFoundException $exception) {
            return new JsonResponse([
                $exception->getMessage(),
                $exception->getTraceAsString(),
                'Exercise by id ' . $id . ' not found',
            ], 404);
        }
        return new JsonResponse($ancestors);
    }

    /**
     * @OA\Get(
     *      path="/api/exercise-groups/descendants/{id}",
     *      operationId="getDescendantsById",
     *      tags={"ExerciseGroups"},
     *      summary="Get descendants tree information",
     *      description="Returns excersices data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Excersice id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/UserResource")
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
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDescendants(int $id): JsonResponse
    {
        try {
            $ancestors = ExerciseGroupsResource::collection(ExerciseGroup::defaultOrder()->descendantsAndSelf($id));
        } catch (ModelNotFoundException $exception) {
            return new JsonResponse([
                $exception->getMessage(),
                $exception->getTraceAsString(),
                'Exercise by id ' . $id . ' not found',
            ], 404);
        }
        return new JsonResponse($ancestors);
    }

    /**
     * Add new node to tree
     * @OA\Post(
     *     path="/api/exercise-groups",
     *     operationId="storeExerciseGroups",
     *     tags={"ExerciseGroups"},
     *     summary="Store new exerciseGroups",
     *     description="Returns new created exerciseGroups",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreExerciseGroupsRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ExerciseGroupsResource")
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
     *
     * @param StoreExerciseGroupsRequest $request
     *
     * @return JsonResponse
     * @throws \Throwable
     */
    public function store(StoreExerciseGroupsRequest $request): JsonResponse
    {
        $parentId = $request->get('parent_id');
        \DB::beginTransaction();
        try {
            if (!empty($parentId)) {
                $parentNode = ExerciseGroup::where('parent_id', $parentId)->first();
                $node = ExerciseGroup::create($request->validated(), $parentNode); // Saved as child node
            } else {
                $node = ExerciseGroup::create($request->validated()); // Saved as root
            }
            \DB::commit();
        } catch (\Exception $exception) {
            \DB::rollBack();
            return new JsonResponse([
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'code' => $exception->getCode(),
                'trace' => $exception->getTraceAsString(),
            ], 500);
        }

        return new JsonResponse(new ExerciseGroupsResource($node), 201);
    }

    /**
     * Delete resource from storage.
     *
     * @OA\Delete(
     *      path="/api/exercise-groups/{id}",
     *      operationId="deleteExerciseGroup",
     *      tags={"ExerciseGroups"},
     *      summary="Delete existing ExerciseGroup",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Parent id",
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
    /**
     * @throws \Throwable
     */
    public function delete(int $id): JsonResponse
    {
        \DB::beginTransaction();
        try {
            $node = ExerciseGroup::where('parent_id', $id);
            $node->delete();
            \DB::commit();
        } catch (\Exception $exception) {
            \DB::rollBack();
            return new JsonResponse([
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'code' => $exception->getCode(),
                'trace' => $exception->getTraceAsString(),
            ], 404);
        }
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
