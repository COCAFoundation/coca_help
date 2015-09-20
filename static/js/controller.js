'use strict';

    var appControllers = angular.module("appControllers", []);

    appControllers.controller('successController', ['$scope', '$http', '$routeParams', '$location', '$cookies', function($scope, $http, transformRequestAsFormPost, $location, $cookies) {
    	
        $scope.newApplication = function() {
			$cookies.remove('entry');
			$scope.entry = null;
        	$location.path( "/form"); 
        };


    }]);

    appControllers.controller("oldFormController",['$scope', '$http', '$routeParams', '$location', 'Email', 'notificationService', '$cookies', function($scope, $http, transformRequestAsFormPost, $location, Email, notificationService, $cookies) {
        
        console.log('Starting up Form, checking for cookies');
        console.log($cookies.getAll());

        if($cookies.get('entry')){
        	console.log('Found saved form entry....loading');
        	console.log(angular.fromJson($cookies.get('entry')));
        	$scope.entry = angular.fromJson($cookies.get('entry'));
        	$scope.entry.project_start_date = new Date($scope.entry.project_start_date);
         	$scope.entry.project_end_date = new Date($scope.entry.project_end_date);       	
        	notificationService.success('Loaded Saved Form!');
        }else{
        	console.log('No saved form entry Found');        	
        }


        $scope.submit = function() {

        	$scope.submitted = true;
        	console.log('Submitting Form');
        	notificationService.info("Submitting Form");
            if ($scope.aidForm.$valid && typeof $scope.entry !== 'undefined'){
            	console.log($scope.entry)
	            Email.save($.param($scope.entry),$.param($scope.entry), function(data){
	            	console.log(data);
	   				if(data.error == null || data.error == 'null'){
	            		notificationService.success("Form Submitted Successfully");	 
	            		 $location.path( "/success");   					
	   				}else{
	   					notificationService.success("There was an issue with the form, please contact info@childrenofcentralasia");
	   				}
	            });
            }else{
            	console.log($scope.aidForm.$error);
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

    



appControllers.controller("formController",['$scope', '$http', '$routeParams', '$location', 'Email', 'notificationService', '$cookies', 'formlyVersion', function($scope, $http, transformRequestAsFormPost, $location, Email, notificationService, $cookies, formlyVersion) {



    // variable assignment
    $scope.model = {};


    console.log('Starting up Form, checking for cookies');
    console.log($cookies.getAll());


    if($cookies.get('model')){
    	console.log('Found saved form model....loading');
    	console.log(angular.fromJson($cookies.get('model')));
    	$scope.model = angular.fromJson($cookies.get('model'));
    	$scope.model.project_start_date = new Date($scope.model.project_start_date);
     	$scope.model.project_end_date = new Date($scope.model.project_end_date);       	
    	notificationService.success('Loaded Saved Form!');
    }else{
    	console.log('No saved form model Found');        	
    }


 	$http.get('./static/partials/form.json')
       .then(function(res){
       	console.log(res.data);
          $scope.formFields = res.data;                
       });


    $scope.submit = function() {
       	$scope.submitted = true;
       	console.log($scope.model);

        if ($scope.aidForm.$valid && typeof $scope.model !== null){
        	console.log('Submitting Form');
        	notificationService.info('Submitting Form');
			Email.save($.param($scope.model),$.param($scope.model), function(data){
            	console.log(data);
   				if(data.error == null || data.error == 'null'){
            		notificationService.success("Form Submitted Successfully");	 
            		 $location.path( "/success");   					
   				}else{
   					notificationService.success("There was an issue with the form, please contact info@childrenofcentralasia");
   				}
            });


        }else{
        	console.log($scope.aidForm.$error);
        	notificationService.error('Please check the form for errors');
        }

    };

 

    $scope.save = function() {
    	console.log('Saving Form');
    	console.log('Saving: '+JSON.stringify($scope.model));

		var now = new Date(),
		    // this will set the expiration to 6 months
		    exp = new Date(now.getFullYear(), now.getMonth()+6, now.getDate());

		$cookies.put('model', JSON.stringify($scope.model),{
		  expires: exp
		});

    	notificationService.success('Saved Form');
    };


    $scope.clear = function() {
    	console.log('Clearing Form');

		var now = new Date(),
		    // this will set the expiration to 6 months
		    exp = new Date(now.getFullYear(), now.getMonth()+1, now.getDate());

		$cookies.remove('model');

		$scope.model = {};
    	notificationService.info('Cleared Form');
    };


}]);

    