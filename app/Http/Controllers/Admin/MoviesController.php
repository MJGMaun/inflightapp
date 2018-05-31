<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Movie;
use App\Http\Controllers\Controller;

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

        $movies = Movie::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.movies.index')->with('movies', $movies);;
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

        return view('admin.movies.create');
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
            'language' => 'required',
            'running_time' => 'required',
            'release_date' => 'required',
            // 'casts' => 'required',
            // 'genres' => 'required',
            'cover_image' => 'image|nullable|max:1999|mimes:jpg,png,jpeg',
            'movie_video' => 'required|mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi|nullable',
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
            //Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
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
            //Filename to store
            $fileNameToStoreVid = $filename.'_'.time().'.'.$extension;
            //Upload image
            $path = $request->file('movie_video')->storeAs('public/movie_videos', $fileNameToStoreVid);
        } else {
            $fileNameToStoreVid = 'noimage.jpg';
        }


        //Create Movie
        $movie = new Movie;
        $movie->title = $request->input('title');
        $movie->movie_description = $request->input('movie_description');
        $movie->language = $request->input('language');
        $movie->running_time = $request->input('running_time');
        $movie->release_date = $request->input('release_date');
        $movie->cover_image = $fileNameToStore;
        $movie->movie_video = $fileNameToStoreVid;
        $movie->save();

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
        $request->user()->authorizeRoles(['passenger', 'admin']);
        return view('movies.show');
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
        public function get_actors()
    {
        //Using Eloquent
        return datatables()->eloquent(Actor::query())->toJson();
        // $reports = Report::select('id', 'lastName', 'firstName', 'middleName', 'email', 'created_at', 'updated_at');
        // return Datatables::of($reports)->make(true);
    }
}
