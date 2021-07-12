<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\StoreTaskRequest;
use App\Http\Requests\Tasks\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/tasks",
     *      operationId="getTasks",
     *      tags={"Tasks"},
     *      summary="Get list of tasks",
     *      description="Returns list of tasks",
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
        return new JsonResponse(TaskResource::collection(Task::all()));
    }

    /**
     * @OA\Get(
     *      path="/api/tasks/{id}",
     *      operationId="getTaskById",
     *      tags={"Tasks"},
     *      summary="Get task information",
     *      description="Returns task data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Task id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TaskResource")
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
            $user = new TaskResource(Task::findOrFail($id));
        } catch (ModelNotFoundException $exception) {
            return new JsonResponse([
                'Task by id ' . $id . ' not found',
                $exception->getMessage(),
                $exception->getTraceAsString(),
            ], 404);
        }
        return new JsonResponse($user);
    }

    /**
     *
     * @OA\Post(
     *     path="/api/tasks",
     *     operationId="storeTask",
     *     tags={"Tasks"},
     *     summary="Store new task",
     *     description="Returns new created task",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreTaskRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/TaskResource")
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
     * @param StoreTaskRequest $request
     *
     * @return JsonResponse
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = Task::create($request->validated());
        return new JsonResponse(new TaskResource($task), 201);
    }

    /**
     * Update resource.
     *
     * @OA\PUT(
     *     path="/api/tasks/{id}",
     *     operationId="updateTask",
     *     tags={"Tasks"},
     *     summary="Update task",
     *     description="Returns updated task",
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateTaskRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/TaskResource")
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
     * @param UpdateTaskRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTaskRequest $request, int $id): JsonResponse
    {
        try {
            Task::findOrFail($id)->update($request->validated());
        } catch (ModelNotFoundException $exception) {
            return new JsonResponse([
                $exception->getMessage(),
                $exception->getTraceAsString(),
                'message' => 'Can not update task by id ' . $id,
            ], 404);
        }

        return new JsonResponse(
            [
                'message' => "Task - {$id} is updated",
                'success' => true,
            ], 202);
    }

    /**
     * Delete resource from storage.
     *
     * @OA\Delete(
     *      path="/api/tasks/{id}",
     *      operationId="deleteTask",
     *      tags={"Tasks"},
     *      summary="Delete existing task",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Task id",
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
            Task::findOrFail($id)->delete();
        } catch (ModelNotFoundException $exception) {
            return new JsonResponse([
                $exception->getMessage(),
                $exception->getTraceAsString(),
                'message' => 'Can not delete task by id ' . $id,
            ], 404);
        }

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
