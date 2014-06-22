/**
 * Application AngularJs
 *
 * @author     Fabien Côté <fcote@alter-frame.com>
 * @copyright  2014 Alter Frame
 * @version    0.1.0
 * @since      0.1.0
 */

var worldcup = angular.module('worldcup', ['ui.router', 'angular-loading-bar', 'ui.bootstrap', 'services']);

worldcup.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('##');
    $interpolateProvider.endSymbol('##');
});