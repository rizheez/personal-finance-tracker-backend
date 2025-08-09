<?php

namespace App\Repositories;

use App\Models\Category;
use App\Interface\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * Create a new class instance.
     */


    /**
     * Get a list of categories with optional filters.
     *
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(array $filters = [], $perPage = null)
    {
        //
        $query = Category::filter($filters)->orderBy('name', 'asc');
        return $perPage ? $query->paginate($perPage)->withQueryString() : $query->get();
    }

    /**
     * Find a category by its ID.
     *
     * @param int $id
     * @return \App\Models\Category|null
     */
    public function find($id)
    {
        //
        return Category::find($id);
    }

    /**
     * Create a new category.
     *
     * @param array $data
     * @return \App\Models\Category
     */
    public function create(array $data)
    {
        return Category::create($data);
    }
    /**
     * Update an existing category.
     * @param int $id
     * @param array $data
     * @return \App\Models\Category|null
     */
    public function update($id, array $data)
    {
        //
        $category = Category::findOrFail($id);
        $category->update($data);
        return $category;
    }

    /**
     * Delete a category by its ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        //
        $category = Category::findOrFail($id);
        return $category->delete();
    }
}
