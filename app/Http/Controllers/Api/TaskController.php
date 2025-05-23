<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    // GET /api/tasks
    public function index()
    {
        return Task::all();
    }

    // POST /api/tasks
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => ['required', Rule::in(['new','in_progress','done'])],
        ]);

        $task = Task::create($data);
        return response()->json($task, 201);
    }

    // GET /api/tasks/{id}
    public function show(Task $task)
    {
        return $task;
    }

    // PUT /api/tasks/{id}
    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => [Rule::in(['new','in_progress','done'])],
        ]);

        $task->update($data);
        return $task;
    }

    // DELETE /api/tasks/{id}
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(null, 204);
    }
}
