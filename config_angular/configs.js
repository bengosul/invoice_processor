var app = angular.module('app', ['ngTouch', 'ui.grid', 'ui.grid.edit']);

app.controller('MainCtrl', ['$scope', '$http', function ($scope, $http) {
	$scope.gridOptions = {

	};

	$scope.gridOptions.enableFiltering = true;


	$scope.gridOptions.columnDefs = [
		{ name: 'id', enableCellEdit: false, minWidth:10, width:60},
		{ name: 'config_name' },
		{ name: 'email', displayName: 'email' , type: 'number', minWidth:250, width: "*" },
		{ name: 'partner', displayName: 'partner', width: "*", minWidth:10, resizable:true },
		{ name: 'Delete',  cellTemplate: '<button class="btn primary" ng-click="grid.appScope.deleteRow(row)">Delete</button>'
	  }


];

$scope.deleteRow = function(row) {
var aha = confirm("you sure?");
if (aha){
      var index = $scope.gridOptions.data.indexOf(row.entity);
      $scope.gridOptions.data.splice(index, 1);
	  alert (row.entity.id);
	}
};


$scope.addNewItem = function() {
	$scope.gridOptions.data.push({ });
};


$http.get('../functions/return_configs_json.php')
.success(function(data) {
	$scope.gridOptions.data = data;
});



$scope.gridOptions.onRegisterApi = function(gridApi) {
	//		      set gridApi on scope
	$scope.gridApi = gridApi;
	gridApi.edit.on.afterCellEdit($scope, function(rowEntity, colDef, newValue, oldValue) {
		//Do your REST call here via $hhtp.get or $http.post
		//This alert just shows which info about the edit is available
	$http.post("../functions/update_configs_rest.php", {id:rowEntity.id, config_name:rowEntity.config_name}, {headers: {'Content-Type': 'application/json'} })
		        .then(function (response) {
					if (response.data.indexOf("fuck") !== -1 ) {
				alert ('oh shit');
					}
					            return response;
								        });

		alert('Column: ' + colDef.name + ' ID: ' + rowEntity.id + ' Name: ' + rowEntity.config_name + ' Partner: ' + rowEntity.partner);
//$scope.gridApi.core.refresh()
		
//	$scope.gridApi.core.notifyDataChange( uiGridConstants.dataChange.ALL)  ;

if (!rowEntity.id){
$http.get('../functions/return_configs_json.php')
	.success(function(data) {
		$scope.gridOptions.data = data;
	})
};


	});
};



}])

