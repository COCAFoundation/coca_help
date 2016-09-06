'use strict';

    var appControllers = angular.module("appControllers", []);

    appControllers.controller('successController', ['$scope', '$http', '$routeParams', '$location', '$cookies', function($scope, $http, $routeParams, $location, $cookies) {
    	

        //If no RouteParams are provided, we scrape the hostname for the info we need
        if($routeParams.lg == null){
            if($location.host().indexOf(".org") > -1){
                $scope.lg = 'en';
            }else if($location.host().indexOf(".com") > -1){
                $scope.lg = 'en';
            }else if($location.host().indexOf(".kz") > -1){
                $scope.lg = 'kz';
            }else if($location.host().indexOf(".ru") > -1){
                $scope.lg = 'ru';
            }else{
                $scope.lg = 'en';
            }
            $location.path( "/Language/"+$scope.lg+'/success');

        }else{
            if ($routeParams.lg == 'en' || $routeParams.lg == 'ru' || $routeParams.lg == 'kz' ){
                $scope.lg = $routeParams.lg;
            }else{
                $scope.lg = 'en';
                $location.path( "/Language/en/success");
            }
        }

        console.log('Language Set to: '+$scope.lg);

        $http.get('./static/partials/'+$scope.lg+'.text.json')
           .then(function(res){
              //console.log(res.data);
              $scope.text = res.data;                
        });


        $scope.newApplication = function() {
    		$cookies.remove('entry');
    		$scope.entry = null;
        	$location.path( "/Language/"+$scope.lg); 
        };


    }]);


appControllers.controller("formController",['$scope', '$http', '$routeParams', '$location', 'Email', 'notificationService', '$cookies', 'formlyVersion', function($scope, $http, $routeParams, $location, Email, notificationService, $cookies, formlyVersion) {
    console.log('Route Parameter Language: '+$routeParams.lg);

    //If no RouteParams are provided, we scrape the hostname for the info we need
    if($routeParams.lg == null){
        if($location.host().indexOf(".org") > -1){
            $scope.lg = 'en';
        }else if($location.host().indexOf(".com") > -1){
            $scope.lg = 'en';
        }else if($location.host().indexOf(".kz") > -1){
            $scope.lg = 'kz';
        }else if($location.host().indexOf(".ru") > -1){
            $scope.lg = 'ru';
        }else{
            $scope.lg = 'en';
        }
        $location.path( "/Language/"+$scope.lg);

    }else{
        if ($routeParams.lg == 'en' || $routeParams.lg == 'ru' || $routeParams.lg == 'kz' ){
            $scope.lg = $routeParams.lg;
        }else{
            $scope.lg = 'en';
            $location.path( "/Language/en");
        }
    }

    console.log('Language Set to: '+$scope.lg);

    // variable assignment
    $scope.model = {};


    $http.get('./static/partials/'+$scope.lg+'.text.json')
       .then(function(res){
            //console.log(res.data);
            $scope.text = res.data;    

            console.log('Checking for cookies');
            console.log($cookies.getAll());

            if($cookies.get('model')){
                console.log('Found saved form model....loading');
                console.log(angular.fromJson($cookies.get('model')));
                $scope.model = angular.fromJson($cookies.get('model'));
                $scope.model.project_start_date = new Date($scope.model.project_start_date);
                $scope.model.project_end_date = new Date($scope.model.project_end_date);        
                notificationService.success($scope.text.form_loaded_saved_form_alert);
            }else{
                console.log('No saved form model Found');           
            }                 
    });

 	$http.get('./static/partials/'+$scope.lg+'.form.json')
       .then(function(res){
       	  //console.log(res.data);
          $scope.formFields = res.data;                
    });



    $scope.submit = function() {
       	$scope.submitted = true;
       	console.log($scope.model);

        if ($scope.aidForm.$valid && typeof $scope.model !== null){
        	console.log('Submitting Form');
            notificationService.info($scope.text.form_submitting);
			Email.save($.param($scope.model),$.param($scope.model), function(data){
            	console.log(data);
   				if(data.error == null || data.error == 'null'){
            		notificationService.success($scope.text.form_email_success_alert);	 
            		 $location.path( "Language/"+$scope.lg+"/success");   					
   				}else{
   					notificationService.success($scope.text.form_email_error_alert);
   				}
            });


        }else{
        	console.log($scope.aidForm.$error);
        	notificationService.error($scope.text.form_submit_error_alert);
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

    	notificationService.success($scope.text.form_saved_alert);
    };


    $scope.clear = function() {
    	console.log('Clearing Form');

		var now = new Date(),
		    // this will set the expiration to 6 months
		    exp = new Date(now.getFullYear(), now.getMonth()+1, now.getDate());

		$cookies.remove('model');

		$scope.model = {};
    	notificationService.info($scope.text.form_cleared_form_alert);
    };


}]);

    