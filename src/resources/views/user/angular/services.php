<script type="application/javascript">
    myApp.service("userServicesHttpFacade", function ($http) {

        var apiBase = "/admin/api/user";

        var _listUsers = function (filter, page, size, order_by, order) {
            var parameters = "";

            if(Array.isArray(filter)) {
                parameters += "filter=" + JSON.stringify(filter);
            }
            parameters += "&page=" + page;
            parameters += "&size=" + size;
            parameters += "&order_by=" + order_by;
            parameters += "&order=" + order;

            return $http.get(apiBase + '/?' + parameters);
        };

        var _getUser =  function (id) {
            return $http.get(apiBase + '/' + id);
        };

        var _updateUser = function (user) {
            return $http.post(apiBase + '/', user);
        };

        var _deleteUser = function (id) {
            return $http.get(apiBase + '/' + id + '/delete');
        };

        var _getRoles = function (id) {
            return $http.get(apiBase + '/' + id + '/roles');
        };

        var _attachRoles = function (id, roles) {
            return $http.post(apiBase + '/' + id + '/roles/attach', roles);
        };

        var _detachRoles = function (id, roles) {
            return $http.post(apiBase + '/' + id + '/roles/detach', roles);
        };

        return {
            listUsers   : _listUsers,
            getUser     : _getUser,
            updateUser  : _updateUser,
            deleteUser  : _deleteUser,
            getRoles    : _getRoles,
            attachRoles : _attachRoles,
            detachRoles : _detachRoles
        }

    });
</script>