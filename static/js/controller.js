'use strict';

    var appControllers = angular.module("appControllers", []);



    appControllers.controller("formController",['$scope', '$http', '$routeParams', '$location', 'Form', 'notificationService', function($scope, $http, transformRequestAsFormPost, $location, Form, notificationService) {
        $scope.submit = function() {
            var formData = $scope.entry;
            console.log(formData);

            notificationService.success(formData.name);
            Form.save($.param(formData));
            //$location.path( "/success");
        };
    }]);


    