<?php


namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Music;
use App\Artist;
use App\Album;
use DB;
use App\Http\Controllers\Controller;

class MusicsController extends Controller
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

        $artists = Artist::orderBy('created_at', 'desc')->get();
        $albums = Album::orderBy('created_at', 'desc')->get();
        // dd($);
        return view('admin.musics.index', compact('artists', 'albums'));
        // return view('musics.index')->with('musics', $musics);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);

        // $this->validate($request, [ 
        //     'title' => 'required',
        //     'album_name' => 'nullable',
        // ]);

        // $album = $request->input('albums');
        // $artist = $request->input('artists');
        

        $artists = Artist::orderBy('artist_name', 'asc')->get();

        return view('admin.musics.create', compact('artists'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Input::merge(array_map('trim', Input::all()));
        $this->validate($request, [ 
            'title' => 'required',
            'artists' => 'required',
            'albums' => 'required|unique:albums,album_name',
            'genres' => 'required',
            'cover_image' => 'image|nullable|max:1999|mimes:jpg,png,jpeg',
            'music_song' => 'mimetypes:audio/mp4, audio/mpeg, audio/x-wav|nullable',
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
        ///Handle File Music
        if($request->hasFile('music_song')){
            //Get filename with extension
            $filenameWithExt = $request->file('music_song')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('music_song')->getClientOriginalExtension();
            //Filename to store
            $fileNameToStoreSong = $filename.'_'.time().'.'.$extension;
            //Upload image
            $path = $request->file('music_song')->storeAs('public/music_songs', $fileNameToStoreSong);
        } else {
            $fileNameToStoreSong = 'nosong.png';
        }


        //Create Music
        $artists = new Artist;
        $albums = new Album;
        $musics = new Music;
        

        $album = $request->input('albums');
        $artist = $request->input('artists');
        
        if(Album::where('id', '=', Input::get('albums'))->count() <= 0){ //add new album
           
            $albums->album_name = $album;
            $albums->artist_id = $artist;
            $albums->cover_image = "noimage.jpg";
            $albums->save();


            $lastInsertedId = $albums->id;

            $musics->title = $request->input('title');
            $musics->album_id = $lastInsertedId;
            $musics->genre = $request->input('genres');
            $musics->cover_image = $fileNameToStore;
            $musics->music_song = $fileNameToStoreSong;
            $musics->save();

            return redirect('/admin/musics')->with('success', 'Song & Album Uploaded');
        } 
        else { //no new album

            $musics->title = $request->input('title');
            $musics->album_id = $request->input('albums');
            $musics->genre = $request->input('genres');
            $musics->cover_image = $fileNameToStore;
            $musics->music_song = $fileNameToStoreSong;
            $music->save();
            
            return redirect('/admin/musics')->with('success', 'Song Uploaded');
        }

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createArtist(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        
        $artists = Artist::orderBy('artist_name', 'asc')->get();
        return view('admin.musics.createArtist', compact('artists'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeArtist(Request $request)
    {
        $this->validate($request, [ 
            'artists' => 'required|unique:artists,artist_name',
            'album_name' => 'nullable',
        ]);
        $artist = $request->input('artists');
        $album_names = $request->input('albums');
        
        if (isset($album_names)){
            
            foreach($album_names as $album){
                $albums = new Album;
                $albums->album_name = $album;
                $albums->artist_id = $artist;
                $albums->cover_image = "nocoverimage.jpg";
                $albums->save();
            }
            return redirect('/admin/musics')->with('success', 'Albums Uploaded');

        }
        else{
            $artists = new Artist;
            $artists->artist_name = $artist;
            $artists->save();
            return redirect('/admin/musics')->with('success', 'Artist Uploaded');
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createByAlbum(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);

        // $genres = Genre::orderBy('name', 'asc')->get();
        return view('admin.musics.createByAlbum');
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
        $album = Album::find($id);
        $musics = Music::find($id);
        // $musics = Music::where('album_id', '=', $id)->toJson();
        // dd($musics);
        return view('/admin/musics/show', compact('album', 'musics'));
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
        // dd($movie_genres);


        // Check if it is the current user if not, redirect to posts
        $request->user()->authorizeRoles(['admin']);
        return view('admin.musics.edit', compact('movie', 'genres', 'movie_genres'));
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
            'running_time' => 'required',
            'release_date' => 'required',
            'cast' => 'required',
            'genres' => 'required',
            'cover_image' => 'image|nullable|max:1999|mimes:jpg,png,jpeg',
            'movie_video' => 'mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi|nullable',
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
        }


        //Edit Movie
        $movie = Movie::find($id);
        $movie->title = $request->input('title');
        $movie->movie_description = $request->input('movie_description');
        $movie->cast = $request->input('cast');
        $movie->language = $request->input('language');
        $movie->running_time = $request->input('running_time');
        $movie->release_date = $request->input('release_date');
        if($request->hasFile('cover_image')){
            $movie->cover_image = $fileNameToStore;
        }
        if($request->hasFile('movie_video')){
            $movie->movie_video = $fileNameToStoreVid;
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
        return redirect('/admin/musics')->with('success', 'Movie Updated');
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
        return redirect('/admin/musics')->with('success', 'Movie Removed');
    }
    //     public function get_albums($id)
    // {
    //     //Using Eloquent
    //     $albums = Album::where('artist_id', '=', $id)->toJson();
    //     return $albums;
    //     // $reports = Report::select('id', 'lastName', 'firstName', 'middleName', 'email', 'created_at', 'updated_at');
    //     // return Datatables::of($reports)->make(true);
    // }

    public function json_albums(Request $request){
      $artist_id = $request->id;
    //   $albums = Album::where('artist_id', '=', $artists_id)->get();
        
        $artist = Artist::find($artist_id);
        $data  = $artist->albums->toArray();
        // dd($data);
        
        return $data;
    }
}