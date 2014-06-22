angular.module('auth', [])

    .run(["$rootScope", "serviceUser", "$state", "$cookies", function($rootScope, User, $state, $cookies) {


        $rootScope.$watch('isConnected', function() {

            if($rootScope.isConnected != null){
                if($rootScope.isConnected){
                    User.getUser($cookies.user_id)
                        .success(function(data) {
                            $rootScope.user = data;
                        })
                }else{
                    $state.transitionTo('login');
                }
            }

        })
    }]);
