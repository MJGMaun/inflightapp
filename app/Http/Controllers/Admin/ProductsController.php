<?php

namespace App\Http\Controllers\Admin;
use App\ProductCategory;
use App\ProductSubCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request->user()->authorizeRoles(['admin']);
        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $categories = ProductCategory::orderBy('created_at', 'desc')->get();
        $subCcategories = ProductSubCategory::orderBy('created_at', 'desc')->get();
        return view('admin.products.create', compact('categories', 'subCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

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
        //
    }

    /*************************************
                CUSTOM FUNCTIONS
    *************************************/
        public function json_sub_categories(Request $request){
            $category_id = $request->id;
            //   $albums = Album::where('artist_id', '=', $artists_id)->get();
                
                $category = ProductCategory::find($category_id);
                $data  = $category->subcategories->toArray();
                
                return $data;
            }
    /*****************************
                Category
    *****************************/
        public function createCategory(Request $request)
        {
            $request->user()->authorizeRoles(['admin']);

            $categories = ProductCategory::orderBy('created_at', 'desc')->get();

            return view('admin.products.createCategory', compact('categories'));
        }
        public function storeCategory(Request $request)
        {
            $request->user()->authorizeRoles(['admin']);

            $this->validate($request, [ 
                'category' => 'required|unique:product_categories,product_category_name',
                'description' => 'nullable',
            ]);

            $category = new ProductCategory;
            $category->product_category_name = $request->input('category');
            $category->product_category_description = $request->input('description');
            $category->save();

            return redirect('/admin/products/createCategory')->with('success', 'Product Category Added');
        }
        public function editCategory($id, Request $request)
        {
            $category = ProductCategory::find($id);
            $categories = ProductCategory::orderBy('created_at', 'desc')->get();
            return view('/admin/products/editCategory', compact('category', 'categories'));
        }
        public function updateCategory($id, Request $request)
        {
            $category = ProductCategory::find($id);

            $this->validate($request, [ 
                'category' => 'required|unique:product_categories,product_category_name,'.$category->id,
                'description' => 'nullable',
            ]);

            
            $category->product_category_name = $request->input('category');
            $category->product_category_description = $request->input('description');
            $category->save();
            return redirect('/admin/products/createCategory')->with('success', 'Product Category Updated');
        }
        public function destroyCategory($id, Request $request)
        {
            
            $category = ProductCategory::find($id);
            $category->delete();
            return redirect('/admin/products/createCategory')->with('success', 'Product Category Deleted');
        }

    /*****************************
                Sub Category
    *****************************/
        public function createSubCategory(Request $request)
        {
            $request->user()->authorizeRoles(['admin']);

            $categories = ProductCategory::orderBy('created_at', 'desc')->get();
            $subCategories = ProductSubCategory::orderBy('created_at', 'desc')->get();
            



            return view('admin.products.createSubCategory', compact('categories', 'subCategories'));
        }
        public function storeSubCategory(Request $request)
        {
            $request->user()->authorizeRoles(['admin']);

            $this->validate($request, [ 
                'category' => 'required',
                'subCategoryName' => 'required|unique:product_sub_categories,product_sub_category_name',
            ]);

            $subCategory = new ProductSubCategory;
            $subCategory->product_category_id = $request->input('category');
            $subCategory->product_sub_category_name = $request->input('subCategoryName');
            $subCategory->save();

            return redirect('/admin/products/createSubCategory')->with('success', 'Product Sub Category Added');
        }
        public function editSubCategory($id, Request $request)
        {
            $subCategory = ProductSubCategory::find($id);

            $categories = ProductCategory::orderBy('created_at', 'desc')->get();
            $subCategories = ProductSubCategory::orderBy('created_at', 'desc')->get();
            return view('/admin/products/editSubCategory', compact('subCategory', 'categories', 'subCategories'));
        }
        public function updateSubCategory($id, Request $request)
        {
            $subCategory = ProductSubCategory::find($id);

            $this->validate($request, [ 
                'category' => 'required',
                'subCategoryName' => 'required|unique:product_sub_categories,product_sub_category_name,'.$subCategory->id,
            ]);

            
            $subCategory->product_category_id = $request->input('category');
            $subCategory->product_sub_category_name = $request->input('subCategoryName');
            $subCategory->save();
            return redirect('/admin/products/createSubCategory')->with('success', 'Product Sub Category Updated');
        }
        public function destroySubCategory($id, Request $request)
        {      
            $subCategory = ProductSubCategory::find($id);
            $subCategory->delete();
            return redirect('/admin/products/createSubCategory')->with('success', 'Product Sub Category Deleted');
        }


}
