angular.module('auth', [])

    .run(["$rootScope", "serviceUser", "$state", "$cookies", function($rootScope, User, $state, $cookies) {

        if($cookies.token != null){
            $rootScope.isConnected = true;
        }

        $rootScope.$watch('isConnected', function() {

            if($rootScope.isConnected != null){
                if($rootScope.isConnected){
                    User.getUser($cookies.user_id, $cookies.token)
                        .success(function(data) {
                            $rootScope.user = data;
                        })
                }else{
                    $state.transitionTo('login');
                }
            }
        })
    }])

    .controller('authController', ["$rootScope", "$scope", "serviceUser", "$cookies", "$cookieStore", function($rootScope, $scope, User, $cookies, $cookieStore) {

        $scope.logout = function(){
            User.logout($cookies.token)
                .success(function(){
                    $rootScope.user = null;
                    $rootScope.isConnected = false;
                    $cookieStore.remove('token');
                    $cookieStore.remove('user_id');
                });
        }

    }]);
