/**
 * Définition de l'application Angular
 *
 * AngularJS version 1.2.0
 *
 * @category   angular application
 * @package    worldcup\public\js
 * @author     Clément Hémidy <clement@hemidy.fr>, Fabien Côté <fabien.cote@me.com>
 * @copyright  2014 Clément Hémidy, Fabien Côté
 * @version    0.1
 * @since      0.1
 */

var worldcup = angular.module('worldcup', ['ui.router', 'ngCookies', 'angular-loading-bar', 'ui.bootstrap', 'services', 'accountsController', 'gamesController', 'betsController', 'transactionsController', 'auth']);

worldcup.config(function($locationProvider, $stateProvider, $urlRouterProvider) {
    $locationProvider.html5Mode(true);

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

        .state('index', {
            url: '/',
            templateUrl: '/views/partials/gamesList.html',
            controller: 'gamesControllerList',
            access: accessLevels.user,
            resolve: {
                games: [ "serviceGame", "$cookies", function(Game, $cookies){
                    return Game.GetNext($cookies.token);
                }],
                bracket: [ "serviceBracket", "$cookies", function(Bracket, $cookies){
                    return Bracket.GetBracket($cookies.token);
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

                if(response.data.payload != undefined)
                    response.data = response.data.payload;

                return response;
            },
            'responseError': function (rejection) {

                worldcup.error($rootScope, rejection);

                if(rejection.status == 401){
                    $rootScope.user = null;
                    $rootScope.isConnected = false;
                    $cookieStore.remove('token');
                    $cookieStore.remove('user_id');
                }

                return $q.reject(rejection);
            }
        };
    });
}]);

worldcup.error = function($scope, rejection){
    $scope.error = null;
    $scope.exception = null;

    if(rejection.status == 500){
        $scope.exception = rejection.data.error;
    }

    if(rejection.status != 500){
        $scope.error = rejection.data.error;
    }
}

worldcup.config(['cfpLoadingBarProvider', function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = false;
}]);


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
