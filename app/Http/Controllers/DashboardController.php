<?php

namespace App\Http\Controllers;

use App\Models\SubTask;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;


class DashboardController extends Controller
{
    public function index(Request $request){
        $user = auth()->user();
        $tasks = $user->tasks();

        if (request('search')) {
            $tasks->where(function($q){
                $q->where('title', 'like', '%' . request('search') . '%');
                $q->orWhere('description', 'like', '%' . request('search') . '%');
                $q->orWhere('status', 'like', '%' . request('search') . '%');
            });
        }

        if ($request->has(['field', 'sortOrder']) && $request->field != null) {
            if($request->field == 'status'){
                $tasks->where('status', request('sortOrder'));
            } else {
                $tasks->orderBy(request('field'), request('sortOrder'));
            }
        }

        // return $request->all();

        // return $tasks->toSql();

        $tasks = $tasks->where('user_id', $user->id)->paginate(10);
        $status = ['to-do', 'in-progress', 'completed'];
        return view('dashboard', compact('tasks', 'user', 'status'));
    }
    public function trashTask(Request $request){
        $user = auth()->user();
        $tasks = $user->tasks();

        if (request('search')) {
            $tasks->where(function($q){
                $q->where('title', 'like', '%' . request('search') . '%');
                $q->orWhere('description', 'like', '%' . request('search') . '%');
                $q->orWhere('status', 'like', '%' . request('search') . '%');
            });
        }

        if ($request->has(['field', 'sortOrder']) && $request->field != null) {
            if($request->field == 'status'){
                $tasks->where('status', request('sortOrder'));
            } else {
                $tasks->orderBy(request('field'), request('sortOrder'));
            }
        }

        // return $request->all();

        // return $tasks->toSql();

        $tasks = $tasks->where('user_id', $user->id)->onlyTrashed()->paginate(10);
        $status = ['to-do', 'in-progress', 'completed'];
        return view('trash', compact('tasks', 'user', 'status'));
    }

    public function recoverTask($task){
        Task::onlyTrashed()->findOrFail($task)->restore();
        return redirect()->route('dashboard')->with('message', 'Task recoverd successfully!');
    }
    public function deleteTrashTaskAll(){
        $tasks = Task::where('user_id', auth()->user()->id)->onlyTrashed()->get();

        foreach($tasks as $each){
            if($each->image){
                if(File::exists(public_path($each->image->directory.$each->image->file_name))) {
                    File::delete(public_path($each->image->directory.$each->image->file_name));
                }
            }
            $each->forceDelete();
        }

        return redirect()->route('dashboard')->with('message', 'Tasks permanently deleted');
    }
    public function deleteTrashTask($task){
        $moved_task = Task::onlyTrashed()->findOrFail($task);

        if($moved_task->image){
            if(File::exists(public_path($moved_task->image->directory.$moved_task->image->file_name))) {
                File::delete(public_path($moved_task->image->directory.$moved_task->image->file_name));
            }
        }

        $moved_task->forceDelete();

        return redirect()->route('dashboard')->with('message', 'A task has permanently deleted');
    }

    public function changeStatus(Request $request){
        $task = $request->type == 'task' ? Task::find($request->id) : SubTask::find($request->id);

        $task->update([
            'status' => $request->status
        ]);

        if($request->type == 'sub'){
            $task_main = $task->task;

            $all_sub_status = $task_main->subTask()->pluck('status')->toArray();

            if(!in_array('to-do', $all_sub_status) && !in_array('in-progress', $all_sub_status)){
                $task_main->update([
                    'status' => 'completed'
                ]);
            } else {
                if(in_array('in-progress', $all_sub_status)){
                    $task_main->update([
                        'status' => 'in-progress'
                    ]);
                } else if(in_array('completed', $all_sub_status)){
                    $task_main->update([
                        'status' => 'in-progress'
                    ]);
                } else {
                    $task_main->update([
                        'status' => 'to-do'
                    ]);
                }
            }
        }

        return redirect()->route('dashboard')->with('message', 'Status updated successfully');
    }

    public function profile(User $user){
        if($user->id != auth()->user()->id){
            return redirect()->route('dashboard');
        } else {
            return view('users.profile', compact('user'));
        }
    }
    public function profileUpdate(Request $request, User $user){
        $user->update([
            'name' => $request->name,
        ]);

        return redirect()->route('profile', $user)->with('message', 'Profile updated successfully!');
    }

    public function changePassword(User $user){
        if($user->id != auth()->user()->id){
            return redirect()->route('dashboard');
        } else {
            return view('users.change-password', compact('user'));
        }
    }
    public function changePasswordUpdate(Request $request, User $user){

        if(!Hash::check($request->old_password, $user->password)){
            return redirect()->route('change-password.update', $user->id)->withErrors('You have entered a wrong old password.');
        }
        if($request->password != $request->password_confirmation){
            return redirect()->route('change-password.update', $user->id)->withErrors('You have entered wrong confirm password.');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('change-password', $user)->with('message', 'Password updated successfully.');
    }
}
