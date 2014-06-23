/**
 * Controlleur des comptes utilisateurs
 *
 * AngularJS version 1.2.0
 *
 * @category   angular controller
 * @package    worldcup\public\js\controllers
 * @author     Clément Hémidy <clement@hemidy.fr>, Fabien Côté <fabien.cote@me.com>
 * @copyright  2014 Clément Hémidy, Fabien Côté
 * @version    0.1
 * @since      0.1
 */

angular.module('accountsController', [])

    .controller('accountsControllerRegister', ["$scope", "$http", "serviceUser", "$rootScope", "$state", function($scope, $http, User, $rootScope, $state) {

        $scope.registerSubmit = function(){
            User.register($scope.email, $scope.password, $scope.firstname, $scope.lastname)
                .success(function() {
                   $state.transitionTo("login");
                });
        }
    }])

    .controller('accountsControllerLogin', ["$scope", "$http", "serviceUser", "$rootScope", "$state", "$cookies", function($scope, $http, User, $rootScope, $state, $cookies) {

        $scope.loginSubmit = function(){
            User.login($scope.email, $scope.password)
                .success(function(data) {
                    $rootScope.isConnected = true;

                    $cookies.token = data.id;
                    $cookies.user_id = data.user_id;

                    $state.transitionTo("games");
                });
        };

    }]);
