<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Plan;

class PlansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $plans = Plan::all();
         return view('plan',compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $plan = new Plan;
        $plan->id = $request->id;
        $plan->u_id = $request->u_id;
        $plan->date = $request->date;
        $plan->todo = $request->todo;
        $plan->save();
        return redirect('/plan');
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
    public function edit(Request $request)
    {
        $plan = Plan::find($request->id);
        $plan->todo = $request->todo;
        $plan->save();
        $plans = Plan::all();
        return view('plan',compact('plans'));
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
    public function destroy(Request $request)
    {
        $plan = Plan::find($request->id);
        $plan->delete();
        $plans = Plan::all();
        return view('plan',compact('plans'));
    }
}
