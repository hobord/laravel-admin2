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
                <a href="#" class="btn btn-success" ng-click="editPermission(null);">Create Permission</a>
                <a href="#" class="btn btn-success" ng-click="editRole(null);">Create Role</a>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body">
            <table class="table table-striped table-condensed">
                <thead>
                <tr>
                    <th>Permission</th>
                    <th ng-repeat="role in roles">
                        <a href="#" data-toggle="tooltip" title="{{role.description}} [{{role.name}}]" ng-click="editRole(role)">{{role.display_name}}</a>
                    </th>
                </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="permission in permissions">
                        <td>
                            <div class="checkbox">
                                <label>
                                    <a href="#" data-toggle="tooltip" title="{{permission.description}} [{{permission.name}}]" ng-click="editPermission(permission)">{{permission.display_name}}</a>
                                </label>
                            </div>
                        </td>
                        <td ng-repeat="permission in permissions">
                            <div class="checkbox">
                                <label><input type="checkbox" ng-change="setRolePermission(role,permission)" ng-checked="roleHasPermission(role,permission)" /></label>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div><!-- /.box-body -->
        <div class="box-footer text-right">
            <button class="btn btn-success">Save</button>
        </div><!-- box-footer -->
    </div><!-- /.box -->

@endsection
