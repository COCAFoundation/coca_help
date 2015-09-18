'use strict';

var myApp = angular.module('myApp', [
    'ngRoute',
    'appControllers',
    'jlareau.pnotify',
    'formService',
    'ngCookies'
]);


myApp.config(['$routeProvider', function($routeProvider) {
    $routeProvider.
    when('/form', {
        templateUrl: './static/partials/form.html',
        controller: 'formController'
    }).
    when('/success', {
        templateUrl: './static/partials/success.html',
        controller: 'successController'
    }).
    otherwise({
        templateUrl: './static/partials/form.html',
        controller: 'formController'
    });
}]);



/*********************
*  Database Services *
**********************/

var formService = angular.module('formService', ['ngResource']);

formService.factory('Form', ['$resource',
  function($resource){
    return $resource('./api/send_email/', {}, {
      'save': {method:'POST', headers: {'Content-Type': 'application/x-www-form-urlencoded'}, isArray:false},
    });
  }]);




