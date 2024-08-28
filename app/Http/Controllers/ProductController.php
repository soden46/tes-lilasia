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

        // Cek apakah parameter search ada dan tidak kosong
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;

            $query->where(function ($q) use ($searchTerm) {
                // Jika searchTerm adalah angka, cari di kolom id
                if (is_numeric($searchTerm)) {
                    $q->where('id', $searchTerm);
                } else {
                    // Jika searchTerm bukan angka, cari di kolom name
                    $q->where('name', 'like', '%' . $searchTerm . '%');
                }
            });
        }

        // Cek apakah parameter id ada dan tidak kosong
        if ($request->has('id') && $request->id != '') {
            $query->where('id', $request->id);
        }

        // Filter berdasarkan kategori jika dipilih
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Paginate produk untuk menghindari pengambilan semua data sekaligus
        $products = $query->paginate(5);

        // Cek apakah request adalah JSON (untuk API)
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['message' => 'Anda Melihat Produk', 'product' => $products], 200, [], JSON_PRETTY_PRINT);
        }

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
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = new Product($validatedData);

        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();

        // Cek apakah request adalah JSON (untuk API)
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['message' => 'Product berhasil ditambahkan', 'product' => $product], 200, [], JSON_PRETTY_PRINT);
        }

        // Redirect ke view
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
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

        // Cek apakah request adalah JSON (untuk API)
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['message' => 'Product berhasil diupdate', 'product' => $product], 200, [], JSON_PRETTY_PRINT);
        }

        // Redirect ke view
        return redirect()->route('products.index')->with('success', 'Produk berhasil diupdate.');
    }

    public function destroy(Request $request, $id)
    {

        $product = Product::find($id);
        // dd($product);
        $product->delete();
        // Cek apakah request adalah JSON (untuk API)
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['message' => 'Product berhasil dihapus', 'product' => $product], 200, [], JSON_PRETTY_PRINT);
        }

        // Redirect ke view
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }

    // Function Tampilan User
    public function user(Request $request)
    {
        // Ambil semua kategori untuk dropdown
        $categories = Category::all();

        // Inisialisasi query dengan eager loading kategori
        $query = Product::with('category');

        // Cek apakah parameter search ada dan tidak kosong
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;

            $query->where(function ($q) use ($searchTerm) {
                // Jika searchTerm adalah angka, cari di kolom id
                if (is_numeric($searchTerm)) {
                    $q->where('id', $searchTerm);
                } else {
                    // Jika searchTerm bukan angka, cari di kolom name
                    $q->where('name', 'like', '%' . $searchTerm . '%');
                }
            });
        }

        // Cek apakah parameter id ada dan tidak kosong
        if ($request->has('id') && $request->id != '') {
            $query->where('id', $request->id);
        }

        // Filter berdasarkan kategori jika dipilih
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Paginate produk untuk menghindari pengambilan semua data sekaligus
        $products = $query->paginate(5);

        // Cek apakah request adalah JSON (untuk API)
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['message' => 'Anda Melihat Produk', 'product' => $products], 200, [], JSON_PRETTY_PRINT);
        }

        // Kirim data produk ke view
        return view('user.product', compact('products', 'categories'));
    }
}
