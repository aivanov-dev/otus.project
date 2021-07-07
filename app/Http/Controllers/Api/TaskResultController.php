<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\TaskResult;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResultCollection;
use App\Http\Requests\TaskResults\ValidateIndexRequest;
use App\Http\Requests\TaskResults\ValidateStoreRequest;
use App\Http\Requests\TaskResults\ValidateUpdateRequest;

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

        return response()->json($result)->setStatusCode(201);
    }

    /**
     * @OA\Put(
     *     path="/api/results/{id}",
     *     operationId="updateTaskResult",
     *     tags={"Task Results"},
     *     summary="Update existing TaskResult",
     *     description="Update only those fields you want, no need to send all fields.",
     *     @OA\Parameter(
     *         name="id",
     *         description="Task result ID",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreTaskResultRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/TaskResult")
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
     * @param TaskResult $result
     *
     * @return JsonResponse
     */
    public function update(ValidateUpdateRequest $request, TaskResult $result): JsonResponse
    {
        $data = array_filter([
            'task_id' => $request->task_id,
            'user_id' => $request->user_id,
            'exercise_group_id' => $request->exercise_group_id,
            'assessment' => $request->assessment
        ]);

        if (!$data) {
            return response()->json([
                'status' => 'error',
                'message' => 'No data to update!'
            ])->setStatusCode(400);
        }

        try {
            $result->update(array_filter([
                'task_id' => $request->task_id,
                'user_id' => $request->user_id,
                'exercise_group_id' => $request->exercise_group_id,
                'assessment' => $request->assessment
            ]));
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }

        return response()->json($result)->setStatusCode(200);
    }

    /**
     * @OA\Delete(
     *     path="/api/results/{id}",
     *     operationId="deleteTaskResult",
     *     tags={"Task Results"},
     *     summary="Delete task result",
     *     description="Delete task result  by it id.",
     *     @OA\Parameter(
     *         name="id",
     *         description="Task Results ID",
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
     * @param TaskResult $result
     *
     * @return JsonResponse
     */
    public function destroy(TaskResult $result): JsonResponse
    {
        try {
            $result->delete();
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }

        return response()->json([])->setStatusCode(204);
    }
}
