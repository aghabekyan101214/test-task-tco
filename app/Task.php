<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    /**
     * Task statuses.
     *
     * @var array
     */

    const STATUSES = array(
        "Pending",
        "Completed"
    );

    /**
     * returns Task creators
     */

    public function createdBy()
    {
        return $this->belongsTo("App\User", "created_by");
    }

    /**
     * Assigning many to many rel. with users
     *
     */
    public function assignedUsers()
    {
        return $this->belongsToMany("App\User", "tasks_assigned_users", "task_id", "user_id")->withPivot(['user_id']);
    }

}
