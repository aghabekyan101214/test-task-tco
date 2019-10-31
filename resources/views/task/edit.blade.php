@extends('layouts.app')

@section('content')
    <div class="row m-t-20">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading"> Edit Task</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <form action="/dashboard/tasks/{{ $task->id }}" method="post" class="form-horizontal form-bordered">
                            @csrf
                            @method("PUT")
                            <div class="form-body">

                                <div class="form-group">
                                    <label class="control-label col-md-2">Name</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="Name" value="{{ $task->name }}" required class="form-control" name="name">
                                        @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2">Assign To</label>
                                    <div class="col-md-9">
                                        <select name="assigned_to[]" multiple class="form-control select2" required id="">
                                            <option value="">Assign To</option>
                                            @foreach($users as $user)
                                                <option @if(in_array($user->id, $assignedUsers)  ) {{ 'selected' }} @endif value="{{ $user->id }}">{{ $user->name }} @if($user->id == Auth::user()->id) ( me ) @endif </option>
                                            @endForeach
                                        </select>
                                        @error('assigned_to')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-offset-11 col-md-9">
                                                    <button type="submit" class="btn btn-success"><i
                                                            class="fa fa-check"></i>
                                                        Submit
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
