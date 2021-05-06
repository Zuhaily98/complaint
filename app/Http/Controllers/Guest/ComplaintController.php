<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Guest;
use App\Models\State;
use App\Models\City;
use App\Models\District;
use App\Models\Panel;
use App\Models\Category;

class ComplaintController extends Controller
{

    public function index()
    {
        return view('guest.index');
    }

    public function show(Complaint $complaint)
    {
        return view('guest.show')->with('complaint', $complaint);
    }

    public function create()
    {
        return view('guest.create')
            ->with('states', State::all())
            ->with('cities', City::all())
            ->with('districts', District::all())
            ->with('panels', Panel::all())
            ->with('categories', Category::all());
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'panel' => 'required',
            'category_id' => 'required',
            'detail' => 'required'
        ]);

        $guest = Guest::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone
        ]);
        
        $guest->complaints()->create([
            'category_id' => $request->category_id,
            'panel_id' => $request->panel,
            'detail' => $request->detail,
        ]);
        
        
        //flash message
        session()->flash('success', 'Complaint created successfully!');

        //redirect
        return redirect(route('guest.index'));
    }
}
