<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua kategori untuk dropdown
        $categories = Category::all();

        // Inisialisasi query dengan eager loading kategori
        $query = Product::with('category');

        // Filter berdasarkan pencarian nama produk jika ada
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan kategori jika dipilih
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Paginate produk untuk menghindari pengambilan semua data sekaligus
        $products = $query->paginate(10);

        // Kirim data produk dan kategori ke view
        return view('product.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all(); // Ambil semua kategori
        return view('product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = new Product($request->all());

        if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('products', 'public');
        }

        $product->save($validatedData);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');;
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('product.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validatedData);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diubah.');;
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');;
    }
}
