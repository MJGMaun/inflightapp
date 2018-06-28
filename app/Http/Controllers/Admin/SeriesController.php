<?php

namespace App\Http\Controllers\Admin;

use App\Genre;
use App\Season;
use App\Series;
use App\Episode;
use App\SeriesCoverImage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);

        $genres = Genre::orderBy('name', 'asc')->get();
        $series = Series::orderBy('created_at', 'desc')->get();

        return view('admin.series.index', compact('series', 'genres'));
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
        $series = Series::orderBy('created_at', 'desc')->get();

        return view('admin.series.create', compact('series', 'genres'));
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
                'title' => 'required|unique:series,title',
                'cast' => 'required',
                'genres' => 'required',
                'release_date' => 'required|date',
                'description' => 'required',
                'cover_image' => 'required|image|mimes:jpeg,jpg,png',
            ]);


            //Handle File Cover Image 1
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
                $path = $request->file('cover_image')->storeAs('public/series_cover_images', $fileNameToStore);
            } else {
                $fileNameToStore = 'noimage.jpg';
            }

            $series = new Series;
            $series->title = $request->input('title');
            $series->cast = $request->input('cast');
            $series->release_date = $request->input('release_date');
            $series->description= $request->input('description');


            $coverImage = new SeriesCoverImage;
            $coverImage->cover_image = $fileNameToStore;
            $coverImage->save();

            $lastInsertedIdCover = $coverImage->id;

            $series->cover_image_id = $lastInsertedIdCover;
            $series->save();

            $genres = $request->input('genres');
        
            foreach($genres as $genre){
                $series
                ->genres()
                ->attach(Genre::where('name', $genre)->first());
            }

            return redirect('/admin/series/create')->with('success', 'Series Added');
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
        $serie = Series::findOrFail($id);
        $series = Series::orderBy('created_at', 'desc')->get();
        $genres = Genre::orderBy('name', 'asc')->get();
        $serie_genres  = $serie->genres->pluck('name')->toArray();

        return view('admin.series.edit', compact('serie', 'serie_genres','series', 'genres'));
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
        $serie = Series::findOrFail($id);

        $this->validate($request, [ 
                'title' => 'required|unique:series,title,'.$serie->id,
                'cast' => 'required',
                'genres' => 'required',
                'release_date' => 'required|date',
                'description' => 'required',
                'cover_image' => 'nullable|image|mimes:jpeg,jpg,png',
            ]);


            //Handle File Cover Image 1
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
                $path = $request->file('cover_image')->storeAs('public/series_cover_images', $fileNameToStore);
            }

            $serie->title = $request->input('title');
            $serie->cast = $request->input('cast');
            $serie->release_date = $request->input('release_date');
            $serie->description= $request->input('description');

            if($request->hasFile('cover_image')){
            $coverImageId = $serie->cover_image_id;
            Storage::delete('public/series_cover_images/'.$serie->coverimage->cover_image);
            $coverImage = SeriesCoverImage::findOrFail($coverImageId);
            $coverImage->cover_image = $fileNameToStore;
            $coverImage->save();

            $lastInsertedIdCover = $coverImage->id;

            $serie->cover_image_id = $lastInsertedIdCover;
            } 
            $serie->save();

            $genres = $request->input('genres');
            $serie->genres()->detach();
            foreach($genres as $genre){
                $serie
                ->genres()
                ->attach(Genre::where('name', $genre)->first());
            }

            return redirect('/admin/series/create')->with('success', 'Series Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $serie = Series::find($id);
        $serie->genres()->detach();

        if($serie->cover_image != 'noimage.jpg'){
            // Delete Image
            Storage::delete('public/series_cover_images/'.$serie->coverimage->cover_image);
        }

        foreach($serie->episodes as $episode){
            Storage::delete('public/series_videos/'.$episode->episode_video);
        }
        $serie->episodes()->delete();
        $serie->seasons()->delete();
        $serie->delete();

        return redirect('/admin/series/create')->with('success', 'Series Removed');
    }

    /*****************************
            CUSTOM FUNCTIONS
    *****************************/

    public function json_seasons(Request $request){
        $series_id = $request->id;
            
            $serie = Series::find($series_id);
            $data  = count($serie->seasons);
            return $data;
    }
    public function json_seasons_modal(Request $request){
            $series_id = $request->id;
            
            $serie = Series::find($series_id);
            $seasons  = $serie->seasons->toArray();

            $seasonsFirst = $serie->seasons;

            $data = array();
            foreach($seasonsFirst as $season) {
                $item = array();
                $item['season_id'] = $season->id;
                $item['season_number'] = $season->season_number;
                $item['season_cover_image'] = $season->seriescoverimage->cover_image;
                
                $ep = array();
                $epnumber = array();
                $epId = array();
                foreach($season->episodes as $episode) {
                    $epId[] = $episode->id;
                    $epnumber[] = $episode->episode_number;
                    $ep[] = $episode->title;
                }
                $item['episodes_id'] = $epId;
                $item['episodes_number'] = $epnumber;
                $item['episodes'] = $ep;
                $data[] = $item;
            }
            // dd($data);
            return $data;
    }

    /*****************************
            SEASON
    *****************************/

    public function createSeason(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $series = Series::orderBy('created_at', 'desc')->get();
        

        return view('admin.series.createSeason', compact('series'));
    }
    public function storeSeason(Request $request)
    {
        $this->validate($request, [ 
                'series' => 'required',
                'season' => 'required',
                'cover_image' => 'file|nullable|image|mimes:jpeg,jpg,png',
                'episodes.*' => 'required|distinct',
                'episodeNumbers.*' => 'required|distinct',
                'episode_videos.*' => 'required|distinct|file|mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi|required',
            ]);
        $cover_images = $request->file('cover_images');
        $episode_videos = $request->file('episode_videos');

            // Handle File Cover Image 1
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
                $path = $request->file('cover_image')->storeAs('public/series_cover_images', $fileNameToStore);
            } else {
                $fileNameToStore = 'noimage.jpg';
            }

            $season = new Season;
            $season->series_id = $request->input('series');
            $season->season_number = $request->input('season');

            $coverImage = new SeriesCoverImage;
            $coverImage->cover_image = $fileNameToStore;
            $coverImage->save();

            $lastInsertedIdCover = $coverImage->id;

            $season->season_cover_image_id = $lastInsertedIdCover;
            $season->save();

            $seasonId = $season->id;

                $x = 0;
                foreach($request->file('episode_videos') as $episode_video){

                    $episode_numbers = $request->input('episodeNumbers');
                    $episodes_title = $request->input('episodes');

                    //Get filename with extension
                    $filenameWithExt = $episode_video->getClientOriginalName();
                    //Get just filename
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    //Get just ext
                    $extension = $episode_video->getClientOriginalExtension();
                    //Clean filename (Replace white spaces with hyphens)
                    $cleanFilename = str_replace(' ', '-', $filename);
                    //Cleaner filename
                    $cleanerFilename =  preg_replace('/-+/', '-', $cleanFilename);
                    //Filename to store
                    $fileNameToStoreVid = $cleanerFilename.'_'.time().'.'.$extension;
                    //Upload image
                    $path = $episode_video->storeAs('public/series_videos', $fileNameToStoreVid);


                    $number  = $episode_numbers[$x];
                    $title = $episodes_title[$x];

                    $episode = new Episode;
                    $episode->title = $title;
                    $episode->description = 'Hello';
                    $episode->running_time = '1:00:00';
                    $episode->episode_number = $number;
                    $episode->episode_video = $fileNameToStoreVid;
                    $episode->episode_cover_image_id = $lastInsertedIdCover;
                    $episode->series_id = $request->input('series');
                    $episode->season_id = $seasonId;
                    $episode->save();


                    $x++;
            }

        return redirect('/admin/series/createSeason')->with('success', 'Season & Episodes Added');
    }
    public function editSeason($id, Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $season = Season::findOrFail($id);
        $serie = $season->series;
        $series = Series::orderBy('title', 'asc')->get();
        // $serie_genres  = $serie->genres->pluck('name')->toArray();
        return view('admin.series.editSeason', compact('season', 'serie', 'series'));
    }
    public function updateSeason($id, Request $request)
    {
        $this->validate($request, [ 
                'series' => 'required',
                'season' => 'required',
                'cover_image' => 'file|nullable|image|mimes:jpeg,jpg,png',
                'episodes.*' => 'required|distinct',
                'episodeNumbers.*' => 'required|distinct',
                'episode_videos.*' => 'nullable|distinct|file|mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi|required',
            ]);
        $cover_images = $request->file('cover_images');
        $episode_videos = $request->file('episode_videos');

            // Handle File Cover Image 1
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
                $path = $request->file('cover_image')->storeAs('public/series_cover_images', $fileNameToStore);
            }

            $season = Season::findOrFail($id);
            $season->series_id = $request->input('series');
            $season->season_number = $request->input('season');

            if($request->hasFile('cover_image')){
            $coverImage = new SeriesCoverImage;
            $coverImage->cover_image = $fileNameToStore;
            $coverImage->save();

            $lastInsertedIdCover = $coverImage->id;

            $season->season_cover_image_id = $lastInsertedIdCover;
            }
            $season->save();

            $seasonId = $season->id;
                $x = 0;
                $episode_numbers = $request->input('episodeNumbers');
                $episodes_title = $request->input('episodes');
                $episode_ids = $request->input('episode_ids');
                if($request->hasFile('episode_videos')){
                    $countvideos = count($request->file('episode_videos'));
                for($x = 0; $x <= $countvideos; $x++){
                    if(isset($episode_videos[$x])){
                    //Get filename with extension
                    $filenameWithExt = $episode_videos[$x]->getClientOriginalName();
                    //Get just filename
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    //Get just ext
                    $extension = $episode_videos[$x]->getClientOriginalExtension();
                    //Clean filename (Replace white spaces with hyphens)
                    $cleanFilename = str_replace(' ', '-', $filename);
                    //Cleaner filename
                    $cleanerFilename =  preg_replace('/-+/', '-', $cleanFilename);
                    //Filename to store
                    $fileNameToStoreVid = $cleanerFilename.'_'.time().'.'.$extension;
                    //Upload image
                    $path = $episode_videos[$x]->storeAs('public/movie_videos', $fileNameToStoreVid);
                    }

                    $number  = $episode_numbers[$x];
                    $title = $episodes_title[$x];
                    $epId = $episode_ids[$x];
                    // $epvideo = $episode_video[$x];
                    Storage::delete('public/series_videos/'.$episode->episode_video);
                    $episode = Episode::findOrFail($epId);
                    $episode->title = $title;
                    $episode->description = 'Hello';
                    $episode->running_time = '1:00:00';
                    $episode->episode_number = $number;
                    if(isset($episode_videos[$x])){
                    $episode->episode_video = $fileNameToStoreVid;
                    }
                    if($request->hasFile('cover_image')){
                    $episode->episode_cover_image_id = $lastInsertedIdCover;
                    }
                    $episode->series_id = $request->input('series');
                    $episode->season_id = $seasonId;
                    $episode->save();

            }
        }else{
                    for($x=0; $x < count($episode_ids); $x++){
                    $number  = $episode_numbers[$x];
                    $title = $episodes_title[$x];
                    $epId = $episode_ids[$x];

                    $episode = Episode::findOrFail($epId);
                    $episode->title = $title;
                    $episode->description = 'Hello';
                    $episode->running_time = '1:00:00';
                    $episode->episode_number = $number;
                    if($request->hasFile('cover_image')){
                    $episode->episode_cover_image_id = $lastInsertedIdCover;
                    }
                    $episode->series_id = $request->input('series');
                    $episode->season_id = $seasonId;
                    $episode->save();
                }
        }

        return redirect('/admin/series/')->with('success', 'Season & Episodes Updated');
    }




    /*****************************
            EPISODE
    *****************************/
    public function editEpisode($id, Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $episode = Episode::findOrFail($id);
        $series = Series::orderBy('created_at', 'desc')->get();
        // $genres = Genre::orderBy('name', 'asc')->get();
        // $serie_genres  = $serie->genres->pluck('name')->toArray();
        return view('admin.series.editEpisode', compact('episode', 'series', 'serie'));
    }
    public function updateEpisode($id, Request $request)
    {
        $this->validate($request, [ 
                'series' => 'required',
                'season' => 'required',
                'episode' => 'required|distinct',
                'episodeNumber' => 'required|distinct',
                'episode_video' => 'nullable|distinct|file|mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi',
            ]);
        $cover_images = $request->file('cover_images');
        $episode_videos = $request->file('episode_videos');

            // // Handle File Cover Image 1
            // if($request->hasFile('cover_image')){
            //     //Get filename with extension
            //     $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            //     //Get just filename
            //     $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //     //Get just ext
            //     $extension = $request->file('cover_image')->getClientOriginalExtension();
            //     //Clean filename (Replace white spaces with hyphens)
            //     $cleanFilename = str_replace(' ', '-', $filename);
            //     //Cleaner filename
            //     $cleanerFilename =  preg_replace('/-+/', '-', $cleanFilename);
            //     //Filename to store
            //     $fileNameToStore = $cleanerFilename.'_'.time().'.'.$extension;
            //     //Upload image
            //     $path = $request->file('cover_image')->storeAs('public/series_cover_images', $fileNameToStore);
            // }

            // $seasonId = $episode->season_id;
            // $season = Season::findOrFail($seasonId);
            // $season->series_id = $request->input('series');
            // $season->season_number = $request->input('season');

            // if($request->hasFile('cover_image')){
            // $coverImage = new SeriesCoverImage;
            // $coverImage->cover_image = $fileNameToStore;
            // $coverImage->save();

            // $lastInsertedIdCover = $coverImage->id;

            // $season->season_cover_image_id = $lastInsertedIdCover;
            // }
            // $season->save();


                if($request->hasFile('episode_videos')){
                    //Get filename with extension
                    $filenameWithExt = $episode_video->getClientOriginalName();
                    //Get just filename
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    //Get just ext
                    $extension = $episode_video->getClientOriginalExtension();
                    //Clean filename (Replace white spaces with hyphens)
                    $cleanFilename = str_replace(' ', '-', $filename);
                    //Cleaner filename
                    $cleanerFilename =  preg_replace('/-+/', '-', $cleanFilename);
                    //Filename to store
                    $fileNameToStoreVid = $cleanerFilename.'_'.time().'.'.$extension;
                    //Upload image
                    $path = $episode_video->storeAs('public/movie_videos', $fileNameToStoreVid);
                }
                    $episode = Episode::findOrFail($id);
                    $episode_number = $request->input('episodeNumber');
                    $episodes_title = $request->input('episode');

                    $episode->title = $episodes_title;
                    $episode->description = 'Hi';
                    $episode->running_time = '1:00:00';
                    $episode->episode_number = $episode_number;
                    if($request->hasFile('episode_videos')){
                    Storage::delete('public/series_videos/'.$episode->episode_video);
                    $episode->episode_video = $fileNameToStoreVid;
                    }
                    $episode->save();

        return redirect('/admin/series/')->with('success', 'Episode Updated');
    }

}
