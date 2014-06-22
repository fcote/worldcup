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

var worldcup = angular.module('worldcup', ['ui.router', 'ngCookies', 'angular-loading-bar', 'ui.bootstrap', 'services', 'accountController', 'auth']);

worldcup.config(function($locationProvider, $stateProvider, $urlRouterProvider) {
    $locationProvider.html5Mode(true);

    $urlRouterProvider.otherwise('/');

    $stateProvider
        .state('register', {
            url: '/register',
            templateUrl: '/views/partials/registerForm.html',
            controller: 'accountControllerRegister'
        })

        .state('login', {
            url: '/login',
            templateUrl: '/views/partials/loginForm.html',
            controller: 'accountControllerLogin',
        })

        .state('index', {
            url: '/'
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


worldcup.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('*-*');
    $interpolateProvider.endSymbol('*-*');
});