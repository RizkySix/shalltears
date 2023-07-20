<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        session()->flash('on_category_form' , true);
        $messages = [
            'category_name.min' => 'Masukan nama kategori yang benar!',
            'tipe_barang.min' => 'Masukan tipe barang yang sesuai!'
        ];

        $validatedData = $request->validate([
            'category_name' => 'required|string|min:2',
            'tipe_barang' => 'required|string|min:3'
        ] , $messages);

        Category::create($validatedData);
        return back()->with('success' , 'Category baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        session()->flash('on_category_update_form' , true);
        $messages = [
            'category_name.min' => 'Masukan nama kategori yang benar!',
            'tipe_barang.min' => 'Masukan tipe barang yang sesuai!'
        ];

        $validatedData = $request->validate([
            'category_name' => 'required|string|min:2',
            'tipe_barang' => 'required|string|min:3'
        ] , $messages);

        Category::where('id' , $category->id)->update($validatedData);
        return back()->with('success' , 'Category berhasil dirubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
