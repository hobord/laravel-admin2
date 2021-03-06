@extends('vendor.hobord.admin.layout.admin_layout')

@section('content_header')
    <h1>
        @if($user->id) Edit @else Create @endif User
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('admin.index')}}"><i class="fa fa-dashboard"></i>Home</a></li>
        <li><a href="{{route('admin.users')}}" class="active"><i class="fa fa-users"></i>User Management</a></li>
        <li><a href="@if($user->id){{route("admin.users.edit", $user->id)}}@else{{route("admin.user.create")}}@endif" class="active"><i class="fa fa-user"></i>@if($user->id) Edit @else Create @endif User</a></li>
    </ol>
@endsection

@section('content')
    @parent
    <form method="post" action="{{route('admin.users.edit',$user->id)}}">{{ csrf_field() }}
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">User</h3>
                <div class="box-tools pull-right">
                    <!-- Buttons, labels, and many other things can be placed here! -->

                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input name="name" value="{{$user->name}}" type="text" class="form-control" id="name" placeholder="Enter full name" autocomplete="off"  required>
                </div>

                <div class="form-group">
                    <label for="email">Email address</label>
                    <input name="email" value="{{$user->email}}" type="email" class="form-control" id="email" placeholder="Enter email" autocomplete="off"  required>
                </div>

                <div class="form-group">
                    <label for="password">New Password</label>
                    <input name="password" type="password" class="form-control" id="password" placeholder="Eneter new password" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input name="password_confirmation" type="password" class="form-control" id="password_confirmation" placeholder="Confirm new password" autocomplete="off" >
                </div>

                @if($user->id)
                    <div class="form-group">
                        <label for="">Roles</label>
                        @foreach($roles as $role)
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" @if($user->hasRole($role->name)) checked @endif name="roles[]" value="{{$role->name}}"> {{$role->display_name}}
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div><!-- /.box-body -->
            <div class="box-footer text-right">
                @if(Auth::User()->can('admin.users.delete') && $user->id!=null)
                <a href="#" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger">Delete</a>
                @endif
                <button class="btn btn-success">Save</button>
            </div><!-- box-footer -->
        </div><!-- /.box -->
    </form>

    @if(Auth::User()->can('admin.users.delete') && $user->id!=null)
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="confirmDelete" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        Warning!!!
                    </div>
                    <div class="panel-body">
                        Are you sure delete user: {{$user->name}} - {{$user->email}}?
                    </div>
                    <div class="panel-footer text-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <a href="{{route('admin.users.delete', $user->id)}}" class="btn btn-danger btn-ok">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection

