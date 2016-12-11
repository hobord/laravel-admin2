<script type="application/javascript">
angular.module('hobordAdminUser', [])
.directive('adminUserList', function() {
    return {
        restrict: 'A',
        templateUrl: 'hobord.admin.user.list.html'
    };
});
</script>