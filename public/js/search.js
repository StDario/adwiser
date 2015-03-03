var app = angular.module('search', [], function($interpolateProvider){
  $interpolateProvider.startSymbol('{');
    $interpolateProvider.endSymbol('}');
});

app.controller('SearchController', function($scope){
	

	$scope.categories = {};

	empty = function(){
		//$scope.$apply(function(){
			$scope.categories = {};
		//});
	}

	add = function(cat, val){
		//$scope.$apply(function(){
			$scope.categories[val.title] = { cat: cat, id: val.id };
		//});
	}


		$.ui.autocomplete.prototype._renderItem = function(ul, item) {

			
			if(item.label[0] == '#'){
				return $("<li></li>")
		   		.data("item.autocomplete", item)
		   		.append('<a>' + item.label + '</a>')
		   		.appendTo( ul );
			}
			//if(item.label[0] != '#'){
			obj = $scope.categories[item.label];
		
			url = obj.cat;
			if(url == "q"){
				url = "/questions/" + obj.id;
			}
			else if(url == "r"){
				url = "/reviews/" + obj.id;
			}
			else {
				url = "/search-tags/" + obj.id;
				item.label = "#" + item.label;
		 	} 
		  return $("<li></li>")
		    .data("item.autocomplete", item)
		    .append('<a href="' + url + '">' + item.label + '</a>')
		    .appendTo( ul );
		//}
		
	};
});




app.directive('autoComplete', function($http) {
	
    return {
        restrict: 'A',
        link: function(scope, elem, attr, ctrl) {
                    // elem is a jquery lite object if jquery is not present,
                    // but with jquery and jquery ui, it will be a full jquery object.
            elem.autocomplete({
                //source: searchDataService.getSource(), //from your service
                source:  function (request, response) {
               	 var url = "../search/" + request.term;
               	 $http.get(url).success( function(data) {

               	 		ret = [];
               	 		empty();
               	 		data.forEach(function(entry){
							add(entry.category, entry.value);
							ret.push(entry.value.title);
						});
           				response(ret);
                	});
            	},
            	select: function(event, ui){
            	},
                minLength: 2,
            });
        }
    };
});




