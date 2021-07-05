<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Achievement;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\AchievementCollection;
use App\Http\Requests\Achievements\ValidateStoreRequest;
use App\Http\Requests\Achievements\ValidateIndexRequest;
use App\Http\Requests\Achievements\ValidateUpdateRequest;

class AchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/api/achievements/index",
     *     operationId="getAchievementList",
     *     tags={"Achievements"},
     *     summary="Get list of achievements with pagination",
     *     description="Get list of achievements with pagination",
     *     @OA\Parameter(
     *         name="page",
     *         description="Page number",
     *         required=false,
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *             default="1"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="per-page",
     *         description="Number of achievement per page",
     *         required=false,
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *             default="10"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/IndexAchievementResource")
     *      ),
     *     @OA\Response(
     *         response=422,
     *         description="Bad input data",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error",
     *     ),
     * )
     *
     * @param ValidateIndexRequest $request
     *
     * @return JsonResponse
     */
    public function index(ValidateIndexRequest $request): JsonResponse
    {
        $page = $request->get('page') ?? AchievementCollection::PAGE;
        $perPage = $request->get('per-page') ?? AchievementCollection::PER_PAGE;
        $offset = ($page - AchievementCollection::PAGE) * $perPage;

        try {
            $achievements = Achievement::limit($perPage)->offset($offset)->get();
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }

        return response()->json(
            new AchievementCollection($achievements, $page, $perPage)
        )->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/api/achievements",
     *     operationId="storeAchievement",
     *     tags={"Achievements"},
     *     summary="Store new achievements",
     *     description="Returns achievement data",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreAchievementRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Achievement")
     *      ),
     *     @OA\Response(
     *         response=422,
     *         description="Bad input data",
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Error",
     *     ),
     * )
     *
     * @param ValidateStoreRequest $request
     *
     * @return JsonResponse
     */
    public function store(ValidateStoreRequest $request): JsonResponse
    {
        try {
            $achievement = Achievement::create([
                'name' => $request->name,
                'slug' => $request->slug ?? null,
                'description' => $request->description ?? null,
                'expression' => $request->expression
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }

        return response()->json($achievement)->setStatusCode(201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/api/achievements/{id}",
     *     operationId="updateAchievement",
     *     tags={"Achievements"},
     *     summary="Update existing achievements",
     *     description="Update only those fields you want, no need to send all fields.",
     *     @OA\Parameter(
     *         name="id",
     *         description="Achievement ID",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreAchievementRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Achievement")
     *      ),
     *     @OA\Response(
     *         response=422,
     *         description="Bad input data",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="No data to update, empty request body",
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Error",
     *     ),
     * )
     *
     * @param ValidateUpdateRequest $request
     * @param Achievement $achievement
     *
     * @return JsonResponse
     */
    public function update(ValidateUpdateRequest $request, Achievement $achievement): JsonResponse
    {
        $data = array_filter([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'expression' => $request->expression
        ]);

        if (!$data) {
            return response()->json([
                'status' => 'error',
                'message' => 'No data to update!'
            ])->setStatusCode(400);
        }

        try {
            $achievement->update(array_filter([
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'expression' => $request->expression
            ]));
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }

        return response()->json($achievement)->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/api/achievements/{id}",
     *     operationId="deleteAchievement",
     *     tags={"Achievements"},
     *     summary="Delete achievements",
     *     description="Delete achievements by it id.",
     *     @OA\Parameter(
     *         name="id",
     *         description="Achievement ID",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Bad input data",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error",
     *     ),
     * )
     *
     * @param Achievement $achievement
     *
     * @return JsonResponse
     */
    public function destroy(Achievement $achievement): JsonResponse
    {
        try {
            $achievement->delete();
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }

        return response()->json([])->setStatusCode(204);
    }
}
