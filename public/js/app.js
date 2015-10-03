/**
 * Définition de l'application Angular
 *
 * AngularJS version 1.2.0
 *
 * @category   angular application
 * @package    worldcup\public\js
 * @author     Clément Hémidy <clement@hemidy.fr>, Fabien Côté <fabien.cote@me.com>
 * @copyright  2014 Clément Hémidy, Fabien Côté
 * @version    1.0
 * @since      0.1
 */

var worldcup = angular.module('worldcup', ['ngCookies', 'ui.router' , 'angular-loading-bar', 'ui.bootstrap', 'services', 'accountsController', 'gamesController', 'betsController', 'transactionsController', 'usersController', 'auth']);

worldcup.config(function($locationProvider, $stateProvider, $urlRouterProvider) {

    $locationProvider.html5Mode({
        enabled: true,
        requireBase: false
    });

    $urlRouterProvider.otherwise('/');


    $stateProvider
        .state('register', {
            url: '/register',
            templateUrl: '/views/partials/registerForm.html',
            controller: 'accountsControllerRegister',
            access: accessLevels.public
        })

        .state('login', {
            url: '/login',
            templateUrl: '/views/partials/loginForm.html',
            controller: 'accountsControllerLogin',
            access: accessLevels.public
        })

        .state('account', {
            url: '/account',
            templateUrl: '/views/partials/accountForm.html',
            access: accessLevels.user
        })

        .state('index', {
            url: '/',
            templateUrl: '/views/partials/gamesList.html',
            controller: 'gamesControllerList',
            access: accessLevels.user,
            resolve: {
                games: [ "serviceGame", "$cookies", function(Game, $cookies){
                    return Game.GetNext($cookies.get('token'));
                }],
                gamesPrevious: [ "serviceGame", "$cookies", function(Game, $cookies){
                    return Game.GetPrevious($cookies.get('token'));
                }],
                bracket: [ "serviceBracket", "$cookies", function(Bracket, $cookies){
                    return Bracket.GetBracket($cookies.get('token'));
                }],
                users: ["serviceUser", "$cookies", function(User, $cookies){
                    return User.getRanking($cookies.get('token'));
                }]
            }
        })




});

worldcup.config(['$httpProvider', function ($httpProvider) {
    $httpProvider.interceptors.push(function ($q, $rootScope) {
        return {
            'response': function (response) {

                $rootScope.error = null;
                $rootScope.exception = null;

                if(response.data.message != undefined)
                    worldcup.alert($rootScope, response.data);

                if(response.data.payload != undefined)
                    response.data = response.data.payload;

                return response;
            },
            'responseError': function (rejection) {

                worldcup.alert($rootScope, rejection);

                if(rejection.status == 401){
                    $rootScope.user = null;
                    $rootScope.isConnected = false;
                    $cookies.remove('token');
                    $cookies.remove('user_id');
                }

                return $q.reject(rejection);
            }
        };
    });
}]);

worldcup.alert = function($scope, infos){
    $scope.alerts = [];

    if(infos.success){
        $scope.alerts.push({message: infos.message, cat: 'success', class: 'success'});
    }

    if(infos.status != undefined){
        if(infos.status == 500)
            $scope.alerts.push({message: infos.data.error.message, type: infos.data.error.type, file: infos.data.error.file, line: infos.data.error.line, cat: 'exception', class: 'danger'});


        if(infos.status != 500)
            $scope.alerts.push({message: infos.data.error, cat: 'error', class: 'danger'});
    }
}

worldcup.closeAlert = function($scope ,index) {
    $scope.alerts.splice(index, 1);
};

worldcup.filter('unsafe', function($sce) {
    return function(val) {
        return $sce.trustAsHtml(val);
    };
});


worldcup.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('@@');
    $interpolateProvider.endSymbol('@@');
});

worldcup.filter('dateToISO', function() {
    return function(input) {
        if(input != "0000-00-00 00:00:00" && input != undefined){
            input = new Date(input).toISOString();
            return input;
        }else
            return null;
    };
});

worldcup.filter('groupBy', ['$parse', function ($parse) {
    return function (list, group_by) {

        var filtered = [];
        var prev_item = null;
        var group_changed = false;
        // this is a new field which is added to each item where we append "_CHANGED"
        // to indicate a field change in the list
        //was var new_field = group_by + '_CHANGED'; - JB 12/17/2013
        var new_field = 'group_by_CHANGED';

        // loop through each item in the list
        angular.forEach(list, function (item) {

            group_changed = false;

            // if not the first item
            if (prev_item !== null) {

                // check if any of the group by field changed

                //force group_by into Array
                group_by = angular.isArray(group_by) ? group_by : [group_by];

                //check each group by parameter
                for (var i = 0, len = group_by.length; i < len; i++) {

                    if ($parse(group_by[i])(prev_item) !== $parse(group_by[i])(item)) {
                        group_changed = true;
                    }
                }


            }// otherwise we have the first item in the list which is new
            else {
                group_changed = true;
            }

            // if the group changed, then add a new field to the item
            // to indicate this
            if (group_changed) {
                item[new_field] = true;
            } else {
                item[new_field] = false;
            }

            filtered.push(item);
            prev_item = item;

        });

        return filtered;
    };
}]);
