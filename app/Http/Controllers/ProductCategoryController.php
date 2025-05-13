<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Categories::query()
        ->when($request->filled('q'), function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->q . '%')
                ->orWhere('description', 'like', '%' . $request->q .
                    '%');
        })
        ->paginate(10);
    return view('dashboard.categories.index', [
        'categories' => $categories,
        'q' => $request->q
    ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //validasi
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'description' => 'nullable|max:1000'
        ]);

        //jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->with('errorMessage','Validasi gagal')
            ->withInput();
        }

        //jika validasi berhasil
        //simpan data ke database
        $category= new Categories();
        $category->name = $request->input('name');
        $category->slug = $request->input('slug');
        $category->description = $request->input ('description');

        //jika ada gambar
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time(). '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('uploads/categories', $imageName, 'public');
            $category->image = $imagePath;
        }

        $category->save();
        
        return redirect()->route('categories.index')
           ->with('success', 'Categeory created succesfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Categories::find($id);
        return view('dashboard.categories.detail',[
            'category'=>$category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Categories::findOrFail ($id);

        return view('dashboard.categories.edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category= Categories::find($id);
        $category->name = $request->input('name');
        $category->slug = $request->input('slug');
        $category->description = $request->input ('description');

        //jika ada gambar
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time(). '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('uploads/categories', $imageName, 'public');
            $category->image = $imagePath;
        }

        $category->save();
        
        return redirect()->route('categories.index')
           ->with('success', 'Data berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Categories::find($id);
        $category->delete();

        return redirect()->route('categories.index')
        ->with('success', 'Data berhasil dihapus');
    }
}
