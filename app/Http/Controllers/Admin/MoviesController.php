<?php

namespace App\Http\Controllers\admin;

use App\Genre;
use App\Movie;
use App\MovieCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class MoviesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
  public function __construct()
  {
    $this->middleware('auth');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $request->user()->authorizeRoles(['admin']);

        $movies = Movie::orderBy('created_at', 'desc')->get();
        return view('admin.movies.index', compact('movies'));
        // return view('movies.index')->with('movies', $movies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);

        $genres = Genre::orderBy('name', 'asc')->get();
        $categories = MovieCategory::all()->pluck('movie_category_name','id');
        return view('admin.movies.create', compact('genres', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [ 
            'title' => 'required',
            'director' => 'required',
            'contentRating' => 'contentRating',
            'category' => 'required',
            'ewallet_price' => 'required|regex:/^\d*(\.\d{1,2})?$/|max:190',
            // 'token_price' => 'required|regex:/^\d*(\.\d{1,2})?$/|max:190',
            'running_time' => 'required',
            'release_date' => 'required',
            'cast' => 'required|max:190',
            'genres' => 'required',
            'cover_image' => 'nullable|image|mimes:jpeg,jpg,png',
            'movie_video' => 'mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi|required',
            'trailer_video' => 'mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi|required',
            'movie_description' => 'required',
        ]);

        //Handle File Cover Image
        if($request->hasFile('cover_image')){
            //Get filename with extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //Clean filename (Replace white spaces with hyphens)
            $cleanFilename = str_replace(' ', '-', $filename);
            //Cleaner filename
            $cleanerFilename =  preg_replace('/-+/', '-', $cleanFilename);
            //Filename to store
            $fileNameToStore = $cleanerFilename.'_'.time().'.'.$extension;
            //Upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }
        //Handle File Movie
        if($request->hasFile('movie_video')){
            //Get filename with extension
            $filenameWithExt = $request->file('movie_video')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('movie_video')->getClientOriginalExtension();
            //Clean filename (Replace white spaces with hyphens)
            $cleanFilename = str_replace(' ', '-', $filename);
            //Cleaner filename
            $cleanerFilename =  preg_replace('/-+/', '-', $cleanFilename);
            //Filename to store
            $fileNameToStoreVid = $cleanerFilename.'_'.time().'.'.$extension;
            //Upload image
            $path = $request->file('movie_video')->storeAs('public/movie_videos', $fileNameToStoreVid);
        } else {
            $fileNameToStoreVid = 'novideo.png';
        }

        //Handle File Trailer
        if($request->hasFile('trailer_video')){
            //Get filename with extension
            $filenameWithExt = $request->file('trailer_video')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('trailer_video')->getClientOriginalExtension();
            //Clean filename (Replace white spaces with hyphens)
            $cleanFilename = str_replace(' ', '-', $filename);
            //Cleaner filename
            $cleanerFilename =  preg_replace('/-+/', '-', $cleanFilename);
            //Filename to store
            $fileNameToStoreVidTrailer = $cleanerFilename.'_'.time().'.'.$extension;
            //Upload image
            $path = $request->file('trailer_video')->storeAs('public/trailer_videos', $fileNameToStoreVidTrailer);
        } else {
            $fileNameToStoreVid = 'novideo.png';
        }


        //Create Movie
        $movie = new Movie;
        $movie->title = $request->input('title');
        $movie->movie_description = $request->input('movie_description');
        $movie->cast = $request->input('cast');
        $movie->content_rating = $request->input('contentRating');
        $movie->director = $request->input('director');
        $movie->category_id = $request->input('category');
        $movie->ewallet_price = number_format($request->input('ewallet_price'));
        $movie->token_price = 10;
        $movie->language = $request->input('language');
        $movie->running_time = $request->input('running_time');
        $movie->release_date = $request->input('release_date');
        $movie->cover_image = $fileNameToStore;
        $movie->movie_video = $fileNameToStoreVid;
        $movie->trailer_video = $fileNameToStoreVidTrailer;
        $movie->save();

        $genres = $request->input('genres');
        
        foreach($genres as $genre){
            $movie
            ->genres()
            ->attach(Genre::where('name', $genre)->first());
        }

        return redirect('/admin/movies')->with('success', 'Movie Uploaded');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        return view('movies.show');
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
        $movie = Movie::find($id);
        $genres = Genre::orderBy('name', 'asc')->get();
        $movie_genres  = $movie->genres->pluck('name')->toArray();
        $categories = MovieCategory::all()->pluck('movie_category_name','id');
        $moviePriceEWallet = preg_replace('/[^A-Za-z0-9\-]/', '', $movie->ewallet_price);
        $moviePriceToken = preg_replace('/[^A-Za-z0-9\-]/', '', $movie->token_price);

        $request->user()->authorizeRoles(['admin']);
        return view('admin.movies.edit', compact('movie', 'genres', 'movie_genres', 'categories', 'moviePriceEWallet', 'moviePriceToken'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $this->validate($request, [ 
            'title' => 'required',
            'language' => 'required',
            'director' => 'required',
            'contentRating' => 'contentRating',
            'category' => 'required',
            'ewallet_price' => 'required|regex:/^\d*(\.\d{1,2})?$/|max:190',
            // 'token_price' => 'required|regex:/^\d*(\.\d{1,2})?$/|max:190',
            'running_time' => 'required',
            'release_date' => 'required',
            'cast' => 'required|max:190',
            'genres' => 'required',
            'cover_image' => 'image|nullable|mimes:jpg,png,jpeg',
            'movie_video' => 'mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi|nullable',
            'trailer_video' => 'mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi|nullable',
            'movie_description' => 'required',
        ]);

        //Handle File Cover Image
        if($request->hasFile('cover_image')){
            //Get filename with extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //Clean filename (Replace white spaces with hyphens)
            $cleanFilename = str_replace(' ', '-', $filename);
            //Cleaner filename
            $cleanerFilename =  preg_replace('/-+/', '-', $cleanFilename);
            //Filename to store
            $fileNameToStore = $cleanerFilename.'_'.time().'.'.$extension;
            //Upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }
        //Handle File Movie
        if($request->hasFile('movie_video')){
            //Get filename with extension
            $filenameWithExt = $request->file('movie_video')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('movie_video')->getClientOriginalExtension();
            //Clean filename (Replace white spaces with hyphens)
            $cleanFilename = str_replace(' ', '-', $filename);
            //Cleaner filename
            $cleanerFilename =  preg_replace('/-+/', '-', $cleanFilename);
            //Filename to store
            $fileNameToStoreVid = $cleanerFilename.'_'.time().'.'.$extension;
            //Upload image
            $path = $request->file('movie_video')->storeAs('public/movie_videos', $fileNameToStoreVid);
        }


        //Handle File Trailer
        if($request->hasFile('trailer_video')){
            //Get filename with extension
            $filenameWithExt = $request->file('trailer_video')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('trailer_video')->getClientOriginalExtension();
            //Clean filename (Replace white spaces with hyphens)
            $cleanFilename = str_replace(' ', '-', $filename);
            //Cleaner filename
            $cleanerFilename =  preg_replace('/-+/', '-', $cleanFilename);
            //Filename to store
            $fileNameToStoreVidTrailer = $cleanerFilename.'_'.time().'.'.$extension;
            //Upload image
            $path = $request->file('trailer_video')->storeAs('public/trailer_videos', $fileNameToStoreVidTrailer);
        }


        //Edit Movie
        $movie = Movie::find($id);
        $movie->title = $request->input('title');
        $movie->movie_description = $request->input('movie_description');
        $movie->cast = $request->input('cast');
        $movie->content_rating = $request->input('contentRating');
        $movie->director = $request->input('director');
        $movie->category_id = $request->input('category');
        $movie->ewallet_price = number_format($request->input('ewallet_price'));
        $movie->token_price = 10;
        $movie->language = $request->input('language');
        $movie->running_time = $request->input('running_time');
        $movie->release_date = $request->input('release_date');
        if($request->hasFile('cover_image')){
            if($movie->cover_image != 'noimage.jpg'){
            // Delete Image
            Storage::delete('public/cover_images/'.$movie->cover_image);
            }
            $movie->cover_image = $fileNameToStore;
        }
        if($request->hasFile('movie_video')){
            if($movie->movie_video != 'novideo.jpg'){
            // Delete Image
            Storage::delete('public/movie_videos/'.$movie->movie_video);
            }
            $movie->movie_video = $fileNameToStoreVid;
        }
        if($request->hasFile('trailer_video')){
            if($movie->movie_video != 'novideo.jpg'){
            // Delete Image
            Storage::delete('public/movie_videos/'.$movie->movie_video);
            }
            $movie->trailer_video = $fileNameToStoreVidTrailer;
        }
        $movie->save();
        $genres = $request->input('genres');
        $movie_genres_name  = $movie->genres->pluck('name')->toArray();
        $movie_genres = $movie->genres;
        // dd($movie_genres);

        $movie->genres()->detach();

        foreach($genres as $genre){
            $movie
            ->genres()
            ->attach(Genre::where('name', $genre)->first());
        }


        
        // foreach($movie_genres as $genre){
        //     if(in_array($genre, $genres)){
        //     }
        //     else{
        //         // $movie
        //         // ->genres()
        //         // ->attach(Genre::where('name', $genre)->first());
        //         $movie->genres()->wherePivot('genre_id', '=', $genre->id)->detach();
        //     }
        // }
        // foreach($genres as $genre){
        //     if(in_array($genre, $movie_genres_name)){
            
        //     }
        //     else{
        //         $movie
        //         ->genres()
        //         ->attach(Genre::where('name', $genre)->first());
        //     }
        // }
        return redirect('/admin/movies')->with('success', 'Movie Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $movie = Movie::find($id);
        $movie->genres()->detach();

        $request->user()->authorizeRoles(['admin']);
        if($movie->cover_image != 'noimage.jpg'){
            // Delete Image
            Storage::delete('public/cover_images/'.$movie->cover_image);
        }
        if($movie->movie_videos != 'novideo.jpg'){
            // Delete Image
            Storage::delete('public/movie_videos/'.$movie->movie_video);
        }

        $movie->delete();
        return redirect('/admin/movies')->with('success', 'Movie Removed');
    }
        /*****************************
                Custom Functions
        *****************************/
        public function json_category_price(Request $request){
                $category_id = $request->id;
                
                $category = MovieCategory::find($category_id);
                // $data  = $category->pluck('movie_category_price_ewallet', 'movie_category_price_token')->toArray();

                $data = array();

                $data['ewallet'] = preg_replace('/[^A-Za-z0-9\-]/', '', $category->movie_category_price_ewallet);
                $data['token'] = preg_replace('/[^A-Za-z0-9\-]/', '', $category->movie_category_price_token);

                return $data;
            }

        /*****************************
                Category
        *****************************/
        public function createCategory(Request $request)
        {
            $request->user()->authorizeRoles(['admin']);

            $categories = MovieCategory::orderBy('created_at', 'desc')->get();

            return view('admin.movies.createCategory', compact('categories'));
        }
        public function storeCategory(Request $request)
        {
            $request->user()->authorizeRoles(['admin']);

            $this->validate($request, [ 
                'category' => 'required|unique:movie_categories,movie_category_name|max:190',
                'moviePriceEWallet' => 'required|regex:/^\d*(\.\d{1,2})?$/|max:190',
                'moviePriceToken' => 'required|regex:/^\d*(\.\d{1,2})?$/|max:190',
                'description' => 'nullable|max:190',
            ]);

            $category = new MovieCategory;
            $category->movie_category_name = $request->input('category');
            $category->movie_category_price_ewallet = number_format($request->input('moviePriceEWallet'));
            $category->movie_category_price_token = number_format($request->input('moviePriceToken'));
            $category->movie_category_description = $request->input('description');
            $category->save();

            return redirect('/admin/movies/createCategory')->with('success', 'Movie Category Added');
        }
        public function editCategory($id, Request $request)
        {
            $category = MovieCategory::find($id);
            $movieCategoryPriceEWallet = preg_replace('/[^A-Za-z0-9\-]/', '', $category->movie_category_price_ewallet);
            $movieCategoryPriceToken = preg_replace('/[^A-Za-z0-9\-]/', '', $category->movie_category_price_token);
            $categories = MovieCategory::orderBy('created_at', 'desc')->get();
            return view('/admin/movies/editCategory', compact('category', 'categories', 'movieCategoryPriceEWallet', 'movieCategoryPriceToken'));
        }
        public function updateCategory($id, Request $request)
        {
            $category = MovieCategory::find($id);

            $this->validate($request, [ 
                'category' => 'required|max:190|unique:movie_categories,movie_category_name,'.$category->id,
                'moviePriceEWallet' => 'required|regex:/^\d*(\.\d{1,2})?$/|max:190',
                'moviePriceToken' => 'required|regex:/^\d*(\.\d{1,2})?$/|max:190',
                'description' => 'nullable|max:190',
            ]);

            
            $category->movie_category_name = $request->input('category');
            $category->movie_category_price_ewallet = number_format($request->input('moviePriceEWallet'));
            $category->movie_category_price_token = number_format($request->input('moviePriceToken'));
            $category->movie_category_description = $request->input('description');
            $category->save();
            return redirect('/admin/movies/createCategory')->with('success', 'Movie Category Updated');
        }
        public function destroyCategory($id, Request $request)
        {
            
            $category = MovieCategory::find($id);
            if(count($category->subcategories)){
                $category->subcategories()->delete();
            }
            $category->delete();
            return redirect('/admin/movies/createCategory')->with('success', 'Movie Category Deleted');
        }
}
