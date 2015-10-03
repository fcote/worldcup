/**
 * Controlleur des matchs
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

angular.module('gamesController', [])

    .controller('gamesControllerList', ["$scope", "games", "gamesPrevious", "bracket", function($scope, games, gamesPrevious, bracket) {
        $scope.games = games.data;
        $scope.gamesPrevious = gamesPrevious.data;

        $("#rounds").gracket({
            src : bracket.data['rounds'],
            cornerRadius : 10,
            canvasLineGap : 10,
            roundLabels : bracket.data['labels']
        });

        $("#third").gracket({
            src : bracket.data['third'],
            cornerRadius : 10,
            canvasLineGap : 10
        });

        // add some labels
        $("#bracket .secondary-bracket .g_winner")
            .parent()
            .css("position", "relative")
            .prepend("<h4>3ème place</h4>")

        $("#bracket > div").eq(0).find(".g_winner")
            .parent()
            .css("position", "relative")
            .prepend("<h4>Gagnant</h4>")

        $('#bracket').hide();
        $('#gamesPrevious').hide();
        $('#games').show();

        $scope.filterList = function(){
            $('#filter-gamesPrevious').parent('li').removeClass('active');
            $('#filter-bracket').parent('li').removeClass('active');
            $('#filter-list').parent('li').addClass('active');
            $('.bracket-header').hide();
            $('#bracket').hide();
            $('.game-header').show();
            $('#games').show();
            $('.game-previous-header').hide();
            $('#gamesPrevious').hide();
        };

        $scope.filterBracket = function(){
            $('#filter-list').parent('li').removeClass('active');
            $('#filter-gamesPrevious').parent('li').removeClass('active');
            $('#filter-bracket').parent('li').addClass('active');
            $('.game-header').hide();
            $('#games').hide();
            $('.bracket-header').show();
            $('#bracket').show();
            $('.game-previous-header').hide();
            $('#gamesPrevious').hide();
        };

        $scope.filterGamesPrevious = function(){
            $('#filter-list').parent('li').removeClass('active');
            $('#filter-bracket').parent('li').removeClass('active');
            $('#filter-gamesPrevious').parent('li').addClass('active');
            $('.game-header').hide();
            $('#games').hide();
            $('.bracket-header').hide();
            $('#bracket').hide();
            $('.game-previous-header').show();
            $('#gamesPrevious').show();
        };

    }])