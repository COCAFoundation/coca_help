'use strict';

    var appControllers = angular.module("appControllers", []);



    appControllers.controller("formController",['$scope', '$http', '$routeParams', '$location', 'Form', 'notificationService', '$cookies', function($scope, $http, transformRequestAsFormPost, $location, Form, notificationService, $cookies) {
        
        console.log('Starting up Form, checking for cookies');
        console.log($cookies.getAll());

        if($cookies.get('entry')){
        	console.log('Found Entry');
        	console.log(angular.fromJson($cookies.get('entry')));
        	$scope.entry = angular.fromJson($cookies.get('entry'));
        	notificationService.success('Loaded Saved Form!');
        }else{
        	console.log('No Entry Found');        	
        }


        $scope.submit = function() {
        	$scope.submitted = true;
        	console.log('Submitting Form');
            if ($scope.aidForm.$valid && typeof $scope.entry !== 'undefined'){
            	console.log($scope.entry)
            	notificationService.success("Form Submitted!");
	            //Form.save($.param($scope.entry));
	            //$location.path( "/success");        
            }else{
            	notificationService.error('Please check the form for errors');
            }
        };

        $scope.save = function() {
        	console.log('Saving Form');
        	console.log('Saving: '+JSON.stringify($scope.entry));

			var now = new Date(),
			    // this will set the expiration to 6 months
			    exp = new Date(now.getFullYear(), now.getMonth()+6, now.getDate());

			$cookies.put('entry', JSON.stringify($scope.entry),{
			  expires: exp
			});

        	notificationService.success('Saved Form');
        };


        $scope.clear = function() {
        	console.log('Clearing Form');

			var now = new Date(),
			    // this will set the expiration to 6 months
			    exp = new Date(now.getFullYear(), now.getMonth()+1, now.getDate());

			$cookies.remove('entry');

			$scope.entry = null;
        	notificationService.info('Cleared Form');
        };


    }]);

    