<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTask;
use App\Task;
use App\Traits\MakeArray;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    use MakeArray;
    /**
     * The name of the view folder.
     *
     * @var string
     */
    const FOLDER = "task";

    /**
     * The resource route name.
     *
     * @var string
     */

    const ROUTE = "tasks";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    const PAGINATION = 100;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $query = Task::with(["createdBy", "assignedUsers"])->orderBy("status")->orderBy("created_at", "desc");
        if(null !== $request->search) {
            $query->where('name', 'like',$request->search . '%');
            $query->orWhereHas("createdBy", function($query) use($request) {
                $query->where('name', 'like', $request->search . '%');
            });
            $query->orWhereHas("assignedUsers", function($query) use($request) {
                $query->where('name', 'like', $request->search . '%');
            });
        }
        $tasks = $query->paginate(self::PAGINATION);
        $statuses = Task::STATUSES;
        return view(self::FOLDER.".index", compact("tasks", "statuses", "request"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view(self::FOLDER.".create", compact("users"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTask $request)
    {
        $task = new Task();
        $task->name        = $request->name;
        $task->created_by  = Auth::user()->id;
        $task->save();
        $task->assignedUsers()->sync($request->assigned_to);
        return redirect("/dashboard/".self::ROUTE);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $statuses = Task::STATUSES;
        $task = Task::where("id", $id)->with(["createdBy", "assignedUsers"])->first();
        return view(self::FOLDER.".show", compact("task", "statuses"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $users = User::all();
        $assignedUsersCollection = $task->assignedUsers()->get();
        $assignedUsers = $this->makeArray($assignedUsersCollection, "user_id");
        return view(self::FOLDER.".edit", compact("task", "users", "assignedUsers"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTask $request, Task $task)
    {
        $task->name = $request->name;
        $task->save();
        $task->assignedUsers()->sync($request->assigned_to);
        return redirect("/dashboard/".self::ROUTE);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }

    /**
     * Change current status
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Task $task)
    {
        $task->status = $task->status == 0 ? 1 : 0;
        $task->save();
        return redirect("/dashboard/".self::ROUTE);
    }

}
