'use strict';

var myApp = angular.module('myApp', [
    'ngRoute',
    'appControllers',
    'jlareau.pnotify'
]);


myApp.config(['$routeProvider', function($routeProvider) {
    $routeProvider.
    when('/form', {
        templateUrl: './static/partials/form.html',
        controller: 'formController'
    }).
    when('/success', {
        templateUrl: './static/partials/success.html',
        controller: 'formController'
    }).
    otherwise({
        templateUrl: './static/partials/form.html',
        controller: 'formController'
    });
}]);


var menuBarApp = angular.module('menuBarApp', [
    'ngRoute',
    'menuBarAppController'
]);






/*********************
*  Database Services *
**********************/

var dbServices = angular.module('dbServices', ['ngResource']);

dbServices.factory('User', ['$resource',
  function($resource){
    return $resource('/api/user/:userId', {}, {
      'query': {method:'GET', isArray:false},
      'get': {method:'GET', params:{userId:'users'}, isArray:false},
      'save': {method:'POST', isArray:false},
      'delete': {method:'DELETE', isArray:false},
      'put': {method:'PUT', isArray:false}
    });
  }]);




