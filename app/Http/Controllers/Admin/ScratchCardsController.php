<?php

namespace App\Http\Controllers\Admin;

use App\ScratchCard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScratchCardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);

        return view('admin.scratchcards.create');
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
                'amount.*' => 'required|numeric',
                'code.*' => 'required|unique:scratch_cards,code',
                'pin.*' => 'required',
                'card_expiration.*' => 'required|date',
                'card_validity.*' => 'required|numeric',
            ]);
            $amount = $request->input('amount');
            $code = $request->input('code');
            $pin = $request->input('pin');
            $card_expiration = $request->input('card_expiration');
            $card_validity = $request->input('card_validity');

            $count = count($code);
            for($x=0; $x < $count; $x++){
                $scratchcard = new ScratchCard;
                $scratchcard->amount =  $amount;
                $scratchcard->code = $code;
                $scratchcard->pin =  $pin;
                $scratchcard->card_expiration =  $card_expiration;
                $scratchcard->card_validity =  $card_validity;
                $scratchcard->save();
            }
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
}
