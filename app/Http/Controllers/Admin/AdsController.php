<?php

namespace App\Http\Controllers\Admin;


use App\Ad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);

        $ads = Ad::orderBy('created_at', 'desc')->get();
        return view('admin.ads.index', compact('ads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('admin.ads.create');
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
            'name' => 'required',
            'roll' => 'required',
            'time' => 'sometimes|required',
            'playsNeeded' => 'required|integer|min:0',
            'ad_video' => 'mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi|required'
        ]);


        //Handle File Movie
        if($request->hasFile('ad_video')){
            //Get filename with extension
            $filenameWithExt = $request->file('ad_video')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('ad_video')->getClientOriginalExtension();
            //Clean filename (Replace white spaces with hyphens)
            $cleanFilename = str_replace(' ', '-', $filename);
            //Cleaner filename
            $cleanerFilename =  preg_replace('/-+/', '-', $cleanFilename);
            //Filename to store
            $fileNameToStoreVid = $cleanerFilename.'_'.time().'.'.$extension;
            //Upload image
            $path = $request->file('ad_video')->storeAs('public/ad_videos', $fileNameToStoreVid);
        }

        
         //Create Movie
        $ad = new Ad;
        $ad->name = $request->input('name');
        $ad->roll = $request->input('roll');
        $ad->time = $request->input('time');
        $ad->number_of_plays_needed = $request->input('playsNeeded');
        $ad->number_of_plays_remaining = $request->input('playsNeeded');
        $ad->ad_video = $fileNameToStoreVid;
        $ad->save();
        
        
        return redirect('/admin/ads/create')->with('success', 'Ad Uploaded');
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
        $ad = Ad::findOrFail($id);

        return view('/admin/ads/edit', compact('ad'));
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

        $ad = Ad::findOrFail($id);
        
        $this->validate($request, [ 
            'name' => 'required|unique:series,title,'.$ad->id,
            'roll' => 'required',
            'time' => 'sometimes|required',
            'playsNeeded' => 'sometimes|required|integer|min:0',
            'playsNeededAdd' => 'sometimes|required|integer|min:0',
            'ad_video' => 'mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi|nullable'
        ]);


        //Handle File Video
        if($request->hasFile('ad_video')){
            //Get filename with extension
            $filenameWithExt = $request->file('ad_video')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('ad_video')->getClientOriginalExtension();
            //Clean filename (Replace white spaces with hyphens)
            $cleanFilename = str_replace(' ', '-', $filename);
            //Cleaner filename
            $cleanerFilename =  preg_replace('/-+/', '-', $cleanFilename);
            //Filename to store
            $fileNameToStoreVid = $cleanerFilename.'_'.time().'.'.$extension;
            //Upload image
            $path = $request->file('ad_video')->storeAs('public/ad_videos', $fileNameToStoreVid);
        }

        $ad->name = $request->input('name');
        $ad->roll = $request->input('roll');
        $ad->time = $request->input('time');
        $playsNeeded = $request->input('playsNeeded');
        $playsNeededAdd = $request->input('playsNeededAdd');
        if(isset($playsNeededAdd)){
            $total = $playsNeededAdd+$ad->number_of_plays_needed;
            $ad->number_of_plays_needed = $total;
            $ad->number_of_plays_remaining = $total;
        } else if(isset($playsNeeded)) {
            $ad->number_of_plays_needed = $playsNeeded;
            $ad->number_of_plays_remaining = $playsNeeded;
        }
        if($request->hasFile('ad_video')){
            Storage::delete('public/ad_videos/'.$ad->ad_video);
            $ad->ad_video = $fileNameToStoreVid;
        }
        $ad->save();
        
        return redirect('/admin/ads/')->with('success', 'Ad Edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ad = Ad::findOrFail($id);

        if($ad->ad_video != 'novideo.jpg'){
            // Delete Image
            Storage::delete('public/ad_videos/'.$ad->ad_video);
        }

        $ad->delete();
        return redirect('/admin/ads')->with('success', 'Ad Removed');
    }
}
