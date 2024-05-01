<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index(){
        $pageTitle = 'Plan Lists';
        $plans = Plan::latest()->paginate(getPaginate());
        return view('admin.plan.index',compact('pageTitle','plans'));
    }

    public function store(Request $request){

        $request->validate([
            'name'=> 'required',
            'type' => 'required|in:click,impression',
            'price'=>'required|numeric|min:1',
            'points' =>'required|numeric|min:1',
        ]);
        $plan = new Plan();
        $plan->name = $request->name;
        $plan->type = $request->type;
        $plan->price = $request->price;
        $plan->points = $request->points;
        $plan->status = 1;
        $plan->save();

        $notify[] = ['success','Plan create has been successfully'];
        return back()->withNotify($notify);

    }

    public function update(Request $request){

        $request->validate([
            'name'=> 'required',
            'type' => 'required|in:click,impression',
            'price'=>'required|numeric|min:1',
            'points' =>'required|numeric|min:1',
        ]);
        $plan = Plan::findOrFail($request->id);
        $plan->name = $request->name;
        $plan->type = $request->type;
        $plan->price = $request->price;
        $plan->points = $request->points;
        isset($request->status) ? $plan->status = 1 : $plan->status = 0;
        $plan->save();

        $notify[] = ['success','Plan updated has been successfully'];
        return back()->withNotify($notify);

    }

    public function delete(Request $request){
        $plan = Plan::findOrFail($request->id);
        $plan->delete();
        $notify[] = ['success','Plan deleted has been successfully'];
        return back()->withNotify($notify);
    }

}
