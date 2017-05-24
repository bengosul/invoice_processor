var app = angular.module('app', ['ngAnimate', 'ngTouch', 'ui.grid', 'ui.grid.selection', 'ui.grid.edit','ui.grid.cellNav']);

// app.controller('MainCtrl', ['$scope', function ($scope) {
//	   $scope.data = [
//	     { name: 'Bob', title: 'CEO' },
//	     { name: 'Frank', title: 'Lowly Developer' }
//   ];
app.controller('MainCtrl', ['$scope', '$http',
	  function($scope, $http) {
		      $scope.gridOptions = {};

			      $scope.gridOptions.columnDefs = [{
					        name: 'id',
	      enableCellEdit: false
	    }, {
			      name: 'name'
	    }, {
			      name: 'age',
	      displayName: 'Age',
	      type: 'number',
	      width: '10%'
	    }];


    $http.get('https://cdn.rawgit.com/angular-ui/ui-grid.info/gh-pages/data/500_complex.json')
	      .success(function(data) {
			          $scope.gridOptions.data = data;
					        });

    $scope.gridOptions.onRegisterApi = function(gridApi) {
		      //set gridApi on scope
			        $scope.gridApi = gridApi;
			              gridApi.edit.on.afterCellEdit($scope, function(rowEntity, colDef, newValue, oldValue) {
			                      //Do your REST call here via $hhtp.get or $http.post
			                              //This alert just shows which info about the edit is available
			                                      alert('Column: ' + colDef.name + ' ID: ' + rowEntity.id + ' Name: ' + rowEntity.name + ' Age: ' + rowEntity.age)
			                                            });
			                                                };
//	$scope.columnDefs = [
//	     {name: 'name', cellEditableCondition:true},
//	     {name: 'title', cellEditableCondition:true}
//   ];
      
       $scope.addNewItem=function()
	    {
			      $scope.data.push( { name: 'Test add ', title: 'Test add' });
				      };
    
    $scope.insertNewItem=function()
	    {
			      $scope.data.splice(1, 0,  { name: 'Test insert ', title: 'Test insert' });
				      };
   
	   
	 }]);

