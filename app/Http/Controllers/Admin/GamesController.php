<?php

namespace App\Http\Controllers\Admin;

use App\Game;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class GamesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);

        return view('admin.games.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);

        $games = Game::all();

        return view('admin.games.create', compact('games'));
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
                'name' => 'required|max:190',
                'cover_image' => 'required|image|mimes:jpeg,jpg,png,gif|max:190',
                'game_apk' => 'required|file|max:190',
                //:application/vnd.android.package-archive
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
                $path = $request->file('cover_image')->storeAs('public/games_cover_images', $fileNameToStore);
            }

            //Handle File Games
            if($request->hasFile('game_apk')){
                //Get filename with extension
                $filenameWithExt = $request->file('game_apk')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                //Get just ext
                $extension = $request->file('game_apk')->getClientOriginalExtension();
                //Clean filename (Replace white spaces with hyphens)
                $cleanFilename = str_replace(' ', '-', $filename);
                //Cleaner filename
                $cleanerFilename =  preg_replace('/-+/', '-', $cleanFilename);
                //Filename to store
                $fileNameToStoreGame = $cleanerFilename.'_'.time().'.'.$extension;
                //Upload image
                $path = $request->file('game_apk')->storeAs('public/games_apks', $fileNameToStoreGame);
            }

            $games = new Game;
            $games->name = $request->input('name');
            $games->cover_image = $fileNameToStore;
            $games->game_apk = $fileNameToStoreGame;
            $games->save();

            return redirect('/admin/games/create')->with('success', 'Game Added');
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

        $games = Game::all();
        $game = Game::findOrFail($id);

        return view('admin.games.edit', compact('games', 'game'));
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
        $game = Game::findOrFail($id);

        $this->validate($request, [
                'name' => 'required|max:190|unique:games,name,'.$game->id,
                'cover_image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:190',
                'game_apk' => 'nullable|file|max:190',
                //:application/vnd.android.package-archive
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
                $path = $request->file('cover_image')->storeAs('public/games_cover_images', $fileNameToStore);
            }

            //Handle File Games
            if($request->hasFile('game_apk')){
                //Get filename with extension
                $filenameWithExt = $request->file('game_apk')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                //Get just ext
                $extension = $request->file('game_apk')->getClientOriginalExtension();
                //Clean filename (Replace white spaces with hyphens)
                $cleanFilename = str_replace(' ', '-', $filename);
                //Cleaner filename
                $cleanerFilename =  preg_replace('/-+/', '-', $cleanFilename);
                //Filename to store
                $fileNameToStoreGame = $cleanerFilename.'_'.time().'.'.$extension;
                //Upload image
                $path = $request->file('game_apk')->storeAs('public/games_apks', $fileNameToStoreGame);
            }

            $game->name = $request->input('name');
            if($request->hasFile('cover_image')){
                Storage::delete('public/games_cover_images/'.$game->cover_image);
                $game->cover_image = $fileNameToStore;
            }
            if($request->hasFile('game_apk')){
                Storage::delete('public/games_apks/'.$game->game_apk);
                $game->game_apk = $fileNameToStoreGame;
            }
            $game->save();

            return redirect('/admin/games/create')->with('success', 'Game Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $game = Game::findOrFail($id);
        Storage::delete('public/games_apks/'.$game->game_apk);
        Storage::delete('public/games_cover_images/'.$game->cover_image);
        $game->delete();
        return redirect('/admin/games/create')->with('success', 'Game Deleted');
    }
}
