<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\JobCategory;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Container\Attributes\DB;
use Illuminate\Contracts\Queue\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query=JobCategory::latest();
        if($request->input('archived')=='true' ){
           $query->onlyTrashed();     

        } 
        if($request->input('search')){
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }
        if($request->input('sort')){
            $query->orderBy('name', $request->input('sort'));
        }
        if($request->input('sort')=='desc'){
            $query->orderBy('name', 'desc');
        }
        


        $categories = $query->paginate(3)->onEachSide(1);

        return view('categorie.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('categorie.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryCreateRequest $request)
    {
        JobCategory::create($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $category = JobCategory::findOrFail($id);
        return view('categorie.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, string $id)
    {

        $category = JobCategory::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');


    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $category = JobCategory::findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index')
            ->with('success', 'Category Archived successfully.');
    }


    public function restore(string $id)
    {
        $category = JobCategory::withTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('categories.index', ['archived' => 'true'])
            ->with('success', 'Category restored successfully.');
    }
}
