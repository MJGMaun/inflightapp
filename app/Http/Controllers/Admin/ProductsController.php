<?php

namespace App\Http\Controllers\Admin;
use App\Product;
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
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $products = Product::orderBy('created_at', 'desc')->get();
        return view('admin.products.index', compact('products'));
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
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);

            $this->validate($request, [ 
                'productCategory' => 'required|max:190',
                'productSubCategory' => 'required|max:190',
                'productName' => 'required|unique:products,product_name|max:190',
                'productCompany' => 'required|max:190',
                'productPriceBefore' => 'required|regex:/^\d*(\.\d{1,2})?$/|max:190',
                'productPriceAfter' => 'required|regex:/^\d*(\.\d{1,2})?$/|max:190',
                'productPriceToken' => 'required|regex:/^\d*(\.\d{1,2})?$/|max:190',
                'productDescription' => 'required|max:190',
                'productImage1' => 'required|image|mimes:jpeg,jpg,png',
                'productImage2' => 'nullable|image|mimes:jpeg,jpg,png',
                'productImage3' => 'nullable|image|mimes:jpeg,jpg,png',
                'productImage4' => 'nullable|image|mimes:jpeg,jpg,png',
            ]);
                
            //Handle File Cover Image 1
            if($request->hasFile('productImage1')){
                //Get filename with extension
                $filenameWithExt = $request->file('productImage1')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                //Get just ext
                $extension = $request->file('productImage1')->getClientOriginalExtension();
                //Clean filename (Replace white spaces with hyphens)
                $cleanFilename = str_replace(' ', '-', $filename);
                //Cleaner filename
                $cleanerFilename =  preg_replace('/-+/', '-', $cleanFilename);
                //Filename to store
                $fileNameToStore1 = $cleanerFilename.'_'.time().'.'.$extension;
                //Upload image
                $path = $request->file('productImage1')->storeAs('public/product_images', $fileNameToStore1);
            } else {
                $fileNameToStore1 = 'noimage.jpg';
            }
            
            //Handle File Cover Image 2
            if($request->hasFile('productImage2')){
                //Get filename with extension
                $filenameWithExt = $request->file('productImage2')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                //Get just ext
                $extension = $request->file('productImage2')->getClientOriginalExtension();
                //Clean filename (Replace white spaces with hyphens)
                $cleanFilename = str_replace(' ', '-', $filename);
                //Cleaner filename
                $cleanerFilename =  preg_replace('/-+/', '-', $cleanFilename);
                //Filename to store
                $fileNameToStore2 = $cleanerFilename.'_'.time().'.'.$extension;
                //Upload image
                $path = $request->file('productImage2')->storeAs('public/product_images', $fileNameToStore2);
            } else {
                $fileNameToStore2 = 'noimage.jpg';
            }
            
            //Handle File Cover Image 3
            if($request->hasFile('productImage3')){
                //Get filename with extension
                $filenameWithExt = $request->file('productImage3')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                //Get just ext
                $extension = $request->file('productImage3')->getClientOriginalExtension();
                //Clean filename (Replace white spaces with hyphens)
                $cleanFilename = str_replace(' ', '-', $filename);
                //Cleaner filename
                $cleanerFilename =  preg_replace('/-+/', '-', $cleanFilename);
                //Filename to store
                $fileNameToStore3 = $cleanerFilename.'_'.time().'.'.$extension;
                //Upload image
                $path = $request->file('productImage3')->storeAs('public/product_images', $fileNameToStore3);
            } else {
                $fileNameToStore3 = 'noimage.jpg';
            }

            //Handle File Cover Image 4
            if($request->hasFile('productImage4')){
                //Get filename with extension
                $filenameWithExt = $request->file('productImage4')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                //Get just ext
                $extension = $request->file('productImage4')->getClientOriginalExtension();
                //Clean filename (Replace white spaces with hyphens)
                $cleanFilename = str_replace(' ', '-', $filename);
                //Cleaner filename
                $cleanerFilename =  preg_replace('/-+/', '-', $cleanFilename);
                //Filename to store
                $fileNameToStore4 = $cleanerFilename.'_'.time().'.'.$extension;
                //Upload image
                $path = $request->file('productImage4')->storeAs('public/product_images', $fileNameToStore3);
            } else {
                $fileNameToStore4 = 'noimage.jpg';
            }


            $product = new Product;
            $product->product_category_id = $request->input('productCategory');
            $product->product_sub_category_id = $request->input('productSubCategory');
            $product->product_name = $request->input('productName');
            $product->product_company= $request->input('productCompany');
            $product->product_price_before_discount = number_format($request->input('productPriceBefore'));
            $product->product_price = number_format($request->input('productPriceAfter'));
            $product->product_price_token = number_format($request->input('productPriceToken'));
            $product->product_description = $request->input('productDescription');
            $product->product_image_1 = $fileNameToStore1;
            $product->product_image_2 = $fileNameToStore2;
            $product->product_image_3 = $fileNameToStore3;
            $product->product_image_4 = $fileNameToStore4;

            $product->save();

            return redirect('/admin/products/create')->with('success', 'Product Added');

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
    public function edit($id, Request $request)
    {
        $request->user()->authorizeRoles(['admin']);

        $product = Product::find($id);
        $productPrice = preg_replace('/[^A-Za-z0-9\-]/', '', $product->product_price);
        $productPriceBefore = preg_replace('/[^A-Za-z0-9\-]/', '', $product->product_price_before_discount);
        $categories = ProductCategory::orderBy('created_at', 'desc')->get();
        $subCategories = ProductSubCategory::orderBy('created_at', 'desc')->get();

        return view('/admin/products/edit', compact('product', 'categories', 'subCategories', 'productPriceBefore', 'productPrice'));
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
        $request->user()->authorizeRoles(['admin']);
            $product = Product::find($id);

            $this->validate($request, [ 
                'productCategory' => 'required|max:190',
                'productSubCategory' => 'required|max:190',
                'productName' => 'required|max:190|unique:products,product_name,'.$product->id,
                'productCompany' => 'required|max:190',
                'productPriceBefore' => 'required|regex:/^\d*(\.\d{1,2})?$/|max:190',
                'productPriceAfter' => 'required|regex:/^\d*(\.\d{1,2})?$/|max:190',
                'productPriceToken' => 'required|regex:/^\d*(\.\d{1,2})?$/|max:190',
                'productDescription' => 'required|max:190',
                'productImage1' => 'nullable|image|mimes:jpeg,jpg,png',
                'productImage2' => 'nullable|image|mimes:jpeg,jpg,png',
                'productImage3' => 'nullable|image|mimes:jpeg,jpg,png',
                'productImage4' => 'nullable|image|mimes:jpeg,jpg,png',
            ]);
                
            //Handle File Cover Image 1
            if($request->hasFile('productImage1')){
                //Get filename with extension
                $filenameWithExt = $request->file('productImage1')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                //Get just ext
                $extension = $request->file('productImage1')->getClientOriginalExtension();
                //Clean filename (Replace white spaces with hyphens)
                $cleanFilename = str_replace(' ', '-', $filename);
                //Cleaner filename
                $cleanerFilename =  preg_replace('/-+/', '-', $cleanFilename);
                //Filename to store
                $fileNameToStore1 = $cleanerFilename.'_'.time().'.'.$extension;
                //Upload image
                $path = $request->file('productImage1')->storeAs('public/product_images', $fileNameToStore1);
            }
            
            //Handle File Cover Image 2
            if($request->hasFile('productImage2')){
                //Get filename with extension
                $filenameWithExt = $request->file('productImage2')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                //Get just ext
                $extension = $request->file('productImage2')->getClientOriginalExtension();
                //Clean filename (Replace white spaces with hyphens)
                $cleanFilename = str_replace(' ', '-', $filename);
                //Cleaner filename
                $cleanerFilename =  preg_replace('/-+/', '-', $cleanFilename);
                //Filename to store
                $fileNameToStore2 = $cleanerFilename.'_'.time().'.'.$extension;
                //Upload image
                $path = $request->file('productImage2')->storeAs('public/product_images', $fileNameToStore2);
            }
            
            //Handle File Cover Image 3
            if($request->hasFile('productImage3')){
                //Get filename with extension
                $filenameWithExt = $request->file('productImage3')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                //Get just ext
                $extension = $request->file('productImage3')->getClientOriginalExtension();
                //Clean filename (Replace white spaces with hyphens)
                $cleanFilename = str_replace(' ', '-', $filename);
                //Cleaner filename
                $cleanerFilename =  preg_replace('/-+/', '-', $cleanFilename);
                //Filename to store
                $fileNameToStore3 = $cleanerFilename.'_'.time().'.'.$extension;
                //Upload image
                $path = $request->file('productImage3')->storeAs('public/product_images', $fileNameToStore3);
            }

            //Handle File Cover Image 3
            if($request->hasFile('productImage4')){
                //Get filename with extension
                $filenameWithExt = $request->file('productImage4')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                //Get just ext
                $extension = $request->file('productImage4')->getClientOriginalExtension();
                //Clean filename (Replace white spaces with hyphens)
                $cleanFilename = str_replace(' ', '-', $filename);
                //Cleaner filename
                $cleanerFilename =  preg_replace('/-+/', '-', $cleanFilename);
                //Filename to store
                $fileNameToStore4 = $cleanerFilename.'_'.time().'.'.$extension;
                //Upload image
                $path = $request->file('productImage4')->storeAs('public/product_images', $fileNameToStore3);
            }

            $product->product_category_id = $request->input('productCategory');
            $product->product_sub_category_id = $request->input('productSubCategory');
            $product->product_name = $request->input('productName');
            $product->product_company= $request->input('productCompany');
            $product->product_price_before_discount = number_format($request->input('productPriceBefore'));
            $product->product_price = number_format($request->input('productPriceAfter'));
            $product->product_price_token = number_format($request->input('productPriceToken'));
            $product->product_description = $request->input('productDescription');
            if($request->hasFile('productImage1')){
                if($product->product_image_1 != 'noimage.jpg'){
                    // Delete Image
                    Storage::delete('public/product_images/'.$product->product_image_1);
                }
                $product->product_image_1 = $fileNameToStore1;
            }
            if($request->hasFile('productImage2')){
                if($product->product_image_2 != 'noimage.jpg'){
                    // Delete Image
                    Storage::delete('public/product_images/'.$product->product_image_2);
                }
                $product->product_image_2 = $fileNameToStore2;
            }
            if($request->hasFile('productImage3')){
                if($product->product_image_3 != 'noimage.jpg'){
                    // Delete Image
                    Storage::delete('public/product_images/'.$product->product_image_3);
                }
                $product->product_image_3 = $fileNameToStore3;
            }
            if($request->hasFile('productImage4')){
                if($product->product_image_4 != 'noimage.jpg'){
                    // Delete Image
                    Storage::delete('public/product_images/'.$product->product_image_4);
                }
                $product->product_image_4 = $fileNameToStore4;
            }

            $product->save();

            return redirect('/admin/products/')->with('success', 'Product '.$product->product_name.' Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $product = Product::find($id);

        if($product->product_image_1 != 'noimage.jpg'){
            // Delete Image
            Storage::delete('public/product_images/'.$product->product_image_1);
        }
        if($product->product_image_2 != 'noimage.jpg'){
            // Delete Image
            Storage::delete('public/product_images/'.$product->product_image_2);
        }
        if($product->product_image_3 != 'noimage.jpg'){
            // Delete Image
            Storage::delete('public/product_images/'.$product->product_image_3);
        }

        $product->delete();
        return redirect('/admin/products')->with('success', 'Product Removed');
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
                'category' => 'required|unique:product_categories,product_category_name|max:190',
                'description' => 'nullable|max:190',
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
                'category' => 'required|max:190|unique:product_categories,product_category_name,'.$category->id,
                'description' => 'nullable|max:190',
            ]);

            
            $category->product_category_name = $request->input('category');
            $category->product_category_description = $request->input('description');
            $category->save();
            return redirect('/admin/products/createCategory')->with('success', 'Product Category Updated');
        }
        public function destroyCategory($id, Request $request)
        {
            
            $category = ProductCategory::find($id);
            if(count($category->subcategories)){
                $category->subcategories()->delete();
            }
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
                'category' => 'required|max:190',
                'subCategoryName' => 'required|unique:product_sub_categories,product_sub_category_name|max:190',
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
                'category' => 'required|max:190',
                'subCategoryName' => 'required|max:190|unique:product_sub_categories,product_sub_category_name,'.$subCategory->id,
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
