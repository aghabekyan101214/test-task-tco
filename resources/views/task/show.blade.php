@extends('layouts.app')

@section('content')
    <div class="white-box m-t-20">
        <h3 class="box-title m-b-10">{{ $task->name }}</h3>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th>Task Name</th>
                    <th>{{ $task->name }}</th>
                </tr>
                <tr>
                    <th>Created By</th>
                    <td>{{ $task->createdBy->name }}</td>
                </tr>
                <tr>
                    <th>Assigned To</th>
                    <td>
                        @foreach($task->assignedUsers as $assignedUser)
                            <p>{{ $assignedUser->name }}</p>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $statuses[$task->status] }}</td>
                </tr>
                <tr>
                    <th>Created Date</th>
                    <td>{{ $task->created_at }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection

