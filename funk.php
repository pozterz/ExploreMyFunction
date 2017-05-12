<?php
$dir    = 'Controllers';

function listFolderFiles($dir){
    $ffs = scandir($dir);
    echo '<ul>';
    foreach($ffs as $ff){
        if($ff != '.' && $ff != '..'){
            echo '<li><h4 class="title is-4" ng-model='.$ff.' ng-click='.$ff.'=!'.$ff.'>'.$ff.'</h4>';
            if(!is_dir($dir.'/'.$ff)) echo getFunction($dir.'/'.$ff,$ff);
            if(is_dir($dir.'/'.$ff)) listFolderFiles($dir.'/'.$ff);
            echo '</li>';
        }
    }
    echo '</ul>';
}

function getFunction($path,$file){
	$fileContents = file_get_contents($path);

	$regex = '~
	  function                 #function keyword
	  \s+                      #any number of whitespaces 
	  (?P<function_name>.*?)   #function name itself
	  \s*                      #optional white spaces
	  (?P<parameters>\(.*?\))  #function parameters
	  \s*                      #optional white spaces
	  (?P<body>\{.*?\})        #body of a function
	~six';

	if (preg_match_all($regex, $fileContents, $matches)) {
		echo "<div class='box' ng-show='".$file."'>";
	  foreach ($matches[0] as $key => $value) {
	  	echo "<br/><pre><code>".$value."</pre></code><br/>";
	  }
	  echo "<div/>";
	}
}


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="public/bulma.min.css">
	<script src="public/angular.min.js" type="text/javascript" charset="utf-8" async defer></script>
	<style type="text/css" media="screen">
		div {
    	white-space:pre-line;
		}
	</style>	
</head>
<body>
<div class="container" ng-app="App" ng-controller="AppCtrl">
	<div class="content">
	<?php listFolderFiles($dir); ?>
	</div>
</div>
<script>
	(function(){

		angular
			.module('App',[])
			.controller('AppCtrl', function($scope) {
			    
			})

	})();
</script>
</body>
</html>