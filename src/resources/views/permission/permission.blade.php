@extends('vendor.hobord.admin.layout.admin_layout')

@section('content_header')
    <h1>
        Roles and Permissions
        <small>You can manage Roles and permissions.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('admin.index')}}"><i class="fa fa-dashboard"></i>Home</a></li>
        <li><a href="{{route('admin.acl')}}" class=""><i class="fa fa-check-square"></i>Roles and Permissions</a></li>
        <li><a href="#" class="active"><i class="fa fa-check-square"></i>Permission</a></li>
    </ol>
@endsection

@section('content')
    <form action="{{route('admin.acl.edit.permission.save')}}" method="post">{{ csrf_field() }}
        <input type="hidden" name="id" value="{{$permission->id}}">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Create / Edit Permission</h3>
            <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body">

                <div class="form-group">
                    <label for="name">Name</label>
                    <input name="display_name" value="{{$permission->display_name}}" type="text" class="form-control" id="name" placeholder="Enter permission display name" autocomplete="off"  required>
                </div>
                <div class="form-group">
                    <label for="name">Machine name</label>
                    <input name="name" value="{{$permission->name}}" type="text" class="form-control" id="name" placeholder="Enter permission machine name" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="name">Description</label>
                    <input name="description" value="{{$permission->description}}" type="text" class="form-control" id="name" placeholder="Enter permission description" autocomplete="off" >
                </div>
            </form>
        </div><!-- /.box-body -->
        <div class="box-footer text-right">
            @if($permission->id!=null)
                <a href="#" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger">Delete</a>
            @endif
            <button class="btn btn-success">Save</button>
        </div><!-- box-footer -->
    </div><!-- /.box -->
    </form>

    @if($permission->id!=null)
        <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="confirmDelete" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            Warning!!!
                        </div>
                        <div class="panel-body">
                            Are you sure delete Permission: {{$permission->display_name}} - [{{$permission->name}}]?
                        </div>
                        <div class="panel-footer text-right">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <a href="{{route('admin.acl.delete.permission', ['id'=>$permission->id])}}" class="btn btn-danger btn-ok">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection