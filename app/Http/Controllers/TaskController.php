<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Support\Facades\File;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request)
    {
        $task = Task::create([
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'description' => $request->description ?? '',
        ]);

        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time().'.'.$extenstion;
            $file->move('task/image/', $filename);

            $task->image()->create([
                'file_name' => $filename,
                'file_type' => $extenstion,
                'directory' => '/task/image/',
            ]);
        }

        return redirect()->route('dashboard')->with('message', 'Task added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $status = ['to-do', 'in-progress', 'completed'];
        return view('tasks.form', compact('task', 'status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTaskRequest  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update([
            'title' => $request->title,
            'description' => $request->description ?? '',
            'status' => $request->status,
        ]);

        if($request->hasfile('image'))
        {
            if($task->image){
                if(File::exists(public_path($task->image->directory.$task->image->file_name))) {
                    File::delete(public_path($task->image->directory.$task->image->file_name));
                }
                $task->image()->delete();
            }
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time().'.'.$extenstion;
            $file->move('task/image/', $filename);

            $task->image()->create([
                'file_name' => $filename,
                'file_type' => $extenstion,
                'directory' => '/task/image/',
            ]);
        }

        return redirect()->route('dashboard')->with('message', 'Task updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
        $task->subTask()->delete();
        return redirect()->route('dashboard')->with('message', 'Task deleted successfully!');
    }
}
