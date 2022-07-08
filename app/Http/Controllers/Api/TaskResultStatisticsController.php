<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskResultStatistics\UpdateTaskResultStatisticsRequest;
use App\Http\Resources\TaskResultStatisticsResource;
use App\Models\TaskResultStatistics;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class TaskResultStatisticsController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/result-statistics-tasks",
     *      operationId="getTaskResultStatistics",
     *      tags={"TaskResultStatistics"},
     *      summary="Get list of taskResultStatistics rows",
     *      description="Returns list of list of taskResultStatistics rows",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TaskResultStatisticsResource")
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
        return new JsonResponse(TaskResultStatisticsResource::collection(TaskResultStatistics::all()));
    }

    /**
     * @OA\Get(
     *      path="/api/result-statistics-tasks/{id}",
     *      operationId="getTaskResultStatisticsById",
     *      tags={"TaskResultStatistics"},
     *      summary="Get taskResultStatistics information",
     *      description="Returns taskResultStatistics data",
     *      @OA\Parameter(
     *          name="id",
     *          description="TaskResultStatistics id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TaskResultStatisticsResource")
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
            $row = new TaskResultStatisticsResource(TaskResultStatistics::findOrFail($id));
        } catch (ModelNotFoundException $exception) {
            return new JsonResponse([
                'Row by id ' . $id . ' not found',
                $exception->getMessage(),
                $exception->getTraceAsString(),
            ], 404);
        }
        return new JsonResponse($row);
    }

    /**
     * Update resource.
     *
     * @OA\PUT(
     *     path="api/result-statistics-tasks/",
     *     operationId="updateTaskResultStatistics",
     *     tags={"TaskResultStatistics"},
     *     summary="Update taskResultStatistics",
     *     description="Returns updated taskResultStatistics",
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateTaskResultStatisticsRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/TaskResultStatisticsResource")
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
     * @param UpdateTaskResultStatisticsRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(UpdateTaskResultStatisticsRequest $request, int $id): JsonResponse
    {
        \DB::beginTransaction();
        try {

            $raw = TaskResultStatistics::whereId($id);

            if (!$raw->exists()) {
                throw new NotFoundResourceException();
            }

            $rawStat = $raw->lockForUpdate()->first();

            if (!$request->validated()) {
                throw new \Exception('jjjj');
            }

            $rawStat->assessment += $request->assessment;
            $rawStat->save();
            \DB::commit();
        } catch (ModelNotFoundException $exception) {
            \DB::rollBack();
            return new JsonResponse([
                $exception->getMessage(),
                $exception->getTraceAsString(),
                'message' => 'Can not update taskResultStatistics by id ' . $id,
            ], 404);
        }

        return new JsonResponse(
            [
                'message' => "taskResultStatistics - {$id} is updated",
                'success' => true,
                'assessment' => $rawStat->assessment,
            ], 202);
    }
}
