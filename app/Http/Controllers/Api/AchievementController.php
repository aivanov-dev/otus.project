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
     * @param ValidateIndexRequest $request
     *
     * @return JsonResponse
     */
    public function index(ValidateIndexRequest $request): JsonResponse
    {
        //ALSO NEED SWAGGER DOCS AND EXPRESSION VALIDATION, AND MAYBE EVENT AND EVENT LISTENER FOR PROCESSING!
        $page = $request->get('page') ?? AchievementCollection::PAGE;
        $perPage = $request->get('per-page') ?? AchievementCollection::PER_PAGE;
        $offset = ($page - AchievementCollection::PAGE) * $perPage;

        $achievements = Achievement::limit($perPage)->offset($offset)->get();

        return response()->json(
            new AchievementCollection($achievements, $page, $perPage)
        )->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ValidateStoreRequest $request
     *
     * @return JsonResponse
     */
    public function store(ValidateStoreRequest $request): JsonResponse
    {
        try {
            Achievement::create([
                'name' => $request->name,
                'slug' => $request->slug ?? null,
                'description' => $request->description ?? null,
                'expression' => $request->expression
            ]);
        } catch (Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]
            )->setStatusCode(500);
        }

        return response()->json(
            [
                'status' => 'Success',
                'message' => 'Achievement has been successfully created!'
            ]
        )->setStatusCode(201);
    }

    /**
     * Update the specified resource in storage.
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
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'No data to update!'
                ]
            )->setStatusCode(400);
        }

        try {
            $achievement->update(array_filter([
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'expression' => $request->expression
            ]));
        } catch (Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]
            )->setStatusCode(500);
        }

        return response()->json(
            [
                'status' => 'Success',
                'message' => 'Achievement has been successfully updated!'
            ]
        )->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
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
            return response()->json(
                [
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]
            )->setStatusCode(500);
        }

        return response()->json(
            [
                'status' => 'Success',
                'message' => 'Achievement has been successfully removed!'
            ]
        )->setStatusCode(200);
    }
}
