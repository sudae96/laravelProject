<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product; //model
use App\Category;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name','id');  //gets only name and id only from table
        return view('admin.product.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formInput = $request->except('image');  //get all except image
        //  echo "<pre>";
        // print_r($formInput);
        // echo "</pre>";exit;
        //validate
        $this->validate($request,[
            'name'=>'required',
            'size'=>'required',
            'price'=>'required',
            'image'=>'image|mimes:jpg,jpeg,png|max:10000'
        ]);

        //imageUpload
        $image = $request->image;

        if($image)
        {
            $imageName = $image->getClientOriginalName();
            $image->move('images',$imageName);  //move to images folder which is inside publicFolder
            $formInput['image'] = $imageName;
        }
        //Product::create($request->all());
        Product::create($formInput);

        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::destroy($id);
        return back();
    }
}
