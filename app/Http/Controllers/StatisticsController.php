<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    /**
     * The name of the view folder.
     *
     * @var string
     */
    const FOLDER = "statistics";

    /**
     * The resource route name.
     *
     * @var string
     */
    const ROUTE = "statistics";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $countUsers = User::count();
        $avgTasks = DB::select("SELECT tasks/users as avg FROM ((SELECT COUNT(id) AS users FROM users) u, (select count(id) AS tasks FROM tasks) b)")[0]->avg;
        $avgTasksToUser = DB::select("SELECT assignedCount/users as avg FROM ((SELECT COUNT(id) AS users FROM users) u, (SELECT count(id) AS assignedCount FROM tasks_assigned_users) b)")[0]->avg;
        return view(self::FOLDER.".index", compact("countUsers", "avgTasks", "avgTasksToUser"));
    }
}
