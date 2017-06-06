var app = angular.module('app', ['ngTouch', 'ui.grid', 'ui.grid.edit']);

app.controller('MainCtrl', ['$scope', '$http', function ($scope, $http) {
	$scope.filterOptions = {
	              filterText: ''
	      };

	$scope.gridOptions = {
		enableFiltering : true
	};

	$scope.gridOptions.columnDefs = [
		{ name: 'id', enableCellEdit: false, minWidth:10, width:60, type: 'number'},
		{ name: 'config_name', minWidth:80 },
		{ name: 'partner', displayName: 'partner', width: "*", minWidth:100, resizable:true, enableFiltering: true },
		{ name: 'email', displayName: 'email' , minWidth:230, width: "*" },
		{ name: 'subject', displayName: 'subject' , width: "*" },
		{ name: 'atttype', displayName: 'atttype' , width:80 },
		{ name: 'inv_no_str', displayName: 'inv_no str' , minWidth:130, width: "*" },
		{ name: 'inv_no_col_offset', displayName: 'inv_no col offset' , minWidth:50, width: "*", type: 'number'},
		{ name: 'inv_no_row_offset', displayName: 'inv_no row offset' , minWidth:50, width: "*",type: 'number'},
		{ name: 'inv_date_str', displayName: 'inv_date str' ,minWidth:130, width: "*" },
		{ name: 'inv_date_col_offset', displayName: 'inv_date col offset', minWidth:50 , width: "*", type: 'number' },
		{ name: 'inv_date_row_offset', displayName: 'inv_date row offset', minWidth:50 , width: "*", type: 'number' },
		{ name: 'inv_date_format', displayName: 'inv_date format' , width: "*"  },


		{ name: 'Delete', width:80, cellTemplate: '<button class="btn primary" ng-click="grid.appScope.deleteRow(row)">Delete</button>'
	  }


];

$scope.deleteRow = function(row) {

if(row.entity.id) {

var aha = confirm("you sure?");

if (aha){
	$http.post("../functions/delete_configs_rest.php", {id:row.entity.id}, {headers: {'Content-Type': 'application/json'} })
		        .then(function (response) {
					if (response.data.indexOf("fuck") !== -1 ) {
				alert ('oh shit');
					}
					            return response;
								        });

	}
	else {return;}


}


      var index = $scope.gridOptions.data.indexOf(row.entity);
      $scope.gridOptions.data.splice(index, 1);
	//  alert (row.entity.id);


};


$scope.addNewItem = function() {
	$scope.gridOptions.data.push({config_name: 'Test add ' });
};


$http.get('../functions/return_configs_json.php')
.success(function(data) {
	$scope.gridOptions.data = data;
});



$scope.gridOptions.onRegisterApi = function(gridApi) {
	//		      set gridApi on scope
	$scope.gridApi = gridApi;
	gridApi.edit.on.afterCellEdit($scope, function(rowEntity, colDef, newValue, oldValue) {
	
		if (rowEntity.config_name===undefined || rowEntity.config_name==""
		|| rowEntity.partner===undefined || rowEntity.partner=="")	{
			$http.get('../functions/return_configs_json.php')
				.success(function(data) {
					$scope.gridOptions.data = data;
			})
			return alert ('config and partner must have a name');  }

		//Do your REST call here via $hhtp.get or $http.post
		//This alert just shows which info about the edit is available
	$http.post("../functions/update_configs_rest.php", {id:rowEntity.id, config_name:rowEntity.config_name, partner:rowEntity.partner, email:rowEntity.email}, {headers: {'Content-Type': 'application/json'} })
		        .then(function (response) {
					if (response.data.indexOf("fuck") !== -1 ) {
				alert ('oh shit');
					}
					            return response;
								        });

		alert('Updating Column: ' + colDef.name + ' ID: ' + rowEntity.id + ' Name: ' + rowEntity.config_name + ' Partner: ' + rowEntity.partner);
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

