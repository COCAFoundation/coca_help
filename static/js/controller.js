'use strict';

    var appControllers = angular.module("appControllers", []);



    appControllers.controller("formController",['$scope', '$http', '$routeParams', '$location', 'Form', 'notificationService', function($scope, $http, transformRequestAsFormPost, $location, Form, notificationService) {
        $scope.submit = function() {
            if ($scope.aidForm.$valid && typeof $scope.entry !== 'undefined'){
            	notificationService.success("Form Submitted!");
	            //Form.save($.param($scope.entry));
	            //$location.path( "/success");        
            }else{
            	notificationService.error('Please check the form for errors');
            }

        };
    }]);


    