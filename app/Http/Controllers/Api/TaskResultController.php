<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\TaskResult;
use App\Jobs\ResultSavedJob;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResultResource;
use App\Http\Resources\TaskResultCollection;
use App\Http\Requests\TaskResults\ValidateIndexRequest;
use App\Http\Requests\TaskResults\ValidateStoreRequest;

class TaskResultController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/results/index",
     *     operationId="getResultsList",
     *     tags={"Task Results"},
     *     summary="Get list of resultss with pagination",
     *     description="Get list of resultss with pagination",
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
     *         description="Number of results per page",
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
     *         @OA\JsonContent(ref="#/components/schemas/IndexTaskResultsResource")
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
        $page = $request->get('page') ?? TaskResultCollection::PAGE;
        $perPage = $request->get('per-page') ?? TaskResultCollection::PER_PAGE;
        $offset = ($page - TaskResultCollection::PAGE) * $perPage;

        try {
            $taskResult = TaskResult::with('task', 'user', 'exerciseGroups')->limit($perPage)->offset($offset)->get();
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }

        return response()->json(
            new TaskResultCollection($taskResult, $page, $perPage)
        )->setStatusCode(200);
    }

    /**
     * @OA\Post(
     *     path="/api/results",
     *     operationId="storeResults",
     *     tags={"Task Results"},
     *     summary="Store new result",
     *     description="Returns result data",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreTaskResultRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/TaskResult")
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
            $result = TaskResult::create([
                'task_id' => $request->task_id,
                'user_id' => $request->user_id,
                'exercise_group_id' => $request->exercise_group_id,
                'assessment' => $request->assessment
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }

        ResultSavedJob::dispatch($result);

        return response()->json(new TaskResultResource($result))->setStatusCode(201);
    }
}
