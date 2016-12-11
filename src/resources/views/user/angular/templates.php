
<script type="text/ng-template" id="hobord.admin.user.list.html">
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
        <tr ng-repeat="user in users">
            <td ng-click="editUser(user)">{{ user.name }}</td>
            <td ng-click="editUser(user)">{{ user.email }}</td>
            <td>
                <span ng-repeat="role in user.roles">
                    {{ role.display_name }}
                </span>
            </td>
            <td>{{user.updated_at}}</td>
            <td>{{user.created_at}}</td>
        </tr>
        </tbody>
    </table>
</script>


<script type="text/ng-template" id="hobord.admin.user.edit.html">
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
                <input name="name"
                       value="{{editUser.name}}"
                       ng-model="editUser.name"
                       type="text" class="form-control"
                       id="name"
                       placeholder="Enter full name"
                       autocomplete="off"
                       required>
            </div>

            <div class="form-group">
                <label for="email">Email address</label>
                <input name="email"
                       value="{{editUser.email}}"
                       ng-model="editUser.email"
                       type="email"
                       class="form-control"
                       id="email"
                       placeholder="Enter email"
                       autocomplete="off"
                       required>
            </div>

            <div class="form-group">
                <label for="password">New Password</label>
                <input name="password"
                       type="password"
                       ng-model="editUser.password"
                       class="form-control"
                       id="password"
                       placeholder="Eneter new password"
                       autocomplete="off">
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input name="password_confirmation"
                       type="password"
                       ng-model="editUser.password"
                       class="form-control"
                       id="password_confirmation"
                       placeholder="Confirm new password"
                       autocomplete="off">
            </div>
            <div class="form-group">
                <label for="">Roles</label>
                <div class="checkbox">
                    <label ng-repeat="role in roles">
                        <input type="checkbox"
                               ng-model="editUserRoles[role.id]"
                               ng-checked="userHasRole(editUser, role)"
                               ng-change="changeUserRole(editUser, role.id)">
                        {{ role.display_name }}
                    </label>
                </div>

            </div>
        </div><!-- /.box-body -->
        <div class="box-footer text-right">
            <button data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger">Delete</button>
            <button class="btn btn-success">Save</button>
        </div><!-- box-footer -->
    </div><!-- /.box -->
    </div>
</script>

<script type="text/ng-template" id="hobord.admin.user.edit.html">
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="confirmDelete" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        Warning!!!
                    </div>
                    <div class="panel-body">
                        Are you sure delete user: {{editUser.name}} - {{editUser.email}}?
                    </div>
                    <div class="panel-footer text-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-danger btn-ok" ng-click="deleteUser(editUser)">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>