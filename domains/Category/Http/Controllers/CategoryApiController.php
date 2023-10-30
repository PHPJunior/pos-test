<?php

namespace Domain\Category\Http\Controllers;

use App\Http\Controllers\Controller;
use Domain\Category\Http\Data\CategoryData;
use Domain\Category\Http\Requests\StoreCategoryRequest;
use Domain\Category\Http\Requests\UpdateCategoryRequest;
use Domain\Category\Http\Resources\CategoryResource;
use Domain\Category\Models\Category;
use Domain\Category\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Annotations as OA;

class CategoryApiController extends Controller
{
    public function __construct(private readonly CategoryService $categoryService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     *
     * @OA\Get(
     *     path="/api/categories",
     *     summary="Get all categories",
     *     tags={"Categories"},
     *     security={{"token":{}}},
     *     @OA\Parameter( name="relations[]", in="query", description="Relations to include", required=false,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(type="string"),
     *         ),
     *     ),
     *     @OA\Parameter( name="page", in="query", description="Page number", required=false,
     *         @OA\Schema(
     *            type="integer",
     *            format="int32"
     *         ),
     *     ),
     *     @OA\Parameter( name="per_page", in="query", description="Per page", required=false,
     *          @OA\Schema(
     *             type="integer",
     *             format="int32"
     *          ),
     *      ),
     *      @OA\Parameter( name="name", in="query", description="Category Name", required=false,
     *           @OA\Schema(
     *              type="string",
     *           ),
     *     ),
     *      @OA\Parameter( name="slug", in="query", description="Category Slug", required=false,
     *          @OA\Schema(
     *              type="string",
     *          ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categories",
     *     ),
     * )
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return CategoryResource::collection($this->categoryService->paginate(
            $request,
            $request->get('relations', [])
        ));
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/api/categories/{category}",
     *     summary="Get a category",
     *     tags={"Categories"},
     *     security={{"token":{}}},
     *     @OA\Parameter( name="category", in="path", description="Category ID", required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int32"
     *          ),
     *     ),
     *     @OA\Parameter( name="relations[]", in="query", description="Relations to include", required=false,
     *          @OA\Schema( type="array",
     *              @OA\Items(type="string"),
     *          ),
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Category",
     *     )
     * )
     */
    public function show(Request $request, Category $category): CategoryResource
    {
        return new CategoryResource($this->categoryService->findById(
            $category->id,
            $request->get('relations', [])
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/api/categories",
     *     summary="Create a category",
     *     tags={"Categories"},
     *     security={{"token":{}}},
     *     @OA\RequestBody( required=true, description="Category data",
     *          @OA\JsonContent(
     *              @OA\Property( property="name", type="string", example="Category Name" ),
     *              @OA\Property( property="slug", type="string", example="category-name" ),
     *         ),
     *     ),
     *     @OA\Response(
     *          response=201,
     *          description="Category",
     *     ),
     * )
     *
     * @param StoreCategoryRequest $request
     * @return CategoryResource
     */
    public function store(StoreCategoryRequest $request): CategoryResource
    {
        return new CategoryResource($this->categoryService->create(
            CategoryData::from($request)
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *      path="/api/categories/{category}",
     *      summary="Create a category",
     *      tags={"Categories"},
     *     security={{"token":{}}},
     *      @OA\Parameter( name="category", in="path", description="Category ID", required=true,
     *           @OA\Schema(
     *               type="integer",
     *               format="int32"
     *           ),
     *      ),
     *      @OA\RequestBody( required=true, description="Category data",
     *           @OA\JsonContent(
     *               @OA\Property( property="name", type="string", example="Category Name" ),
     *               @OA\Property( property="slug", type="string", example="category-name" ),
     *          ),
     *      ),
     *      @OA\Response(
     *           response=201,
     *           description="Category",
     *      ),
     *  )
     *
     * @param UpdateCategoryRequest $request
     * @param Category $category
     * @return CategoryResource
     */
    public function update(UpdateCategoryRequest $request, Category $category): CategoryResource
    {
        return new CategoryResource($this->categoryService->update(
            CategoryData::from($request),
            $category->id
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/api/categories/{category}",
     *     summary="Delete a category",
     *     tags={"Categories"},
     *     security={{"token":{}}},
     *     @OA\Parameter( name="category", in="path", description="Category ID", required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int32"
     *          ),
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Category deleted successfully",
     *     ),
     * )
     *
     * @param Category $category
     * @return JsonResponse
     */
    public function destroy(Category $category): JsonResponse
    {
        $deleted = $this->categoryService->delete($category->id);

        if ($deleted) {
            return response()->json(['message' => 'Category deleted successfully'], 200);
        }

        return response()->json(['message' => 'Category not deleted'], 400);
    }
}
