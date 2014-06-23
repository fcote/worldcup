angular.module('auth', [])

    .run(["$rootScope", "serviceUser", "$state", "$cookies", function($rootScope, User, $state, $cookies) {

        if($cookies.token != null){
            $rootScope.isConnected = true;
        }

        User.getUser($cookies.user_id,$cookies.token)
            .success(function(data) {
                $rootScope.isConnected = true;
                $rootScope.user = data;

                //Evennement lors du changement de page
                $rootScope.$on("$stateChangeStart", function (event, toState, toParams, fromState, fromParams) {
                    $("#content").html("");

                    if($rootScope.isConnected) $state.transitionTo("index");
                    else if($rootScope.isConnected != null)	$state.transitionTo("login");
                    else $rootScope.redirectAlterLoad = {"state" : toState, "params": toParams};

                    $rootScope.success = "";
                    $rootScope.error = "";
                });
            })
            .error(function(data, status, headers, config) {
                $rootScope.isConnected = false;
            });

        $rootScope.$watch('isConnected', function() {

            if($rootScope.isConnected != null){
                if($rootScope.isConnected){
                    $('body').css("background-color", "#fff");
                    User.getUser($cookies.user_id, $cookies.token)
                        .success(function(data) {
                            $rootScope.user = data;
                        })
                }else{
                    $('body').css("background-color", "#333");
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
