<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Interface\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     */
    protected $categoryRepository;
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        // Retrieve filters from the request
        $filters = $request->only(['name', 'color']);
        $filters['user_id'] = auth()->id(); // Assuming user_id is required for filtering
        $perPage = $request->get('per_page', 20);

        // Get categories using the repository
        $categories = $this->categoryRepository->index($filters, $perPage);

        return response()->json([
            'data' => CategoryResource::collection($categories),
            'message' => 'Categories retrieved successfully.',
            'status' => 'success',
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        // Create a new category using the repository
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['user_id'] = auth()->id(); // Assuming user_id
            $category = $this->categoryRepository->create($data);
            DB::commit();
            return response()->json([
                'data' => new CategoryResource($category),
                'message' => 'Category created successfully.',
                'status' => 'success',
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to create category: ' . $e->getMessage(),
                'status' => 'error',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get category using the repository
        $category = $this->categoryRepository->find($id);
        if (!$category) {
            return response()->json([
                'message' => 'Category not found.',
                'status' => 'error',
            ], 404);
        }
        return response()->json([
            'data' => new CategoryResource($category),
            'message' => 'Category retrieved successfully.',
            'status' => 'success',
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        // Get category using the repository
        $category = $this->categoryRepository->find($id);
        if (!$category) {
            return response()->json([
                'message' => 'Category not found.',
                'status' => 'error',
            ], 404);
        }
        DB::beginTransaction();
        try {
            $category = $this->categoryRepository->update($id, $request->validated());
            DB::commit();
            return response()->json([
                'data' => new CategoryResource($category),
                'message' => 'Category updated successfully.',
                'status' => 'success',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to update category: ' . $e->getMessage(),
                'status' => 'error',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get category using the repository
        $category = $this->categoryRepository->find($id);
        if (!$category) {
            return response()->json([
                'message' => 'Category not found.',
                'status' => 'error',
            ], 404);
        }
        DB::beginTransaction();
        try {
            $this->categoryRepository->delete($id);
            DB::commit();
            return response()->json([
                'message' => 'Category deleted successfully.',
                'status' => 'success',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to delete category: ' . $e->getMessage(),
                'status' => 'error',
            ], 500);
        }
    }
}
