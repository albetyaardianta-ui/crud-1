<?php

namespace App\Http\Controllers;

use App\Models\Category; 
use App\Models\Product;  
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        return view('product.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:45',
            'category_id' => 'required|exists:categories,id', 
            'price' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $fileName = 'foto-' . uniqid() . '.' . $request->foto->extension();
            $request->foto->move(public_path('image'), $fileName);
        } else {
            $fileName = 'nophoto.jpg';
        }

        
        Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'purchase_price' => $request->purchase_price,
            'description' => $request->description,
            'foto' => $fileName,
        ]);

        return redirect()->route('product.index')->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('product.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:45',
            'category_id' => 'required',
            'price' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $fileName = $product->foto;

        if ($request->hasFile('foto')) {
            if ($product->foto && $product->foto != 'nophoto.jpg' && file_exists(public_path('image/' . $product->foto))) {
                unlink(public_path('image/' . $product->foto));
            }
            $fileName = 'foto-' . $id . '.' . $request->foto->extension();
            $request->foto->move(public_path('image'), $fileName);
        }

        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'purchase_price' => $request->purchase_price,
            'description' => $request->description,
            'foto' => $fileName,
        ]);

        return redirect()->route('product.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
    
        if ($product->foto && $product->foto != 'nophoto.jpg' && file_exists(public_path('image/' . $product->foto))) {
            unlink(public_path('image/' . $product->foto));
        }
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product deleted successfully!');
    }
}