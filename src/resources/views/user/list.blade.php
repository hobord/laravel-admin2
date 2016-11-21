@extends('vendor.hobord.admin.layout.admin_layout')

@section('content_header')
    <h1>
        User Management
        <small>You can list, edit and create users.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('admin.index')}}"><i class="fa fa-dashboard"></i>Home</a></li>
        <li><a href="#" class="active"><i class="fa fa-users"></i>User Management</a></li>
    </ol>
@endsection

@section('content')
    @parent

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Users</h3>
            <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                @if(Auth::User()->can('admin.users.create'))
                    <a class="btn btn-success" href="{{ route('admin.user.create') }}">Create User</a>
                @endif
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body">
            <table class="table table-striped table-condensed">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Loged in at</th>
                    <th>Created at</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            @if(Auth::User()->can('admin.users.edit'))
                                <a href="{{route('admin.users.edit',$user->id)}}">{{ $user->name }}</a>
                            @else
                                {{ $user->name }}
                            @endif
                        </td>
                        <td>
                            @if(Auth::User()->can('admin.users.edit'))
                                <a href="{{route('admin.users.edit',$user->id)}}">{{ $user->email }}</a>
                            @else
                                {{ $user->email }}
                            @endif
                        </td>
                        <td>
                            @foreach($user->roles as $role)
                                {{$role->display_name}} @if(!$loop->last),@endif
                            @endforeach
                        </td>
                        <td>{{ $user->updated_at }}</td>
                        <td>{{ $user->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div><!-- /.box-body -->
        <div class="box-footer">
            {{ $users->links() }}
        </div><!-- box-footer -->
    </div><!-- /.box -->

@endsection