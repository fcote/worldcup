@extends('template')

@section('body')
ng-app="worldcup" ng-controller="mainController"
@stop

@section('content')
    <div id="content" ui-view></div>
@stop