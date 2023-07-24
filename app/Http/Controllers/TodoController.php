<?php

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TodoController extends Controller
{
    public function index()
    {
        $todos = auth()->user()->todos;

        return response()->json($todos);
    }

    public function store(Request $request)
    {
        $todo = new Todo([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'completed' => $request->input('completed', false),
        ]);

        auth()->user()->todos()->save($todo);

        return response()->json($todo, Response::HTTP_CREATED);
    }

    public function show(Todo $todo)
    {
        $this->authorize('view', $todo);

        return response()->json($todo);
    }

    public function update(Request $request, Todo $todo)
    {
        $this->authorize('update', $todo);

        $todo->update($request->only('title', 'description', 'completed'));

        return response()->json($todo);
    }

    public function destroy(Todo $todo)
    {
        $this->authorize('delete', $todo);

        $todo->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}


