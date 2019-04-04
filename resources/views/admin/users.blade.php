@extends('layouts.admin')

@section('title')Users @endsection

@section('styles')
    <style>
        .my-row{
            min-width: 384px;
        }
    </style>
@endsection

@section('content')
        <!-- Breadcrumb-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item">
                <a href="#">Admin</a>
            </li>
            <li class="breadcrumb-item active">Users</li>
        </ol>
        @include('partials.admin-session-messages')
        <div class="container-fluid">
            <div class="animated fadeIn">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-align-justify"></i> Users</div>
                            <div class="card-body">
                                <table class="table table-responsive-sm table-sm admin-users">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th class="text-center avatar-admin"><i class="icon-people"></i></th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Password</th>
                                        <th>Confirmation</th>
                                        <th>Status</th>
                                        <th>Update</th>
                                        <th>Delete</th>
                                        <th>Activity</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <form action="{{ route('user.store', $user->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="PUT">
                                            <td>{{ $user->id }}</td>
                                            <td class="avatar-td text-center">{!! $user->avatar() !!}</td>
                                            <td><input type="text" name="name" class="form-control" value="{{ $user->name }}" required></td>
                                            <td><input type="email" name="email" class="form-control" value="{{ $user->email }}" required></td>
                                            <td><input type="password" name="password" class="form-control" autocomplete="off"></td>
                                            <td><input type="password" name="password-confirmation" class="form-control" autocomplete="off"></td>
                                            <td>
                                                <select name="status" class="form-control" @if($user->isAdmin()) disabled="disabled" @endif>
                                                    <option value="0" @if($user->status == 0) selected="selected" @endif>Active</option>
                                                    <option value="255" @if($user->status == 255) selected="selected" @endif>Blocked</option>
                                                </select>
                                            </td>
                                            <td><button type="submit" class="btn btn-primary btn-block"><i class="fa fa-pencil" aria-hidden="true"></i> Update</button></td>
                                        </form>
                                        <td>
                                            <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-danger btn-block" @if($user->isAdmin()) disabled="disabled" @endif><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                        <td><a href="{{ route('users.activity', $user->id) }}">View</a></td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-->
                </div>
            </div>
        </div>
@endsection
