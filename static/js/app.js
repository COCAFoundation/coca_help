'use strict';

var myApp = angular.module('myApp', [
    'ngRoute',
    'appControllers',
    'jlareau.pnotify',
    'emailService',
    'ngCookies',
    'formly',
    'formlyBootstrap'
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
    })
    otherwise({
        templateUrl: './static/partials/testForm.html',
        controller: 'formController'
    });
}]);



myApp.config(function(formlyConfigProvider) {
    // set templates here
    formlyConfigProvider.setWrapper({
      name: 'horizontalBootstrapLabel',
      template: [
        '<label for="{{::id}}" class="col-sm-4 control-label">',
          '{{to.label}} {{to.required ? "*" : ""}}',
        '</label>',
        '<div class="col-sm-8">',
          '<formly-transclude></formly-transclude>',
        '</div>'
      ].join(' ')
    });
    
    formlyConfigProvider.setWrapper({
      name: 'horizontalBootstrapCheckbox',
      template: [
        '<div class="col-sm-offset-2 col-sm-8">',
          '<formly-transclude></formly-transclude>',
        '</div>'
      ].join(' ')
    });
    
    formlyConfigProvider.setType({
      name: 'horizontalInput',
      extends: 'input',
      wrapper: ['horizontalBootstrapLabel', 'bootstrapHasError']
    });
    
    formlyConfigProvider.setType({
      name: 'horizontalCheckbox',
      extends: 'checkbox',
      wrapper: ['horizontalBootstrapCheckbox', 'bootstrapHasError']
    });

});



/******************
*  Email Services *
*******************/

var emailService = angular.module('emailService', ['ngResource']);

emailService.factory('Email', ['$resource',
  function($resource){
    return $resource('./api/send_email/', {}, {
      'save': {method:'POST', headers: {'Content-Type': 'application/x-www-form-urlencoded'}, isArray:false},
    });
  }]);


