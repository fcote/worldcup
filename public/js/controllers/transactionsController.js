/**
 * Controlleur des transactions
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

angular.module('transactionsController', [])

    .controller('transactionsControllerModal', function ($scope, $modal) {

        $scope.open = function () {
            $modal.open({
                templateUrl: '/views/partials/transactionsList.html',
                controller: 'transactionsControllerModalInstance',
                resolve: {
                    transactions: [ "serviceTransaction", "$cookies", function(Transaction, $cookies){
                        return Transaction.GetTransactions($cookies['token']);
                    }]
                }
            });
        };
    })

    .controller('transactionsControllerModalInstance', ["$scope", "$modalInstance", "$cookies", "transactions" , function ($scope, $modalInstance, $cookies, transactions) {
        $scope.transactions = transactions.data;
    }]);
