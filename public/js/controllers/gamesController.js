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

    .controller('gamesControllerList', ["$scope", "games", "bracket", function($scope, games, bracket) {
        $scope.games = games.data;

        $('#bracket').bracket({
            init: bracket.data, /* data to initialize the bracket with */
            decorator: {
                edit: acRenderFn,
                render: acRenderFn
            },
            onMatchHover: onhover
        })

        $('#bracket').hide();
        $('#games').show();

        $scope.filterList = function(){
            $('#filter-bracket').parent('li').removeClass('active');
            $('#filter-list').parent('li').addClass('active');
            $('.bracket-header').hide();
            $('#bracket').hide();
            $('.game-header').show();
            $('#games').show();
        };

        $scope.filterBracket = function(){
            $('#filter-list').parent('li').removeClass('active');
            $('#filter-bracket').parent('li').addClass('active');
            $('.game-header').hide();
            $('#games').hide();
            $('.bracket-header').show();
            $('#bracket').show();
        };

    }])

function acRenderFn(container, data, score) {
    if (!data.flag || !data.name)
        container.append(data.tmp)
    else{
        container.append('<img width="15px" src="/images/flags/'+data.flag+'.png" /> ').append(data.name)
    }
}

function onhover(data, hover) {
    if(hover)
        $('.team.highlight').tooltip({'title' : data});
    else
        $('.team.highlight').tooltip('destroy');
}