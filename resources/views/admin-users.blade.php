@extends('layouts.master')

@section('title')Users @endsection

@section('styles')
    <style>
        td{
        padding: 5px;
        }
    </style>
@endsection

@section('content')
    <div class="col-sm-12" style="padding: 10px; border: 1px solid #ccc; margin-bottom: 50px;">
        @include('partials.session-messages')
        <div class="col-sm-12">
            <table style="width: 100%;">
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th></th>
                <th></th>
                @foreach($users as $user)
                    <tr>
                        <form action="{{ route('user.store', $user->id) }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="PUT">
                            <td>{{ $user->id }}</td>
                            <td><input type="text" name="name" class="form-control" value="{{ $user->name }}"></td>
                            <td><input type="text" name="email" class="form-control" value="{{ $user->email }}"></td>
                            <td>
                                <select name="status" class="form-control" id="status">
                                    <option value="0" @if($user->status == 0) selected="selected" @endif>Active</option>
                                    <option value="255" @if($user->status == 255) selected="selected" @endif>Blocked</option>
                                </select>
                            </td>
                            <td style="width: 50px;"><button type="submit" class="btn btn-primary btn-block"><i class="fa fa-pencil" aria-hidden="true"></i> Update</button></td>
                        </form>
                        <td>
                            <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger btn-block"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection

