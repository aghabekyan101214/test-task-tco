@extends('layouts.app')

@section('content')
    <div class="white-box m-t-20">
        <h3 class="box-title m-b-10">Statistics</h3>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <td>User Count</td>
                    <td>{{ $countUsers }} users</td>
                </tr>
                <tr>
                    <td>Average Task For Per User</td>
                    <td>{{ $avgTasks }} tasks created per user</td>
                </tr>
                <tr>
                    <td>Average Tasks Assigned To Each User </td>
                    <td>{{ $avgTasksToUser }} tasks are assigned to each user</td>
                </tr>
            </table>
        </div>
    </div>
@endsection

