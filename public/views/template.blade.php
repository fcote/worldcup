<!-- Template principal -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
    <title>Worldcup</title>
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

    @yield('scripts')

</head>
<body @yield('body') >

<div class="guest" ng-hide="isConnected">
    <div class="container">
        <img src="/images/WCLoginLogo.png" alt=""/>
    </div>
</div>

<header ng-show="isConnected">
    <div class="navbar navbar-inverse" role="navigation" >
        <div class="container-fluid">
            <a class="navbar-brand" href="/"><img src="/images/WClogo.png"/></a>
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


<div class="container" ng-hide="!exception" >
    <div class="row">
        <div class="large-12 columns">
            <div data-alert class="alert-box alert radius" style="font-size: 16px;">
                @@ exception.message @@ <small>@@ exception.type @@</small><br />
                @@ exception.file @@ <small>@@ exception.line @@</small>
            </div>
        </div>
    </div>
</div>
<div class="container" ng-hide="!error" >
    <div class="row">
        <div class="large-12 columns">
            <div data-alert class="alert-box warning radius" style="font-size: 16px;">
                @@ error @@
            </div>
        </div>
    </div>
</div>

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