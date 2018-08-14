<?php

namespace App\Http\Controllers\Admin;
use App\Charge;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChargesController extends Controller
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

        $charges = Charge::orderBy('created_at', 'desc')->get();

        return view('admin.charges.create', compact('charges'));
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
                'name' => 'required|unique:charges,name|max:190',
                'symbol' => 'required|max:1',
                'value' => 'required|regex:/^\d*(\.\d{1,2})?$/|max:100|min:1',
            ]);

            $charge = new Charge;
            $charge->name = $request->input('name');
            $charge->symbol = $request->input('symbol');
            $charge->value = number_format($request->input('value'));
            $charge->save();

            return redirect('/admin/charges/create')->with('success', 'Charge Added');
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
            $charge = Charge::find($id);
            $value = preg_replace('/[^A-Za-z0-9\-]/', '', $charge->value);
            $charges = Charge::orderBy('created_at', 'desc')->get();
            return view('/admin/charges/edit', compact('charge', 'value', 'charges'));
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
        $charge = Charge::find($id);

        $this->validate($request, [ 
                'name' => 'required|max:190|unique:charges,name,'.$charge->id,
                'name' => 'required|max:1',
                'value' => 'required|regex:/^\d*(\.\d{1,2})?$/|max:100|min:1',
            ]);

        $charge->name = $request->input('name');
        $charge->symbol = $request->input('symbol');
        $charge->value = $request->input('value');
        $charge->save();
        return redirect('/admin/charges/create')->with('success', 'Charge Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $charge = Charge::find($id);
        $charge->delete();
        
        return redirect('/admin/charges/create')->with('success', 'Charge Deleted');
    }
}
