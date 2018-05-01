<!-- Template principal -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
    <title>Coupe du Monde de la FIFA, Russie 2018™</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!-- BOWER COMPONENTS -->
    <link rel="stylesheet" type="text/css" href="/bower_components/bootstrap/dist/css/bootstrap.min.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/bower_components/angular-loading-bar/build/loading-bar.min.css"/>
    <link rel="stylesheet" href="/bower_components/fontawesome/css/font-awesome.min.css"/>

    <script src="/bower_components/jquery/dist/jquery.js" type="text/javascript"></script>
    <script src="/bower_components/angular/angular.min.js" type="text/javascript"></script>
    <script src="/bower_components/angular-cookies/angular-cookies.js" type="text/javascript"></script>
    <script src="/bower_components/angular-ui-router/release/angular-ui-router.min.js" type="text/javascript" ></script>
    <script src="/bower_components/angular-bootstrap/ui-bootstrap.min.js" type="text/javascript"></script>
    <script src="/bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js" type="text/javascript"></script>
    <script src="/bower_components/angular-loading-bar/build/loading-bar.min.js" type="text/javascript"></script>
    <script src="/js/jquery.gracket.min.js"></script>

    <!-- CUSTOM -->
    <link rel="stylesheet" type="text/css" href="/css/worldcup.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/css/animate.css" media="screen" />
    <link rel="icon" type="image/png" href="/images/favicon.png" />
	
	<base href="http://worldcup.hemidy.fr/">

    @yield('scripts')

</head>
<body @yield('body') >

<div class="guest" ng-hide="isConnected">
    <div class="container">
        <img src="/images/WCLogo.png" alt=""/>
    </div>
</div>

<header ng-show="isConnected">
    <div class="navbar navbar-inverse" role="navigation" >
        <div class="container-fluid">
            <a class="navbar-brand" href="/"><img src="/images/WCLogo.png"/></a>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#" ng-click="account(user)" ng-controller="usersControllerModal"><i class="fa fa-user"></i></a></li>
                    <li><a href="#" ng-click="ranking()" ng-controller="usersControllerModal"><i class="fa fa-users"></i></a></li>
                    <li><a href="#" ng-click="logout()"><i class="fa fa-sign-out"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</header>



<alert ng-repeat="alert in alerts" type="@@ alert.class @@" close="closeAlert($index)" id="infos" >
    <div ng-show="alert.cat == 'success'">
        @@ alert.message @@
    </div>
    <div ng-show="alert.cat == 'exception'">
        @@ alert.message @@ <small>@@ alert.type @@</small><br />
        @@ alert.file @@ <small>@@ alert.line @@</small>
    </div>
    <div ng-show="alert.cat == 'error'" ng-bind-html="alert.message | unsafe"></div>
</alert>

@yield('content')


<!-- ANGULARJS -->
<script src="/js/access.js"></script>
<script src="/js/auth.js"></script>
<script src="/js/services.js"></script>
<script src="/js/controllers/accountsController.js"></script>
<script src="/js/controllers/gamesController.js"></script>
<script src="/js/controllers/usersController.js"></script>
<script src="/js/controllers/betsController.js"></script>
<script src="/js/controllers/transactionsController.js"></script>
<script src="/js/app.js"></script>


</body>
</html>