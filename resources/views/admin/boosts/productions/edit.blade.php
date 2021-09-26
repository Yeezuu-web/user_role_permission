@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Edit Request</div>

        <div class="card-body">
            <form action="{{ route('admin.productions.update', $boost->id) }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="actual_cost">Actual Cost</label>
                    <input type="text" class="form-control" name="actual_cost" id="actual_cost" value="{{ old('actual_cost', $boost->actual_cost) }}">
                    <input type="text" class="form-control" name="st" id="st" hidden value="3">
                </div>
                <div class="form-group">
                    <label for="actual_cost">Status</label>
                    <select class="js-example-basic-single w-100 select2-hidden-accessible" name="status" data-width="100%" aria-hidden="true">
                        <option value="0"​>--- Choose department ---</option>
                        <option value="3" {{ old('status', $boost->status) == '3' ? 'selected' : ''}} ​>Running</option>
                        <option value="4"​ {{ old('status', $boost->status) == '4' ? 'selected' : ''}} >Rejected</option>
                        <option value="5" {{ old('status', $boost->status) == '5' ? 'selected' : ''}} ​>Completed</option>
                    </select>
                    <input type="text" class="form-control" name="st" id="st" hidden value="3">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-danger btn-sm">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection