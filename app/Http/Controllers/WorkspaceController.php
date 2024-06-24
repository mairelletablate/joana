<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workspace;

class WorkspaceController extends Controller
{
    public function create()
    {
        $workspaces = Workspace::all(); // Fetch all workspaces
        return view('dashboard', compact('workspaces')); // Pass workspaces to the view
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
        ]);

        $workspace = new Workspace;
        $workspace->name = $request->name;
        $workspace->description = $request->description;
        $workspace->save();

        return redirect()->route('dashboard')->with('success', 'Workspace created successfully!');
    }

    public function destroy($id)
    {
        $workspace = Workspace::findOrFail($id);
        $workspace->delete();

        return redirect()->route('dashboard')->with('success', 'Workspace deleted successfully');
    }
    public function task()
        {
            // Retrieve necessary data here if needed
            return view('user.usertask');
    }
}