<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('user.events', compact('events'));
    }

    public function store(Request $request)
    {
        $event = new Event;
        $event->title = $request->input('title');
        $event->date = $request->input('date');
        $event->save();
    
        return redirect()->route('events');
    }
    
    public function destroy($date)
    {
        Event::where('date', $date)->delete();
    
        return response()->json(['success' => true]);
    }
}