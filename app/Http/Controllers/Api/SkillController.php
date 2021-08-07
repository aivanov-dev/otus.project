<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Skills\GetLevelNameByExperienceRequest;
use App\Http\Requests\Skills\StoreSkillRequest;
use App\Http\Requests\Skills\UpdateSkillRequest;
use App\Http\Resources\SkillResource;
use App\Models\Skill;
use App\Services\SkillLevel\Repositories\SkillLevelRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class SkillController extends Controller
{
    public function __construct(private SkillLevelRepository $skillLevelRepository) {}

    /**
     * Display a listing of the skill resource.
     *
     * @OA\Get(
     *     path="/api/skills",
     *     operationId="getAllSkills",
     *     tags={"Skills"},
     *     summary="Get list of all skills",
     *     description="Get list of all skills",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/SkillResource")
     *      ),
     *     @OA\Response(
     *         response=500,
     *         description="Error",
     *     ),
     * )
     *
     * @return JsonResponse
     */
    public function all(): JsonResponse
    {
        return new JsonResponse(SkillResource::collection(Skill::all()));
    }

    /**
     * Display skill resource.
     *
     * @OA\Get(
     *     path="/api/skills/{id}",
     *     operationId="getSkillById",
     *     tags={"Skills"},
     *     summary="Get skill by id",
     *     description="Get skill by id",
     *     @OA\Parameter(
     *         name="id",
     *         description="Id of the skill",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer",
     *             example="3"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/SkillResource")
     *      ),
     *     @OA\Response(
     *         response=404,
     *         description="Skill not found",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error",
     *     ),
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function get(int $id): JsonResponse
    {
        try {
            $skill = new SkillResource(Skill::findOrFail($id));
        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['errors' => "Skill with id $id not found"], 404);
        }

        return new JsonResponse($skill);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/api/skills",
     *     operationId="storeSkill",
     *     tags={"Skills"},
     *     summary="Store new skill",
     *     description="Returns created skill",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreSkillRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/SkillResource")
     *      ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad input data",
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Error",
     *     ),
     * )
     *
     * @param StoreSkillRequest $request
     *
     * @return JsonResponse
     */
    public function store(StoreSkillRequest $request): JsonResponse
    {
        $skill = Skill::create($request->validated());
        return new JsonResponse(new SkillResource($skill), 201);
    }

    /**
     * Update resource.
     *
     * @OA\Patch(
     *     path="/api/skills/{id}",
     *     operationId="updateSkill",
     *     tags={"Skills"},
     *     summary="Update skill",
     *     description="Returns updated skill",
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateSkillRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/SkillResource")
     *      ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad input data",
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Error",
     *     ),
     * )
     *
     * @param UpdateSkillRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateSkillRequest $request, int $id): JsonResponse
    {
        try {
            Skill::findOrFail($id)->update($request->validated());
        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['errors' => "Skill with id $id not found"], 404);
        }

        return new JsonResponse(['success' => true], 202);
    }

    /**
     * Delete resource from storage.
     *
     * @OA\Delete(
     *     path="/api/skills/{id}",
     *     operationId="deleteSkill",
     *     tags={"Skills"},
     *     summary="Delete skill",
     *     description="Returns operation status",
     *     @OA\Response(
     *         response=204,
     *         description="Successful operation",
     *      ),
     *     @OA\Response(
     *         response=404,
     *         description="Skill not found",
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Error",
     *     ),
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        try {
            Skill::findOrFail($id)->delete();
        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['errors' => "Skill with id $id not found"], 404);
        }

        return new JsonResponse(['success' => true], 204);
    }

    /**
     * Get skills levels.
     *
     * @OA\Get(
     *     path="/api/skills/levels/all",
     *     operationId="getAllSkillsLevels",
     *     tags={"Skills"},
     *     summary="Get all skills levels",
     *     description="Returns list of skills levels",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/SkillLevelResource")
     *      ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad input data",
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Error",
     *     ),
     * )
     *
     * @return JsonResponse
     */
    public function getAllLevels(): JsonResponse
    {
        return new JsonResponse($this->skillLevelRepository->all());
    }

    /**
     * Get skills level name by value.
     *
     * @OA\Get(
     *     path="/api/skills/levels/search",
     *     operationId="getSkillsLevelByValue",
     *     tags={"Skills"},
     *     summary="Get skills level by value",
     *     description="Returns name of skills level",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/SkillLevelResource")
     *      ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad input data",
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Error",
     *     ),
     * )
     *
     * @param GetLevelNameByExperienceRequest $request
     * @return JsonResponse
     */
    public function getLevelName(GetLevelNameByExperienceRequest $request): JsonResponse
    {
        return new JsonResponse($this->skillLevelRepository->getLevelByExperience($request->get('experience')));
    }
}
