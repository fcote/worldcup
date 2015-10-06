/**
 * Controlleur des paris
 *
 * AngularJS version 1.2.0
 *
 * @category   angular controller
 * @package    worldcup\public\js\controllers
 * @author     Clément Hémidy <clement@hemidy.fr>, Fabien Côté <fabien.cote@me.com>
 * @copyright  2014 Clément Hémidy, Fabien Côté
 * @version    1.0
 * @since      0.1
 */

angular.module('betsController', [])

    .controller('betsControllerModal', function ($scope, $modal) {

        $scope.open = function (game, user) {
            $modal.open({
                templateUrl: '/views/partials/betForm.html',
                controller: 'betsControllerModalInstance',
                resolve: {
                    game: function(){
                        return game;
                    },
                    user: function(){
                        return user;
                    },
                    bet: [ "serviceBet", "$cookies", function(Bet, $cookies){
                        return Bet.GetBet($cookies.get('token'), game.id);
                    }],
                    distances: [ "serviceBet", "$cookies", function(Bet, $cookies){
                        return Bet.GetDistances($cookies.get('token'));
                    }]
                }
            });
        };
    })

    .controller('betsControllerModalInstance', ["$scope", "$modalInstance", "$cookies", "game", "user", "serviceBet", "bet", "distances" , function ($scope, $modalInstance, $cookies, game, user, Bet, bet, distances) {
        $scope.game = game;

        if(bet.data[0] != undefined){
            $scope.bet = bet.data[0];
        }else{
            $scope.bet = {};
        }

        $scope.teams = [game.team1, game.team2];

        $scope.distances = distances.data;

        $scope.ok = function () {
            if($scope.bet == {}){
                $modalInstance.close(
                    Bet.placeBet($cookies.get('token'), user.id, game.id, $scope.bet.points, $scope.bet.distance_points, $scope.bet.winner_id)
                        .success(function() {
                            user.points = parseInt(user.points) - parseInt($scope.bet.points);
                        })
                );
            }else{
                $modalInstance.close(
                    Bet.updateBet($cookies.get('token'), $scope.bet.id, $scope.bet.points, $scope.bet.distance_points, $scope.bet.winner_id)
                        .success(function(data) {
                            user.points = data.user.points;
                        })
                );
            }
        };

        $scope.cancel = function () {
            $modalInstance.dismiss('cancel');
        };
    }]);