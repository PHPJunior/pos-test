<?php

namespace Domain\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Domain\Category\Services\CategoryService;
use Domain\Product\Http\Requests\StoreProductRequest;
use Domain\Product\Http\Requests\UpdateProductRequest;
use Domain\Product\Models\Product;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * @param CategoryService $categoryService
     */
    public function __construct(private CategoryService $categoryService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('Product/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->categoryService->all();
        return Inertia::render('Product/Create', compact('categories'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = $this->categoryService->all();
        return Inertia::render('Product/Edit', compact('product', 'categories'));
    }
}
