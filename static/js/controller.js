'use strict';

    var appControllers = angular.module("appControllers", []);



    appControllers.controller("formController",['$scope', '$http', '$routeParams', '$location', function($scope, $http, transformRequestAsFormPost, $location) {
        $scope.submit = function() {
            var data = $scope.user;
            $location.path( "/success");
        };
    }]);


    