@extends('vendor.hobord.admin.layout.admin_layout')

@section('content_header')
    <h1>
        Roles and Permissions
        <small>You can manage Roles and permissions.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('admin.index')}}"><i class="fa fa-dashboard"></i>Home</a></li>
        <li><a href="#" class="active"><i class="fa fa-check-square"></i>Roles and Permissions</a></li>
    </ol>
@endsection

@section('content')

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Roles and Permissions</h3>
            <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                    <a href="{{route('admin.acl.edit.permission')}}" class="btn btn-success">Create Permission</a>
                    <a href="{{route('admin.acl.edit.role')}}" class="btn btn-success">Create Role</a>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body">
            <table class="table table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Permission</th>
                        @foreach($roles as $role)
                        <th>
                            <a href="{{route('admin.acl.edit.role').'/'.$role->id}}" data-toggle="tooltip" title="{{$role->description}} [{{$role->name}}]">{{$role->display_name}}</a>
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $permission)
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label>
                                    <a href="#" data-toggle="tooltip" title="{{$permission->description}} [{{$permission->name}}]">{{$permission->display_name}}</a>
                                </label>
                            </div>
                        </td>
                        @foreach($roles as $role)
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" name="permissions[{{$role->name}}][]" @if($role->hasPermission($permission->name)) checked @endif>{{$permission->display_name}}</label>
                            </div>
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- /.box-body -->
        <div class="box-footer">

        </div><!-- box-footer -->
    </div><!-- /.box -->

@endsection