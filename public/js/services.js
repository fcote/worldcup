/**
 * Services angularJS
 *
 * AngularJS version 1.2.0
 *
 * @category   angular controller
 * @package    worldcup\public\js
 * @author     Clément Hémidy <clement@hemidy.fr>, Fabien Côté <fabien.cote@me.com>
 * @copyright  2014 Clément Hémidy, Fabien Côté
 * @version    1.0
 * @since      0.1
 */


angular.module('services', [])

    .factory('serviceUser', function($http, $rootScope) {
        return {

            authorize: function(accessLevel, role) {
                if(role === undefined)
                    if($rootScope.user != null)
                        role = userRoles.user;
                    else
                        role = userRoles.public;

                return accessLevel & role;
            },

            getUser : function(id, token) {
                return $http.get('/api/users/' + id + '?token=' + token);
            },

            getRanking : function(token) {
              return $http.get('/api/users?token=' + token /*+ '&orderby=points&order=DESC'*/);
            },

            login : function(login, pass) {
                return $http({
                    method: 'POST',
                    url: '/api/users/login',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param({"login" : login, "password" : pass})
                });
            },

            logout : function(token) {
                return $http.get('/api/users/logout?token=' + token);
            },

            register : function(login, pass) {
                return $http({
                    method: 'POST',
                    url: 'api/users',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param({"login" : login, "password" : pass})
                });
            },

            update : function(token,userId,userData) {
                return $http({
                    method: 'PUT',
                    url: 'api/users/' + userId + '?token=' + token,
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(userData)
                })
            }

        }
    })

    .factory('serviceGame', function($http) {
        return {
            GetNext : function(token, gameId){
                return $http.get('api/games/'+gameId+'?token=' + token + '');
            },
            GetNext : function(token){
                return $http.get('api/games?token=' + token + '&winner_id=null&team1_id!=null&team2_id!=null&orderby=date&order=ASC');
            },
            GetPrevious : function(token){
                return $http.get('api/games?token=' + token + '&winner_id!=null&team1_id!=null&team2_id!=null&orderby=date&order=DESC');
            }
        }
    })

    .factory('serviceTransaction', function($http) {
        return {
            GetTransactions : function(token){
                return $http.get('api/transactions?token=' + token + '&orderby=updated_at&order=DESC');
            }
        }
    })

    .factory('serviceBracket', function($http) {
        return {
            GetBracket : function(token){
                return $http.get('api/bracket?token=' + token);
            }
        }
    })

    .factory('serviceBet', function($http) {
        return {
            placeBet : function(token, userId, gameId, winnerId, team1_points, team2_points){
                return $http({
                   method: 'POST',
                    url: 'api/bets?token=' + token,
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param({"user_id" : userId, "game_id" : gameId, "team1_points" : team1_points, "team2_points" : team2_points, "winner_id" : winnerId})
                });
            },
            updateBet : function(token, betId, winnerId, team1_points, team2_points){
                return $http({
                    method: 'PUT',
                    url: 'api/bets/'+betId+'/?token=' + token,
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param({"team1_points" : team1_points, "team2_points" : team2_points, "winner_id" : winnerId})
                });
            },
            GetBet : function(token, gameId){
                return $http.get('api/bets?token=' + token + '&game_id=' + gameId);
            }
        }
    })