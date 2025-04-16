<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\DetailSales;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::all();
        return view('product-list',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('add-product');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'photo_product' => 'required|image|mimes:jpeg,png,jpg,gif|max:8192' //max 8mb
        ],[
            'photo_product.max' => 'Silahkan pilih foto yang tidak lebih dari 8mb'
        ]);
    
        $imagePath = $request->file('photo_product')->store('products', 'public');
    
        Products::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath
        ]);
    
        return redirect()->route('product-list')->with('success', 'Berhasil Membuat Product');
    }
  

    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|numeric|min:0',
        ]);
    
        // Cari produk berdasarkan ID
        $product = Products::findOrFail($id);
    
        // Update hanya stok produk
        $product->update([
            'stock' => $request->stock,
        ]);
        return redirect()->route('product-list')->with('success', 'Stock berhasil diperbarui!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Products::findOrFail($id);
        return view('edit-product', compact('product'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Products::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:1',
            'photo_product' => 'image|mimes:jpeg,png,jpg,gif|max:8192' //max 8mb
        ]);

        if ($request->hasFile('photo_product')) {
            $imagePath = $request->file('photo_product')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
        ]);
    

        return redirect()->route('product-list')->with('success', 'Product updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Cek apakah produk memiliki relasi di detail_sales
        $isProductUsed = DetailSales::where('product_id', $id)->exists();
    
        if ($isProductUsed) {
            return redirect()->route('product-list')->with('error', 'Produk tidak bisa dihapus karena sudah masuk transaksi.');
        }
    
        // Jika tidak ada relasi, hapus produk
        products::where('id', $id)->delete();
        
        return redirect()->route('product-list')->with('success', 'Berhasil menghapus produk.');
    }
}
