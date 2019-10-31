@extends('layouts.app')

@section('content')
    <div class="white-box m-t-20">
        <h3 class="box-title m-b-10">Tasks List</h3>
        <a href="/dashboard/tasks/create" class="box-title m-b-20 btn btn-success">Add New Task</a>
        <form action="">
            <div class="input-group">
                <input type="text" name="search" value="{{ $request->search }}" class="form-control" placeholder="Search">
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit">
                        <i class="glyphicon glyphicon-search"></i>
                    </button>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table id="myTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>Task Name</th>
                        <th>Created By</th>
                        <th>Assigned To</th>
                        <th>Status</th>
                        <th>Settings</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                        <tr>
                            <td>{{ $task->name }}</td>
                            <td>{{ $task->createdBy->name }}</td>
                            <td>
                                @foreach($task->assignedUsers as $assignedUser)
                                    <p>{{ $assignedUser->name }}</p>
                                @endforeach
                            </td>
                            <td>{{ $statuses[$task->status] }}</td>
                            <td>
                                <a href="/dashboard/tasks/{{ $task->id }}" data-toggle="tooltip" data-placement="top" title="Show" class="btn btn-success btn-circle tooltip-success">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(Auth::user()->id == $task->createdBy->id)
                                    <a href="/dashboard/tasks/{{ $task->id }}/edit" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-primary btn-circle tooltip-primary">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>

                                    <a href="/dashboard/tasks/change-status/{{ $task->id }}" data-toggle="tooltip" data-placement="top" @if($task->status == 0) title="Complete" @elseif($task->status == 1) title="Pending" @endif class="btn @if($task->status == 0) btn-warning tooltip-warning @elseif($task->status == 1) btn-danger tooltip-danger @endif  warning btn-circle">
                                        <i class="fas fa-toggle-on"></i>
                                    </a>
                                @else
                                    @foreach($task->assignedUsers as $t)
                                        @if($t->pivot->user_id == Auth::user()->id)
                                            <a href="/dashboard/tasks/change-status/{{ $task->id }}" data-toggle="tooltip" data-placement="top" @if($task->status == 0) title="Complete" @elseif($task->status == 1) title="Pending" @endif class="btn @if($task->status == 0) btn-warning tooltip-warning @elseif($task->status == 1) btn-danger tooltip-danger @endif  warning btn-circle">
                                                <i class="fas fa-toggle-on"></i>
                                            </a>
                                            @break
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $tasks->appends(request()->except('page'))->links() }}
        </div>
    </div>
@endsection

