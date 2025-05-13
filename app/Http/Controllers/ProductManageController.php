<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Categories;

class ProductManageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Products::query()
        ->when($request->filled('q'), function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->q . '%')
            ->orWhere('description', 'like', '%' . $request->q .
            '%');
        })
        ->paginate(10);

        return view('dashboard.product.index', [
            'products' => $products,
            'q'=> $request->q
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categories::all();
        return view ('dashboard.product.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validasi
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_slug' => 'required|string|exists:product_categories,slug',
            'slug' => 'required|string|max:255|unique:products,slug',
            'description' => 'nullable|max:1000',
            'sku' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image_url' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        //Ambil ID kategori dari slug
        // $category = Categories::where('slug', $request->category_slug)->first();

        // $sku = strtoupper(Str::random(8));
        // while (Products::where('sku', $sku)->exists()) {
        //     $sku = strtoupper(Str::random(8));
        // }

        //jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->with('errorMessage','Validasi gagal')
            ->withInput();
        }

        //jika validasi berhasil
        //simpan data ke database
        $product= new Products();
        $product->name = $request->input('name');
        $product->slug = $request->input('slug');
        $product->description = $request->input ('description');
        $product->sku = $request->input('sku');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        
        
        $category = Categories::where('slug', $request->category_slug)->first();
        if (!$category) {
            return redirect()->back()
            ->with('errorMessage', 'Kategori tidak ditemukan')
            ->withInput();
        }
        
        $product->product_category_id = $category->id;


        //jika ada gambar
        if($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $imageName = time(). '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('uploads/product', $imageName, 'public');
            $product->image_url = $imagePath;
        }

        $product->save();

        return redirect()->route('product.index')
           ->with('success', 'Product created succesfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Products::find($id);
        return view('dashboard.product.detail', [
            'product'=>$product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Products::findOrFail ($id);
        $categories = Categories::all();
        return view('dashboard.product.edit', [
            'product'=>$product,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

     $validator = \Validator::make($request->all(), [
    'name' => 'required|string|max:255',
    'category_slug' => 'required|string|exists:product_categories,slug',
    'slug' => 'required|string|max:255|unique:products,slug,' . $id,
    'description' => 'nullable|max:1000',
    'sku' => 'required|string|max:50',
    'price' => 'required|numeric|min:0',
    'stock' => 'required|integer|min:0',
    'image_url' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
]);

if ($validator->fails()) {
    return redirect()->back()
    ->withErrors($validator)
    ->with('errorMessage', 'Validasi gagal')
    ->withInput();
}


        $product= Products::find($id);
        $product->name = $request->input('name');
        $product->slug = $request->input('slug');
        $product->description = $request->input ('description');
        $product->sku = $request->input('sku');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');

        $category = Categories::where('slug', $request->category_slug)->first();
        if (!$category) {
            return redirect()->back()
            ->with('errorMessage', 'Kategori tidak ditemukan')
            ->withInput();
        }
        
        $product->product_category_id = $category->id;

        //jika ada gambar
        if($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $imageName = time(). '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('uploads/product', $imageName, 'public');
            $product->image_url = $imagePath;
        }

        $product->save();

        return redirect()->route('product.index')
        ->with('success', 'Data berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Products::find($id);
        $product->delete();

        return redirect()->route('product.index')
        ->with('success', 'Data berhasil dihapus');
    }
}
