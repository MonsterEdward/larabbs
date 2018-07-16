@extends('layouts.app')
@section('title', '')

@section('content')
<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
			<h4>
				<i class="glyphicon glyphicon-edit"></i>Edit Info
			</h4>
		</div>

		@include('common.error')

        <div class="panel-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST" accept-charset="UTF-8">
				<input type="hidden" name="_method" value="PUT">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-group">
					<label for="name-field">Name</label>
					<input class="form-control" name="name" id="name-field" type="text" value="{{ old('name', $user->name) }}">
				</div>

				<div class="form-group">
					<label for="email-field">Email</label>
					<input class="form-control" id="email-field" type="text" name="email" value="{{ old('email', $user->email) }}">
				</div>

				<div class="form-group">
					<label for="introduction-field">User's info</label>
					<textarea name="introduction" id="introduction-field" class="form-control" rows="3">{{ old('introduction', $user->introduction) }}</textarea>
				</div>

				<div class="well well-sm">
					<button class="btn btn-primary" type="submit">Save</button>
				</div>

            </form>
        </div>
    </div>
</div>
@endsection
