@extends('vendor.hobord.admin.layout.admin_layout')

@section('content')
    @parent
    <form method="post" action="{{route('admin.users.edit',$user->id)}}">{{ csrf_field() }}
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Edit user</h3>
                <div class="box-tools pull-right">
                    <!-- Buttons, labels, and many other things can be placed here! -->

                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input name="name" value="{{$user->name}}" type="text" class="form-control" id="name" placeholder="Enter full name" autocomplete="off" >
                </div>

                <div class="form-group">
                    <label for="email">Email address</label>
                    <input name="email" value="{{$user->email}}" type="email" class="form-control" id="email" placeholder="Enter email" autocomplete="off" >
                </div>

                <div class="form-group">
                    <label for="password">New Password</label>
                    <input name="password" type="password" class="form-control" id="password" placeholder="Eneter new password" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input name="password_confirmation" type="password" class="form-control" id="password_confirmation" placeholder="Confirm new password" autocomplete="off" >
                </div>


            </div><!-- /.box-body -->
            <div class="box-footer">
                <button class="btn btn-success">Save</button>
            </div><!-- box-footer -->
        </div><!-- /.box -->
    </form>
@endsection