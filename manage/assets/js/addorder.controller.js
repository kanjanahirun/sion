var app = angular.module("sion", []);

app.filter('range', function () {
    return function (input, total) {
        total = parseInt(total);
        for (var i = 0; i < total; i++)
            input.push(i);
        return input;
    };
});

app.directive('onlyDigits', function () {
    return {
        restrict: 'A',
        require: '?ngModel',
        link: function (scope, element, attrs, ngModel) {
            if (!ngModel)
                return;
            ngModel.$parsers.unshift(function (inputValue) {
                var digits = inputValue.split('').filter(function (s) {
                    return (!isNaN(s) && s != ' ');
                }).join('');
                ngModel.$viewValue = digits;
                ngModel.$render();
                return digits;
            });
        }
    };
});

app.factory("numrows", function () {
    var numrows = {};
    numrows = [{
        index: 0
    }];
    return numrows;
});

app.controller("addorderController", function ($scope) {

    $scope.orders = [];
//    $scope.numrows = numrows;
    $scope.index = [];
    $scope.numrows = 1;
    $scope.numorders = "";
    $scope.ID_Product = [];
    $scope.Amount_Product = [];
    $scope.Cost_Price = [];
    $scope.Cost_Price_Product = [];
    $scope.Total_Price = [];
    $scope.ID_Count = [];
    $scope.end = 1000;

//    $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";


    $scope.selectCompany = function (ID_Company) {
        var json = {'ID_Company': ID_Company};
        $.post("../admin/addorder.controller.php", json).done(function (response) {
            var data = JSON.parse(response);
            $scope.$apply(function () {
                $scope.product = data;
            });
        });
    };


    // add orders
    $scope.load = function () {
        var json = {'getlastodetail': "getPK"};
        $.post("../admin/addorder.controller.php", json).done(function (response) {
            var data = JSON.parse(response);
            console.log(data);
            $scope.$apply(function () {
                $scope.ID_Orderdetail = data.ID_Orderdetail;
            });
        });
    };
    $scope.load();

    $scope.init = function (value) {
        return value;
    };
    
    $scope.input = [];
    $scope.range = function(min, max){
        $scope.input = [];
        for (var i = min; i <= max; i++) $scope.input.push(i);
        return $scope.input;
    };

    $scope.searchMax = function(index){
        var max = index[0];
        for(var i = 0; i < index.length; i++){
            if(index[i] != ""){
                if(max < index[i]){
                    max = index[0];
                }
            }
        }
        return max;
    };

    $scope.numRows = function (numorders, option) {
        var i = 0;
        if (option == 1) {
//            for (i = 0; i < parseInt(numorders); i++) {
//                numrows[i] = {index: i};
//            }
            $scope.numrows = parseInt(numorders);
        }
        else if (option == 2) {
//            numrows.push({index: parseInt(numorders) + 1});
            $scope.end = $scope.searchMax($scope.index) + 1; 
            $scope.numrows = parseInt($scope.numrows) + 1;
//            $scope.index[$scope.numrows-1] = end;
        }
    };

    $scope.searchStart = function(index){
        var start = 1;
        for(var i = $scope.index.length-1; i > 0 ; i--){
            if(i < index){
                if($scope.index[i] != ""){
                    start = $scope.index[i];
                    console.log("start",i,$scope.index[i]);
                    break;
                }
            }
        }
        return start;
    };

    $scope.searchEnd = function(index){
        var end = 0;
        for(var j = $scope.index[index]-1; j < $scope.index.length; j++){
            if(j > index){
                if($scope.index[j] != ""){
                    end = $scope.index[j];
                    console.log("end",j,$scope.index[j]);
                    break;
                }
            }
        }
        return end;
    };
    
    $scope.changeIndex = function(start){
        var id = start;
        for(var c = start; c < $scope.index.length; c++){
            console.log(c);
            if(c != $scope.index[start]){
                if($scope.index[c] != ""){
                    id++;
                    $scope.index[c] = id;
                }
            }
        }
    };
    
    $scope.deleteRow = function (index,num) { 
//        $scope.numrows.splice(index, 1);
//        numrows.splice(index, 1);
        
        $("#ng" + index).remove();
        
        // remove value in array
        $scope.index[index] = ""; 
        $scope.input[index] = -1;
        $scope.end = -1;
        // search index 
        var start = $scope.searchStart(index);
        var end = $scope.searchEnd(index);
        
        // change index
        $scope.changeIndex(start);
        
        
//        $scope.numrows = $scope.numrows - parseInt(num);
//        for(var i = 0; i < $scope.numrows.length; i++){
//            if (index == i) {
//                $scope.numrows.splice(index, 1);
//                console.log($scope.numrows, index);
//                break; 
//            }
//        } 
       
    };


    $scope.selectProduct = function (index) {
        var ID_Product = $scope.ID_Product[index];
        console.log(ID_Product);
        if (ID_Product != undefined && ID_Product != "") {
            var json = {'productId': ID_Product};
            console.log(json)
            $.post("../admin/addorder.controller.php", json).done(function (data) {
                var product = JSON.parse(data);
                console.log(product);
                $scope.$apply(function () {
                    $scope.Cost_Price[index] = product.Cost_Price;
                    $scope.Cost_Price_Product[index] = product.Cost_Price;
                });
            });
        } else {
            $scope.Cost_Price[index] = 0;
            $scope.Amount_Product[index] = 0;
            $scope.Total_Price[index] = 0;
        }
    };

    $scope.pressAmount = function (Amount_Product, index) {
        var productId = $scope.ID_Product[index];
        var amount = parseFloat(Amount_Product[index]);
        console.log(Amount_Product[index]);
        amount = isNaN(amount) ? 0 : amount;
        console.log(amount);
        var cost = parseFloat($scope.Cost_Price[index]);
        cost = isNaN(cost) ? 0 : cost;
        console.log(amount, cost);

        if (cost != undefined && productId != "" && productId != undefined) {
            var total_price = cost * amount;
            console.log(total_price);
            $scope.Total_Price[index] = total_price;
        }

        if (productId == "" || productId == undefined) {
            $scope.Amount_Product[index] = "";
            alert("กรุณาเลือกสินค้าก่อน");
        }
    };

    $scope.selectCount = function (index) {
        var cost = parseFloat($scope.Cost_Price_Product[index]);
        cost = isNaN(cost) ? 0 : cost;
        var amount = parseFloat($scope.Amount_Product[index]);
        amount = isNaN(amount) ? 0 : amount;

        //console.log(cost, amount);

        if (cost > 0 && amount > 0) {
            var ID_Count = $scope.ID_Count[index];
            if (ID_Count != "" && ID_Count != undefined) {
                var json = {'ID_Count': ID_Count};
                $.post("../admin/addorder.controller.php", json).done(function (data) {
                    var unitCount = JSON.parse(data);
                    //console.log(unitCount);
                    var anmountUnit = parseFloat(unitCount.Amount_Unit);
                    var total_price = cost * anmountUnit * amount;
                    $scope.$apply(function () {
                        $scope.Cost_Price[index] = (cost * anmountUnit);
                        $scope.Total_Price[index] = total_price;
                    });
                });
            } else {
                alert("กรุณาเลือกหน่วยนับ");
            }
        } else if ($scope.ID_Product[index] == "" || $scope.ID_Product[index] == undefined) {
            $scope.ID_Count[index] = "";
            alert("กรุณาเลือกสินค้าก่อน");
        } else {
            $scope.ID_Count[index] = "";
            alert("กรุณากรอกจำนวนสินค้าก่อน");
        }
    };


    $scope.generateIDbyFix = function (OldId, VarLength, str, index) {
        var NewId2 = "";
        try {
            var ID_Var = OldId != "" ? OldId.substr(0, VarLength) : str;
            var ID_num = OldId != "" ? OldId.substr(VarLength) : "0";
            var NewNum2 = "";
            for (var i = 0; i < ID_num.length; i++) {
                if (ID_num.substr(i, VarLength) != "0") {
                    NewNum2 = ID_num.substr(i);
                    break;
                }
            }
            //if (ID_num = "0") NewNum2 = ID_num;

            NewId2 = (ID_Var.indexOf(str) != -1) ? ID_Var : str;
            NewNum2 = isNaN(NewNum2) ? 0 : parseInt(NewNum2);
            if (NewNum2 < 9) {
                NewId2 += "00" + (NewNum2 + 1 + index);
            } else if (NewNum2 < 99) {
                NewId2 += "0" + (NewNum2 + 1 + index);
            } else if (NewNum2 <= 999) {
                NewId2 += (NewNum2 + 1 + index);
            } else if (NewNum2 <= 9999) {
                NewId2 += (NewNum2 + 1 + index);
            } else if (NewNum2 <= 99999) {
                NewId2 += (NewNum2 + 1 + index);
            } else if (NewNum2 <= 999999) {
                NewId2 += (NewNum2 + 1 + index);
            } else if (NewNum2 <= 9999999) {
                NewId2 += (NewNum2 + 1 + index);
            } else if (NewNum2 <= 99999999) {
                NewId2 += (NewNum2 + 1 + index);
            } else if (NewNum2 <= 999999999) {
                NewId2 += (NewNum2 + 1 + index);
            } else if (NewNum2 <= 9999999999) {
                NewId2 += (NewNum2 + 1 + index);
            } else if (NewNum2 <= 99999999999) {
                NewId2 += (NewNum2 + 1 + index);
            } else if (NewNum2 <= 999999999999) {
                NewId2 += (NewNum2 + 1 + index);
            } else if (NewNum2 <= 9999999999999) {
                NewId2 += (NewNum2 + 1 + index);
            } else if (NewNum2 <= 99999999999999) {
                NewId2 += (NewNum2 + 1 + index);
            } else if (NewNum2 <= 999999999999999) {
                NewId2 += (NewNum2 + 1 + index);
            } else if (NewNum2 <= 9999999999999999) {
                NewId2 += (NewNum2 + 1 + index);
            } else if (NewNum2 <= 99999999999999999) {
                NewId2 += (NewNum2 + 1 + index);
            } else if (NewNum2 <= 999999999999999999) {
                NewId2 += (NewNum2 + 1 + index);
            } else if (NewNum2 <= 9999999999999999999) {
                NewId2 += (NewNum2 + 1 + index);
            } else if (NewNum2 <= 99999999999999999999) {
                NewId2 += (NewNum2 + 1 + index);
            }
        } catch (e) {

        }
        return NewId2;
    };

});