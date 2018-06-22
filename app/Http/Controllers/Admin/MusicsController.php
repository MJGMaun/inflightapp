<?php


namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;
use App\Music;
use App\Artist;
use App\Album;
use App\CoverImage;
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
        $songs = Music::orderBy('created_at', 'desc')->get();

        return view('admin.musics.index', compact('artists', 'albums', 'songs'));
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
            'cover_image' => 'nullable|image|mimes:jpeg,jpg,png',
            'music_song' => 'required|mimes:mpga,wav',
        ]);

        //Handle File Cover Image
        if($request->hasFile('cover_image')){
            //Get filename with extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Clean filename (Replace white spaces with hyphens)
            $cleanFilename = str_replace(' ', '-', $filename);
            //Cleaner filename
            $cleanerFilename =  preg_replace('/-+/', '-', $cleanFilename);
            //Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //Filename to store
            $fileNameToStore = $cleanerFilename.'_'.time().'.'.$extension;
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
            //Clean filename (Replace white spaces with hyphens)
            $cleanFilename = str_replace(' ', '-', $filename);
            //Cleaner filename
            $cleanerFilename =  preg_replace('/-+/', '-', $cleanFilename);
            //Get just ext
            $extension = $request->file('music_song')->getClientOriginalExtension();
            //Filename to store
            $fileNameToStoreSong = $cleanerFilename.'_'.time().'.'.$extension;
            //Upload image
            $path = $request->file('music_song')->storeAs('public/music_songs', $fileNameToStoreSong);
        }



        //Create Music
        $artists = new Artist;
        $album = new Album;
        $musics = new Music;
        

        $album = $request->input('albums');
        $artist = $request->input('artists');
        
        if(Album::where('id', '=', Input::get('albums'))->count() <= 0){ //add new album
           

            $coverImage = new CoverImage;
            $coverImage->cover_image = $fileNameToStore;
            $coverImage->save();

            $lastInsertedIdCover = $coverImage->id;


            $album->album_name = $album;
            $album->artist_id = $artist;
            $album->cover_image_id = $lastInsertedIdCover;
            $album->save();


            $lastInsertedId = $album->id;

            $musics->title = $request->input('title');
            $musics->album_id = $lastInsertedId;
            $musics->genre = $request->input('genres');
            $musics->cover_image = $lastInsertedIdCover;
            $musics->music_song = $fileNameToStoreSong;
            $musics->save();

            return redirect('/admin/musics')->with('success', 'Song & Album Uploaded');
        } 
        else { //no new album

            $coverImage = new CoverImage;
            $coverImage->cover_image = $fileNameToStore;
            $coverImage->save();

            $lastInsertedId = $coverImage->id;

            $musics->title = $request->input('title');
            $musics->album_id = $request->input('albums');
            $musics->genre = $request->input('genres');
            $musics->cover_image_id = $lastInsertedId;
            $musics->music_song = $fileNameToStoreSong;
            $musics->save();
            
            return redirect('/admin/musics')->with('success', 'Song Uploaded');
        }

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

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
        $artist = Artist::find($album->artist_id);
        $musics = Music::where('album_id', '=', $id);
        // $musics = Music::where('album_id', '=', $id)->toJson();
        // dd($musics);
        return view('/admin/musics/show', compact('album', 'musics', 'artist', 'musics'));
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
        $music = Music::find($id);
        $genres = array('OPM', 'Pop', 'R&B', 'Hip-Hop', 'Rock', 'Jazz');

        // $genres = Genre::orderBy('name', 'asc')->get();
        // $movie_genres  = $movie->genres->pluck('name')->toArray();

        
        $request->user()->authorizeRoles(['admin']);
        return view('admin.musics.edit', compact('music', 'genres'));
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
        $music = Music::find($id);

        $albumId = $music->albums->id;
        // dd($albumId);
        $request->user()->authorizeRoles(['admin']);
        $this->validate($request, [ 
            'title' => 'required',
            'genre' => 'required',
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
        if($request->hasFile('music_song')){
            //Get filename with extension
            $filenameWithExt = $request->file('music_song')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('music_song')->getClientOriginalExtension();
            //Clean filename (Replace white spaces with hyphens)
            $cleanFilename = str_replace(' ', '-', $filename);
            //Cleaner filename
            $cleanerFilename =  preg_replace('/-+/', '-', $cleanFilename);
            //Filename to store
            $fileNameToStoreSong = $cleanerFilename.'_'.time().'.'.$extension;
            //Upload image
            $path = $request->file('music_song')->storeAs('public/music_songs', $fileNameToStoreSong);
        }


        //Update Music
            
        $music->title = $request->input('title');
        $music->genre = $request->input('genre');

        if($request->hasFile('cover_image')){
            $coverimage = new CoverImage;

            $coverimage->cover_image = $fileNameToStore;
            $coverimage->save();

            $lastInsertedId = $coverimage->id;
            
            $music->cover_image_id = $lastInsertedId;
        }
        if($request->hasFile('music_song')){
            $music->music_song = $fileNameToStoreSong;
        }
        $music->save();


        return redirect('/admin/musics/'.$albumId)->with('success', 'Song Updated');
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
        $song = Music::find($id);
        $albumId = $song->album_id;
        $album = Album::find($albumId);

            if($song->cover_image_id != $album->cover_image_id){
                    // Delete Song
                    Storage::delete('public/cover_images/'.$song->coverimage->cover_image);
                    $song->coverimage()->delete();
            }

            if($song->music_song != 'nosong.jpg'){
                // Delete Song
                Storage::delete('public/music_songs/'.$song->music_song);
            }

        $song->delete();
        return redirect('/admin/musics/'.$albumId)->with('success', 'Music Removed');
    }

    // CUSTOM FUNCTIONS

    public function json_albums(Request $request){
      $artist_id = $request->id;
    //   $albums = Album::where('artist_id', '=', $artists_id)->get();
        
        $artist = Artist::find($artist_id);
        $data  = $artist->albums->toArray();
        // dd($data);
        
        return $data;
    }

    public function createWId($id, Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        // $data  = $artist->albums->toArray();
        $album = Album::find($id);
        $artist = Artist::find($album->artist_id);
        return view('admin.musics.createWId', compact('album', 'artist'));
    }
    public function createAlbumWId($id, Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        // $data  = $artist->albums->toArray();
        $artist = Artist::find($id);
        // $musics = Music::where('album_id', '=', $id);

        return view('admin.musics.createAlbumWId', compact('artist'));
    }
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
            'artists' => 'sometimes|required|unique:artists,artist_name',
            'albums' =>  'sometimes|required',
            'new_artist' => 'sometimes|required',
            'cover_image' => 'required|image|mimes:jpeg,jpg,png',
        ]);
        $artist = $request->input('artists');
        $new_artist = $request->input('new_artist_name');
        $album_names = $request->input('albums');
        
        if (isset($album_names)){
            
            foreach($album_names as $album){ // NEW AlBBUM

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
                
                $coverImage = new CoverImage;
                $coverImage->cover_image = $fileNameToStore;
                $coverImage->save();

                $lastInsertedId = $coverImage->id;
                
                $albums = new Album;
                $albums->album_name = $album;
                $albums->artist_id = $artist;
                $albums->cover_image_id = $lastInsertedId;
                $albums->save();
            }
            return redirect('/admin/musics')->with('success', 'Albums Uploaded');

        }
        else if(isset($new_artist)){   //NEW ARTIST
            $artists = new Artist;
            $artists->artist_name = $new_artist;
            $artists->save();
            return redirect('/admin/musics/createArtist')->with('success', 'Artist Uploaded');
        }
        else{
            return redirect('/admin/musics/createArtist')->with('error', 'The artists has already been taken.');
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editArtist($id, Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $artist = Artist::find($id);
        $albums = Album::where('artist_id', '=', $id);

        // $album = Album::find(1);
        // $coverid = $album->cover_image_id;
        // $etocover =  CoverImage::find($coverid);
        // // //dd($etocover->cover_image);

        // dd($album->coverimage->cover_image);
        
        // $genres = Genre::orderBy('name', 'asc')->get();
        // $movie_genres  = $movie->genres->pluck('name')->toArray();
        // // dd($movie_genres);
    
        // $genres = Genre::orderBy('name', 'asc')->get();
        // $movie_genres  = $movie->genres->pluck('name')->toArray();
        // // dd($movie_genres);


        return view('admin.musics.editArtist', compact('artist', 'albums'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateArtist($id, Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $artist = Artist::find($id);
        $this->validate($request, [ 
            'artist' => 'required|unique:artists,artist_name,'.$artist->id
        ]);

        //Edit Movie
        $artist->artist_name = $request->input('artist');
        $artist->save();


        return redirect('/admin/musics')->with('success', 'Music Updated');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyArtist($id, Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $artist = Artist::find($id);

        foreach($artist->albums as $album){
            if($album->coverimage->cover_image != 'noimage.jpg'){
                // Delete Image
                Storage::delete('public/cover_images/'.$album->coverimage->cover_image);
                $album->coverimage()->delete();
            }
        }
        foreach($artist->songs as $song){
            if($song->coverimage->cover_image != 'nosong.jpg'){
                // Delete Song
                Storage::delete('public/music_songs/'.$song->coverimage->cover_image);
            }
        }

        $artist->songs()->delete();
        $artist->albums()->delete();
        $artist->delete();
        return redirect('/admin/musics')->with('success', 'Artist Removed');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editAlbum($id, Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $album = Album::find($id);
        $artist = Artist::find($album->artist_id);
        $musics = Music::where('album_id', '=', $id);


        return view('admin.musics.editAlbum', compact('album', 'musics', 'artist'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateAlbum($id, Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $album = Album::find($id);
        $artist = $album->artist_id;
        $this->validate($request, [ 
            'album' => 'required',
            'cover_image' => 'image|nullable|max:1999|mimes:jpg,png,jpeg',
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

        //Edit Album Image
        $album->album_name = $request->input('album');
        if($request->hasFile('cover_image')){
            $coverImage = new CoverImage;
            $coverImage->cover_image = $fileNameToStore;
            $coverImage->save();

            $lastInsertedId = $coverImage->id;
            $album->cover_image_id = $lastInsertedId;
            
            $musics = Music::where('album_id', '=', $id)->get();
            // dd($musics);
            foreach($musics as $music){
                $music->cover_image_id = $lastInsertedId;
                $music->save();
            }
        }
        $album->save();


        return redirect('/admin/musics/'.$artist.'/editArtist')->with('success', 'Album Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyAlbum($id, Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $album = Album::find($id);
        
            if($album->coverimage->cover_image != 'noimage.jpg'){
                // Delete Image
                Storage::delete('public/cover_images/'.$album->coverimage->cover_image);
                $album->coverimage()->delete();
            }


        foreach($album->songs as $song){
            if($song->music_song != 'nosong.jpg'){
                // Delete Song
                Storage::delete('public/music_songs/'.$song->music_song);
            }
        }

        $album->songs()->delete();
        $album->delete();

        $artist = $album->artist_id;
        return redirect('/admin/musics/'.$artist.'/editArtist')->with('success', 'Album Removed');
    }

}