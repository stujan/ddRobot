/**
 * Tracker application init
 */
var trackerApp = angular.module('trackerApp', ['ngMaterial', 'ngMessages']);

/**
 * Config date
 */
trackerApp.config(function($mdDateLocaleProvider,$httpProvider) {
    // change week display to start on Monday.
    $mdDateLocaleProvider.firstDayOfWeek = 1;
  
    $mdDateLocaleProvider.formatDate = function(date) {
        return moment(date).format('YYYY.MM.DD hh:mm');
    };

    $mdDateLocaleProvider.parseDate = function(dateString) {
        var m = moment(dateString, 'YYYY.MM.DD hh:mm', true);
        return m.isValid() ? m.toDate() : new Date(NaN);
    };
   $httpProvider.defaults.transformRequest = function(obj){
       var str = [];
       for(var p in obj){
         str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
       }
       return str.join("&");
     }

     $httpProvider.defaults.headers.post = {
          'Content-Type': 'application/x-www-form-urlencoded'
     }
});

/**
 * Main Controller
 */
trackerApp.controller('trackerAdminCtrl', ['$scope','$http',function($scope,$http) {
  $scope.trackList = [
  ];
      $http({
        method: 'GET',

        url: '../src/getData.php'
    }).then(function successCallback(response) {
        for(i in  response.data){
          var item = {
              id : response.data[i].id,
              url : response.data[i].url,
              addDate : response.data[i].addDate,
              name : response.data[i].name,
              type : response.data[i].type, 
              belong : response.data[i].belong,
              statuses : []
          }
          for(j in response.data[i].statuses){
            var date = response.data[i].statuses[j].pattern.split(" ");
            var sitem = {
              id : response.data[i].statuses[j].id,
              addDate : response.data[i].statuses[j].addDate,
              message : response.data[i].statuses[j].message,
              type : response.data[i].statuses[j].type,
              pattern : response.data[i].statuses[j].pattern,
              mm : date[0],
              hh : date[1],
              dd : date[2],
              MM : date[3],
              weak : date[4]
            }
            item["statuses"].push(sitem);
          }
          $scope.trackList.push(item);
        }

    }, function errorCallback(response) {
        // 请求失败执行代码
    });
  $scope.searchText = '';
  $scope.searchUrl = '';
  $scope.searchAddDate = '';
  $scope.searchName = '';
  $scope.searchType = '';
  $scope.searchbelong = '';
  $scope.newTrack = {};
  $scope.editTrack = {};
  $scope.editStatus = {};
  $scope.newStatus = {};
  $scope.orderByFilter = '-addDate';
  $scope.orderByClass = 'glyphicon glyphicon-menu-down';
  $scope.startEditTrack = function(trackId) {
    var trackIndex = getTrackIndexById(trackId);
    if( trackIndex !== false ) {
      $scope.editTrack = angular.copy($scope.trackList[trackIndex]);
    } else {
      console.error('Track editing error.');
    }
  }
  
  $scope.saveTrack = function(trackId) {


    var trackIndex = getTrackIndexById(trackId);
    if( trackIndex !== false ) {
      $http({
        url: '../src/updateRb.php',
        method: 'POST',
        data:{
          id : trackId ,
          url : $scope.editTrack.url ,
          name :$scope.editTrack.name ,
          type : $scope.editTrack.type ,
          belong : $scope.editTrack.belong
        },
        headers:{'Content-Type': 'application/x-www-form-urlencoded'},
        transformRequest: function(obj) {
        var str = [];
        for(var p in obj){
          str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
        }
        return str.join("&");
      }
      }).then(function successCallback(response){
          $scope.trackList[trackIndex] = angular.copy($scope.editTrack);

      },function errorCallback(response){
          alert("修改失败");
      });
    } else {
      console.error('Track saving error.');
    }
  }
  
  $scope.addTrack = function() {
    $http({
      url: '../src/insertRb.php',
      method: 'POST',
      data:{
        rurl : $scope.newTrack.url ,
        rname : $scope.newTrack.name ,
        rtype : $scope.newTrack.type ,
        rbelong : $scope.newTrack.belong
      },
      headers:{'Content-Type': 'application/x-www-form-urlencoded'},
      transformRequest: function(obj) {
      var str = [];
      for(var p in obj){
        str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
      }
      return str.join("&");
    }
    }).then(function successCallback(response){
        $scope.newTrack.id = response.data;
        $scope.newTrack.addDate = new Date();
        $scope.newTrack.statuses = [];
        $scope.trackList.push($scope.newTrack);
        $scope.newTrack = {};
        console.log(response);
    },function errorCallback(response){
        alert("添加失败");
    });
  }
  
  $scope.changeOrderby = function(name) {
    if($scope.orderByFilter === name) {
      $scope.orderByFilter = '-' + name;
      $scope.orderByClass = 'glyphicon glyphicon-menu-down';
    } else if($scope.orderByFilter === '-' + name) {
      $scope.orderByFilter = name;
      $scope.orderByClass = 'glyphicon glyphicon-menu-up'
    } else {
      $scope.orderByFilter = '-' + name;
      $scope.orderByClass = 'glyphicon glyphicon-menu-down'
    }
  }
  
  $scope.isOrderByIconShow = function(name) {
    if($scope.orderByFilter === name || $scope.orderByFilter === '-' + name) {
      return true;
    }
    return false;
  }
  
  $scope.deleteTrack = function(trackId) {
    var trackIndex = getTrackIndexById(trackId);

    if( trackIndex !== false ) {
      $http({
        url: '../src/deleteRb.php',
        method: 'POST',
        data:{
          id : trackId
        },
        headers:{'Content-Type': 'application/x-www-form-urlencoded'},
        transformRequest: function(obj) {
        var str = [];
        for(var p in obj){
          str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
        }
        return str.join("&");
      }
      }).then(function successCallback(response){
        $scope.trackList.splice(trackIndex, 1);

      },function errorCallback(response){
          alert("失败");
      });


    } else {
      console.error('Track deleting error.');
    }

  }
  
  $scope.saveStatus = function(trackId, statusId) {
    var trackIndex = getTrackIndexById(trackId);
    var statusIndex = getTrackStatusIndexById(trackId, statusId);
    $scope.editStatus.pattern = $scope.editStatus.mm + " " + $scope.editStatus.hh + " " + $scope.editStatus.dd + " " + $scope.editStatus.MM + " " + $scope.editStatus.weak;

    if( trackIndex !== false && statusIndex !== false ) {
      $http({
        url: '../src/updateMs.php',
        method: 'POST',
        data:{
          id : statusId ,
          mmsg : $scope.editStatus.message ,
          mtype :$scope.editStatus.type ,
          mpattern : $scope.editStatus.pattern
        },
        headers:{'Content-Type': 'application/x-www-form-urlencoded'},
        transformRequest: function(obj) {
        var str = [];
        for(var p in obj){
          str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
        }
        return str.join("&");
      }
      }).then(function successCallback(response){
        $scope.trackList[trackIndex].statuses[statusIndex] = angular.copy($scope.editStatus);


      },function errorCallback(response){
          alert("修改失败");
      });




    } else {
      console.error('Status saving error.');
    }
  }
  



  $scope.startEditStatus = function(trackId, statusId) {
    var trackIndex = getTrackIndexById(trackId);
    var statusIndex = getTrackStatusIndexById(trackId, statusId);
    if( trackIndex !== false && statusIndex !== false ) {
      $scope.editStatus = angular.copy($scope.trackList[trackIndex].statuses[statusIndex]);
    } else {
      console.error('Status editing error.');
    }
  }
  
  $scope.deleteStatus = function(trackId, statusId) {
    var trackIndex = getTrackIndexById(trackId);
    var statusIndex = getTrackStatusIndexById(trackId, statusId);
    if( trackIndex !== false && statusIndex !== false ) {
      $http({
        url: '../src/deleteMs.php',
        method: 'POST',
        data:{
          id : statusId
        },
        headers:{'Content-Type': 'application/x-www-form-urlencoded'},
        transformRequest: function(obj) {
        var str = [];
        for(var p in obj){
          str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
        }
        return str.join("&");
      }
      }).then(function successCallback(response){
        $scope.trackList[trackIndex].statuses.splice(statusIndex, 1);
      },function errorCallback(response){
          alert("失败");
      });
      
    } else {
      console.error('Status deleting error.');
    }
  }
  
  $scope.addStatus = function(trackId) {
    var trackIndex = null;
    $scope.trackList.forEach(function(value, index) {
      if(value.id == trackId) {
        trackIndex = index;
      }
    });
    $scope.newStatus.pattern = $scope.newStatus.mm + " " + $scope.newStatus.hh + " " + $scope.newStatus.dd + " " + $scope.newStatus.MM + " " + $scope.newStatus.weak;
    $http({
      url: '../src/insertMs.php',
      method: 'POST',
      data:{
        mmsg : $scope.newStatus.message ,
        rid : trackId ,
        mtype : $scope.newStatus.type ,
        mpattern : $scope.newStatus.pattern
      },
      headers:{'Content-Type': 'application/x-www-form-urlencoded'},
      transformRequest: function(obj) {
      var str = [];
      for(var p in obj){
        str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
      }
      return str.join("&");
    }
    }).then(function successCallback(response){
        $scope.newStatus.pattern = $scope.newStatus.mm + " " + $scope.newStatus.hh + " " + $scope.newStatus.dd + " " + $scope.newStatus.MM + " " + $scope.newStatus.weak;

        $scope.trackList[trackIndex].statuses.push(
          {
              id : response.data,
              addDate : new Date(),
              message : $scope.newStatus.message, 
              type : $scope.newStatus.type,
              pattern : $scope.newStatus.pattern,
              mm : $scope.newStatus.mm,
              hh : $scope.newStatus.hh,
              dd : $scope.newStatus.dd,
              MM : $scope.newStatus.MM,
              weak : $scope.newStatus.weak
          }
        );
        $scope.newStatus.message = '';
        console.log($scope.trackList[trackIndex].statuses);
    },function errorCallback(response){
        alert("添加失败");
    });

  }
  

  function getTrackIndexById(trackId) {
    var outIndex = false;
    $scope.trackList.forEach(function(value, i) {
      if(value.id == trackId) {
        outIndex = i;
      }
    });
    return outIndex;
  }
  
  function getTrackStatusIndexById(trackId, statusId) {
    var trackIndex = getTrackIndexById(trackId);
    if( trackIndex === false ) return false;
    var outIndex = false;
    $scope.trackList[trackIndex].statuses.forEach(function(value, i) {
      if(value.id == statusId) {
        outIndex = i;
      }
    });
    return outIndex;
  }
}]);

// console.log(angular.element(document.getElementById("ctrl")).scope().$$childHead.trackList);


jQuery(document).ready(function($) {
  /* Bootstrap datepicker config */
  $('.bootstrap-datepicker').datepicker({});
});
