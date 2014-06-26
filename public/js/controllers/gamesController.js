/**
 * Controlleur des matches
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

angular.module('gamesController', [])

    .controller('gamesControllerList', ["$scope", "$http", "serviceGame", "$cookies", "$modal", function($scope, $http, Game, $cookies, $modal) {
        Game.GetNext($cookies.token)
            .success(function(data) {
                $scope.games = data;
            });

        $scope.filterList = function(){
            $('#filter-bracket').parent('li').removeClass('active');
            $('#filter-list').parent('li').addClass('active');
            $('#bracket').hide();
            $('#games').show();
        };

        $scope.filterBracket = function(){
            $('#filter-list').parent('li').removeClass('active');
            $('#filter-bracket').parent('li').addClass('active');
            $('#games').hide();
            $('#bracket').show();
        };

    }])

