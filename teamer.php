<html>

    <head>
    	<!-- Latest compiled and minified CSS -->
    	<!-- <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css'>
     -->
    	<!-- <link rel='stylesheet' href='css/owl.carousel.min.css' />
    <link rel='stylesheet' href='css/owl.theme.default.min.css'> -->
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
    <style type="text/css">

    	.singletable{
    		border-collapse: collapse;
    	}

    </style>
    </head>

    <body>

<?php

$Players = json_decode('[
{"id":1,"rank":5,"name":"AJ"},
{"id":2,"rank":4,"name":"ROHITH"},
{"id":3,"rank":4,"name":"TANZIL"},
{"id":4,"rank":6,"name":"JUDO"},
{"id":5,"rank":5,"name":"ALI"},
{"id":6,"rank":5,"name":"KHATHAL"},
{"id":7,"rank":5,"name":"ARUN"},
{"id":8,"rank":3,"name":"SIJO"},
{"id":9,"rank":5,"name":"NARESH"},
{"id":10,"rank":3,"name":"SHASHANK"},
{"id":11,"rank":4,"name":"ABHILASH"},
{"id":12,"rank":4,"name":"SID"},
{"id":13,"rank":2,"name":"DANESH"},
{"id":14,"rank":4,"name":"SUBODH"},
{"id":15,"rank":2,"name":"SUBBU"},
{"id":16,"rank":3,"name":"UMESH"},
{"id":17,"rank":3,"name":"JAICO"},
{"id":18,"rank":2,"name":"CHIRANJEEVI"},
{"id":19,"rank":3,"name":"RAVI"},
{"id":20,"rank":2,"name":"PRADEEP"}
]');

$Str = "<form action='" . $_SERVER['PHP_SELF'] . "' method='post'><table><tr>";
$k = 0;
foreach ($Players as $Player) {
	if ($k != 0 && $k % 4 == 0) {
		$Str .= "</tr><tr>";
	}
	$Str .= "<td><input type='checkbox' name=play[] value='" . $Player->id . "'>" . $Player->name . "</td>";
	$k++;
}
$Str .= "</tr><tr><td><input type='submit' name='btnsubmit' value='generate'></td></tr></table></form>";

echo $Str;

if (isset($_POST['btnsubmit'])) {

	$Players = MakethePool($Players, $_POST['play']);
	$Arr = array(array(), array());
	$Strength = array();
	$Swifter = 0;
	$CurrentRank = 6;
	echo "<pre>";
	usort($Players, "cmp");
	//print_r($Players);

	foreach ($Players as $Player) {
		$Index = $Swifter % 2;
		$Strength[$Index] += $Player->rank;
		array_push($Arr[$Index], $Player);

		$Swifter++;
	}

	printTeam($Arr, "Random Pick");

	if (count($Players) % 2 == 1) {
		echo "Hit";
		array_push($Arr[1], $Arr[0][count($Arr[0]) - 1]);
		unset($Arr[0][count($Arr[0]) - 1]);
	}

	printTeam($Arr, "Adjusting");

	optimize($Arr[0], $Arr[1], $Strength[0], $Strength[1]);
	printTeam($Arr, "Optimized");
	//print_r($Arr);
}

function optimize($TeamA, $TeamB, $StrA, $StrB) {

	$StrDiff = abs($StrA - $StrB);
	$PickA = $PickB = -1;
	if ($StrDiff <= 1) {
		$Array = array($TeamA, $TeamB);
		$Strength = StrengthCalculator($TeamA, $TeamB);
		return $Array;
	}
	if ($StrDiff > 0) {
		for ($i = 0; $i < count($TeamB); $i++) {
			if ($TeamB[$i]->rank == ($StrDiff + 1)) {
				$PickB = $i;
				break;
			}
		}
		for ($i = 0; $i < count($TeamA); $i++) {
			if ($TeamA[$i]->rank == ($StrDiff + 2)) {
				$PickA = $i;
				break;
			}
		}

		if ($PickA >= 0 && $PickB >= 0) {
			echo $TeamB[$PickB]->name . " = " . $TeamA[$PickA]->name . "<br>";
			$X = $TeamA[$PickA];
			$TeamA[$PickA] = $TeamB[$PickB];
			$TeamB[$PickB] = $X;
		}
	} else {
		for ($i = 0; $i < count($TeamB); $i++) {
			if ($TeamB[$i]->rank == ($StrDiff + 2)) {
				$PickB = $i;
				break;
			}
		}
		for ($i = 0; $i < count($TeamA); $i++) {
			if ($TeamA[$i]->rank == ($StrDiff + 1)) {
				$PickA = $i;
				break;
			}
		}

		if ($PickA >= 0 && $PickB >= 0) {
			echo $TeamB[$PickB]->name . " = " . $TeamA[$PickA]->name . "<br>";
			$X = $TeamB[$PickB];
			$TeamB[$PickB] = $TeamA[$PickA];
			$TeamA[$PickA] = $X;
		}
	}
	$Array = array($TeamA, $TeamB);
	//printTeam($Array, "OPTIMIZING");
	optimize($TeamA, $TeamB, $Strength[0], $Strength[1]);
	return $Array;

}
function StrengthCalculator($TeamA, $TeamB) {
	$StrenghtA = $StrenghtB = 0;
	foreach ($TeamA as $player) {
		$StrenghtA += $player->rank;
	}
	foreach ($TeamB as $player) {
		$StrenghtB += $player->rank;
	}
	return array($StrenghtA, $StrenghtB);
}
function MakethePool($Players, $present) {
	$PresentPlayer = array();
	foreach ($present as $presented) {
		foreach ($Players as $Player) {

			if ($Player->id == $presented) {
				array_push($PresentPlayer, $Player);
			}
		}
	}

	return $PresentPlayer;
}
function printTeam($Arr, $Title = "") {

	$Strength = StrengthCalculator($Arr[0], $Arr[1]);
	$Str1 = $Str2 = "<div class='row' class='singletable'><div class='col-xs-6'>";
	foreach ($Arr[0] as $SelectedPlayer) {
		$Str1 .= " <div class='row'><div class='col-xs-12'>" . $SelectedPlayer->name . "</div></div>";
	}
	$Str1 .= "<div class='row'><div class='col-xs-12'>" . $Strength[0] . "</div></div></div>";
	foreach ($Arr[1] as $SelectedPlayer) {
		$Str2 .= " <div class='row'><div class='col-xs-12'>" . $SelectedPlayer->name . "</div></div>";
		//$Str2 .= "<tr><td>" . $SelectedPlayer->name . "[" . $SelectedPlayer->rank . "]" . "</td></tr>";
	}
	$Str2 .= "<div class='row'><div class='col-xs-12'>" . $Strength[1] . "</div></div></div>";

	/*$Str = "<table border=1>
			<tr><th colspan=2>" . $Title . "</th></tr>
			<tr>
				<td>" . $Str1 . "</td>
		  		<td>" . $Str2 . "</td>
		  	</tr>
		  	</table>";
*/
	$StrTables = "<div class='container'>
    <div class='row'>
        <div class='col-xs-6'>" . $Str1 . "</div>
        <div class='col-xs-6'>" . $Str2 . "</div>
    </div>
</div>";
	echo $StrTables;

	echo $Str;
}
function cmp($a, $b) {
	if ($a->rank == $b->rank) {
		return 0;
	}
	return ($a->rank > $b->rank) ? -1 : 1;
}
?>

</body>
</html>