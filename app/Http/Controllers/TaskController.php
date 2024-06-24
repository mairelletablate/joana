<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all(); // Fetch all tasks
        return view('user.usertask', ['tasks' => $tasks]); // Pass tasks to the view
    }
        public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'due_date' => 'required|date',
            'priority' => 'required|string',
            
        ]);


        $task = Task::create($request->all());

        // return response()->json($task);
        return redirect()->route('tasks.index');
    }
        public function update(Request $request, $id)
    {
        $request->validate([
            'due_date' => 'required|date',
            'priority' => 'required|string',
        ]);

        $task = Task::findOrFail($id);
        $task->update($request->only(['due_date', 'priority']));

        return response()->json($task);
    }
    public function destroy($id)
    {
        $tasks = Task::findOrFail($id);
        $tasks->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');
    }
    
}

