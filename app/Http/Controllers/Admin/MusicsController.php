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
            'title' => 'required|max:190',
            'artists' => 'required|max:190',
            'albums' => 'required|unique:albums,album_name|max:190',
            'genres' => 'required',
            'cover_image' => 'nullable|image|mimes:jpeg,jpg,png|max:190',
            'music_song' => 'required|mimes:mpga,wav|max:190',
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
        $albums = new Album;
        $musics = new Music;
        

        $album = $request->input('albums');
        $artist = $request->input('artists');
        
        if(Album::where('id', '=', Input::get('albums'))->count() <= 0){ //add new album
           

            $coverImage = new CoverImage;
            $coverImage->cover_image = $fileNameToStore;
            $coverImage->save();

            $lastInsertedIdCover = $coverImage->id;


            $albums->album_name = $album;
            $albums->artist_id = $artist;
            $albums->cover_image_id = $lastInsertedIdCover;
            $albums->save();


            $lastInsertedId = $albums->id;

            $musics->title = $request->input('title');
            $musics->album_id = $lastInsertedId;
            $musics->genre = $request->input('genres');
            $musics->cover_image_id = $lastInsertedIdCover;
            $musics->music_song = $fileNameToStoreSong;
            $musics->save();

            return redirect('/admin/musics')->with('success', 'Song & Album Uploaded');
        } 
        else { //no new album
            $thisAlbum = Album::findOrFail($album);
            $coverImage = new CoverImage;
            $coverImage->cover_image = $fileNameToStore;
            $coverImage->save();

            $lastInsertedId = $coverImage->id;

            $musics->title = $request->input('title');
            $musics->album_id = $request->input('albums');
            $musics->genre = $request->input('genres');
            if($request->hasFile('cover_image')){
                $musics->cover_image_id = $lastInsertedId;
            } else {
                $musics->cover_image_id = $thisAlbum->cover_image_id;
            }
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
            'title' => 'required|max:190',
            'genre' => 'required',
            'cover_image' => 'image|nullable|max:1999|mimes:jpg,png,jpeg|max:190',
            'music_song' => 'mimetypes:audio/mp4, audio/mpeg, audio/x-wav|nullable|max:190',
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
            if($song->cover_image_id != $music->albums->cover_image_id){
                    // Delete Image
                    Storage::delete('public/cover_images/'.$song->coverimage->cover_image);
                    $song->coverimage()->delete();
            }
            $coverimage = new CoverImage;

            $coverimage->cover_image = $fileNameToStore;
            $coverimage->save();

            $lastInsertedId = $coverimage->id;
            
            $music->cover_image_id = $lastInsertedId;
        }
        if($request->hasFile('music_song')){
            if($song->music_song != 'nosong.jpg'){
                // Delete Song
                Storage::delete('public/music_songs/'.$song->music_song);
            }
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

        /*****************************
                Custom Functions
        *****************************/

    public function json_albums(Request $request){
      $artist_id = $request->id;
        
        $artist = Artist::find($artist_id);
        $data  = $artist->albums->toArray();

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
            'artists' => 'sometimes|required|unique:artists,artist_name|max:190',
            'albums.*' =>  'sometimes|required|max:190',
            'categories.*' =>  'sometimes|required|max:190',
            'album_dscription.*' =>  'sometimes|required|max:190',
            'release_date.*' =>  'sometimes|required|max:190',
            'new_artist' => 'sometimes|required|max:190',
            'cover_image.*' => 'sometimes|required|image|mimes:jpeg,jpg,png|max:190',
        ]);
        $artist = $request->input('artists');
        $new_artist = $request->input('new_artist_name');
        $album_names = $request->input('albums');
        $categories = $request->input('categories');
        $album_description = $request->input('album_description');
        $release_date = $request->input('release_date');
        $cover_images = $request->file('cover_image');
        
        if (isset($album_names)){
            $x = 0;
            foreach($album_names as $album){ // NEW AlBBUM
                //Handle File Cover Image
                if(isset($cover_images[$x])){
                    //Get filename with extension
                    $filenameWithExt = $cover_images[$x]->getClientOriginalName();
                    //Get just filename
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    //Get just ext
                    $extension = $cover_images[$x]->getClientOriginalExtension();
                    //Clean filename (Replace white spaces with hyphens)
                    $cleanFilename = str_replace(' ', '-', $filename);
                    //Cleaner filename
                    $cleanerFilename =  preg_replace('/-+/', '-', $cleanFilename);
                    //Filename to store
                    $fileNameToStore = $cleanerFilename.'_'.time().'.'.$extension;
                    //Upload image
                    $path = $cover_images[$x]->storeAs('public/cover_images', $fileNameToStore);
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
                $albums->category = $categories[$x];
                $albums->release_date = $release_date[$x];
                $albums->description = $album_description[$x];
                $albums->cover_image_id = $lastInsertedId;
                $albums->save();
                $x++;
            }
            return redirect('/admin/musics')->with('success', 'Albums Added');

        }
        else if(isset($new_artist)){   //NEW ARTIST
            $artists = new Artist;
            $artists->artist_name = $new_artist;
            $artists->save();
            return redirect('/admin/musics/createArtist')->with('success', 'Artist Added');
        }
        else{
            return redirect('/admin/musics/createArtist')->with('error', 'The artist has already been taken.');
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
            'artist' => 'required|max:190|unique:artists,artist_name,'.$artist->id
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
        if(count($artist->albums)){
            foreach($artist->albums as $album){
                if($album->coverimage->cover_image != 'noimage.jpg'){
                    // Delete Image
                    Storage::delete('public/cover_images/'.$album->coverimage->cover_image);
                    $album->coverimage()->delete();
                }
                if(count($album->songs)){
                    foreach($artist->songs as $song){
                        if($song->cover_image_id != $album->cover_image_id){
                            // Delete Song
                            Storage::delete('public/cover_images/'.$song->coverimage->cover_image);
                        }
                    }
                }
            }
        }
        if(count($artist->songs)){
            foreach($artist->songs as $song){
                if($song->music_song != 'nosong.jpg'){
                    // Delete Song
                    Storage::delete('public/music_songs/'.$song->music_song);
                }
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
            'album' => 'required|max:190',
            'categories' =>  'required|max:190',
            'album_dscription' =>  'required|max:190',
            'release_date' =>  'required',
            'cover_image' => 'image|nullable|max:1999|mimes:jpg,png,jpeg|max:190',
        ]);

        $categories = $request->input('categories');
        $album_description = $request->input('album_description');
        $release_date = $request->input('release_date');

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
            // Delete image
            Storage::delete('public/cover_images/'.$album->coverimage->cover_image);
            $album->coverimage()->delete();
            $coverImage = new CoverImage;
            $coverImage->cover_image = $fileNameToStore;
            $coverImage->save();

            $lastInsertedId = $coverImage->id;
            $album->category = $categories;
            $album->release_date = $release_date;
            $album->description = $album_description;
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
        
            if(count($album->songs)){
                foreach($artist->songs as $song){
                    if($song->cover_image_id != $album->cover_image_id){
                        // Delete image
                        Storage::delete('public/cover_images/'.$song->coverimage->cover_image);
                         $song->coverimage()->delete();
                    }
                }
            }


            // if($album->coverimage->cover_image != 'noimage.jpg'){
            //     // Delete Image
            //     Storage::delete('public/cover_images/'.$album->coverimage->cover_image);
            //     $album->coverimage()->delete();
               
            // }


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