<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('completed', false)
                    ->orderBy('priority', 'desc')
                    ->orderBy('due_date')
                    ->paginate(5); // Adjust the number of items per page as needed

        return view('tasks.index', compact('tasks'));
    }

    public function getStatusAttribute()
    {
        if ($this->completed) {
            return 'Completed';
        } elseif ($this->due_date < now()) {
            return 'Late';
        } else {
            return 'In Progress';
        }
    }


    public function usertasks()
    {
        $tasks = Task::where('completed', false)
                    ->orderBy('priority', 'desc')
                    ->orderBy('due_date')
                    ->get();

        return view('tasks.usertasks', compact('tasks'));
    }

    public function create()
    {
        // Retrieve users who are not administrators (where 'type' is 0)
        $users = User::where('type', 0)->get();

        return view('tasks.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
            'assign_to' => 'nullable|exists:users,id', // Validate that the assigned user exists in the 'users' table
        ]);

        $task = new Task();
        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->priority = $request->input('priority');
        $task->due_date = $request->input('due_date');
        $task->assign_to = $request->input('assign_to');
        $task->save();

        return redirect()->route('admin/tasks/index')->with('success', 'Task Created Successfully');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
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
        return redirect()->route('admin/tasks/index')->with('success', 'Task Updated Successfully');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('admin/tasks/index')->with('success', 'Task Deleted Successfully');
    }

    public function complete(Task $task)
    {
        $task->update([
            'completed' => true,
            'completed_at' => now(),
        ]);

        return redirect()->route('admin/tasks/index')->with('success', 'Task Completed Successfully');
    }

    public function showCompleted()
    {
        $completedTasks = Task::with(['assignedUser', 'assignedBy'])
                            ->where('completed', true)
                            ->orderBy('completed_at', 'desc')
                            ->paginate(5);

        return view('taskshow', compact('completedTasks'));
    }
    public function saveRemarks(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->remarks = $request->remarks;
        $task->save();

        return response()->json(['message' => 'Remarks saved successfully']);
    }



}

