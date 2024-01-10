<?php

namespace App\Http\Controllers;

use App\Models\SubTask;
use App\Http\Requests\StoreSubTaskRequest;
use App\Http\Requests\UpdateSubTaskRequest;
use App\Models\Task;
use Illuminate\Support\Facades\File;

class SubTaskController extends Controller
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
    public function create(Task $task)
    {
        return view('sub-tasks.form', compact('task'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubTaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubTaskRequest $request, Task $task)
    {
        $subtask = SubTask::create([
            'task_id' => $task->id,
            'title' => $request->title,
            'description' => $request->description ?? '',
        ]);


        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time().'.'.$extenstion;
            $file->move('subtask/image/', $filename);

            $subtask->image()->create([
                'file_name' => $filename,
                'file_type' => $extenstion,
                'directory' => '/subtask/image/',
            ]);
        }

        return redirect()->route('dashboard')->with('message', 'Sub-Task added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubTask  $subTask
     * @return \Illuminate\Http\Response
     */
    public function show(SubTask $subTask)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubTask  $subTask
     * @return \Illuminate\Http\Response
     */
    public function edit(SubTask $subTask)
    {
        $task = $subTask->task;
        $status = ['to-do', 'in-progress', 'completed'];
        return view('sub-tasks.form', compact('subTask', 'status', 'task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubTaskRequest  $request
     * @param  \App\Models\SubTask  $subTask
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubTaskRequest $request, SubTask $subTask)
    {
        // return $all_sub_status;
        $subTask->update([
            'title' => $request->title,
            'description' => $request->description ?? '',
            'status' => $request->status,
        ]);

        if($request->hasfile('image'))
        {
            if($subTask->image){
                if(File::exists(public_path($subTask->image->directory.$subTask->image->file_name))) {
                    File::delete(public_path($subTask->image->directory.$subTask->image->file_name));
                }
                $subTask->image()->delete();
            }
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time().'.'.$extenstion;
            $file->move('subtask/image/', $filename);

            $subTask->image()->create([
                'file_name' => $filename,
                'file_type' => $extenstion,
                'directory' => '/subtask/image/',
            ]);
        }

        $task = $subTask->task;

        $all_sub_status = $task->subTask()->pluck('status')->toArray();

        if(!in_array('to-do', $all_sub_status) && !in_array('in-progress', $all_sub_status)){
            $task->update([
                'status' => 'completed'
            ]);
        } else {
            if(in_array('in-progress', $all_sub_status)){
                $task->update([
                    'status' => 'in-progress'
                ]);
            } else if(in_array('completed', $all_sub_status)){
                $task->update([
                    'status' => 'in-progress'
                ]);
            } else {
                $task->update([
                    'status' => 'to-do'
                ]);
            }
        }

        return redirect()->route('dashboard')->with('message', 'Sub-Task updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubTask  $subTask
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubTask $subTask)
    {
        $subTask->delete();
        return redirect()->route('dashboard')->with('message', 'Sub-Task deleted successfully!');
    }
}
