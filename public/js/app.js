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

var worldcup = angular.module('worldcup', ['ui.router', 'ngCookies', 'angular-loading-bar', 'ui.bootstrap', 'services', 'accountsController', 'gamesController', 'auth']);

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
            access: accessLevels.user
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

                return $q.reject(rejection);
            }
        };
    });
}]);

worldcup.config(['cfpLoadingBarProvider', function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = false;
}]);


worldcup.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('@@');
    $interpolateProvider.endSymbol('@@');
});

$( "#filter-list" ).click(function() {

});

