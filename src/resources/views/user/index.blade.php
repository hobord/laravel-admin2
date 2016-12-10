@extends('vendor.hobord.admin.layout.admin_layout')

@section('angular_templates')
    @include('vendor.hobord.admin.user.angular.templates')
@endsection

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
<div ng-controller="userCtrl">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Users</h3>
            <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                @if(Auth::User()->can('admin.users.create'))
                    <button class="btn btn-success" ng-click="editUser(null)">Create User</button>
                @endif
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div user-list></div>
        </div><!-- /.box-body -->
        <div class="box-footer">

        </div><!-- box-footer -->
    </div><!-- /.box -->
</div>
@endsection

@section('footer_scripts')

    @include('vendor.hobord.admin.user.angular.services')
    @include('vendor.hobord.admin.user.angular.controller')


@endsection