<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class TaskCopyController extends Controller
{

    public function index()
{
    // Assuming you have authenticated users and you want to get tasks assigned to the currently authenticated user
    $user = auth()->user();

    // Retrieve tasks assigned to the specific user
    $tasks = Task::where('assign_to', $user->id)
                 ->where('completed', false)
                 ->orderBy('priority', 'desc')
                 ->orderBy('due_date')
                 ->get();

    return view('taskscopy.index', compact('tasks'));
}


    public function create()
    {
        return view('taskscopy.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'priority' => 'required|max:255',
            'due_date' => 'nullable|max:255',
        ]);

        Task::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'priority' => $request->input('priority'),
            'due_date' => $request->input('due_date'),
        ]);

        return redirect()->route('taskscopy.index')->with('success', 'Task Created Successfully');
    }

    public function edit(Task $task)
    {
        return view('taskscopy.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|max:255',
        ]);

        $task->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'priority' => $request->input('priority'),
            'due_date' => $request->input('due_date'),
        ]);

        return redirect()->route('taskscopy.index')->with('success', 'Task Updated Successfully');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('taskscopy.index')->with('success', 'Task Deleted Successfully');
    }

    public function complete(Task $task)
    {
        $task->update([
            'completed' => true,
            'completed_at' => now(),
        ]);

        return redirect()->route('user/taskscopy/index')->with('success', 'Task Completed Successfully');
    }
    public function showCompletedCopy()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Fetch completed tasks assigned to the authenticated user
        $completedTasksCopy = Task::where('assign_to', $user->id)
                                  ->where('completed', true)
                                  ->orderBy('completed_at', 'desc')
                                  ->get();

        return view('taskcopyshow', compact('completedTasksCopy'));
    }
    public function saveTime(Request $request)
    {
        $task = Task::find($request->id);
        $task->time_tracked = $request->time; // Assuming you have a 'time_tracked' column in your 'tasks' table
        $task->save();

        return response()->json(['status' => 'success']);
    }

}
