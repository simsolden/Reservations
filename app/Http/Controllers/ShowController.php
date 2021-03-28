<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Show;
use Illuminate\Support\Facades\DB;

class ShowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shows = DB::table('shows')->simplePaginate(12);

        return view('show.index',[
            'shows' => $shows,
            'resource' => 'spectacles',
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $show = Show::find($id);

        return view('show.show',[
            'show' => $show,
        ]);

    }

    /**
     * Method to book a show.
     *
     * @param  int  $id
     * @param  int  $quantity
     * @return \Illuminate\Http\Response
     */
    public function booking($id,Request $request)
    {
        $show = Show::find($id);
        $quantity = $request->quantity;
        $price = $quantity*$show->price;


        //dd($price);
        return view('show.booking',[
            'show' => $show,
            'qty' => $quantity,
            'price' => $price,
        ]);
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
