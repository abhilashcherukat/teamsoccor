<html>

    <head>
    	<!-- Latest compiled and minified CSS -->
    	<!-- <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css'>
     -->
    	<!-- <link rel='stylesheet' href='css/owl.carousel.min.css' />
    <link rel='stylesheet' href='css/owl.theme.default.min.css'> -->
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
    <style type="text/css">


    </style>
    </head>
    <body>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$fp = fopen('player.json', 'r') or die("Unable to open file!");
$filecontent = fread($fp, filesize('player.json'));
fclose($fp);
$arr_player_pool = json_decode($filecontent);

$Str = "<form action='" . $_SERVER['PHP_SELF'] . "' method='post'><table><tr>";
$k = 0;
foreach ($arr_player_pool as $players) {
	if ($k != 0 && $k % 4 == 0) {
		$Str .= "</tr><tr>";
	}
	$Str .= "<td><input type='checkbox' name=play[] value='" . $players->id . "'>" . $players->name . "</td>";
	$k++;
}
$Str .= "</tr><tr><td><input type='submit' name='btnsubmit' value='Generate'></td></tr></table></form>";

echo $Str;

if (isset($_POST['btnsubmit'])) {

	$arr_selected_players = MakethePool($arr_player_pool, $_POST['play']);
	if (count($arr_selected_players) < 6) {
		echo "Not enough player, You can play <b>snake and ladder</b> instead";die();
	}
	$arr_selected_teams = array(array(), array());
	$arr_selected_team_strength = array(0, 0);
	$shifter = 0;

	usort($arr_selected_players, "cmp");

	foreach ($arr_selected_players as $selected_player) {
		$index = $shifter % 2;
		$arr_selected_team_strength[$index] += $selected_player->rank;
		array_push($arr_selected_teams[$index], $selected_player);

		$shifter++;
	}

	print_team($arr_selected_teams, "Random selection");

	if (count($arr_selected_players) % 2 == 1) {
		array_push($arr_selected_teams[1], $arr_selected_teams[0][count($arr_selected_teams[0]) - 1]);
		unset($arr_selected_teams[0][count($arr_selected_teams[0]) - 1]);
		print_team($arr_selected_teams, "Adjusting");
	}

	$arr_selected_team_strength = StrengthCalculator($arr_selected_teams);
	//CHECKING IF ADJUSTING THE PLAYER MADE THE TEAM OPTIMIZED
	if (($arr_selected_team_strength[0] - $arr_selected_team_strength[1]) <= 1) {
		print_team($arr_selected_teams, "Optimized");
	} else {

		$arr_selected_teams = optimize($arr_selected_teams, 0);
		print_team($arr_selected_teams, "Optimized");
	}
}

function optimize($arr_selected_teams, $cnt) {

	$arr_team_strengths = StrengthCalculator($arr_selected_teams);
	if ($arr_team_strengths[0] == $arr_team_strengths[1]) {
		return $arr_selected_teams;
	}
	$strength_team_A = $arr_team_strengths[0];
	$strength_team_B = $arr_team_strengths[1];

	$arr_team_A = $arr_selected_teams[0];
	$arr_team_B = $arr_selected_teams[1];

	$strength_difference = abs($strength_team_A - $strength_team_B);

	$player_picker_A = $player_picker_B = -1;

	if ($strength_difference <= 1) {
		$Array = array($arr_team_A, $arr_team_B);
		return $Array;
	}
	if ($strength_difference > 0) {
		for ($i = 0; $i < count($arr_team_B); $i++) {
			if ($arr_team_B[$i]->rank == ($strength_difference + 1)) {
				$player_picker_B = $i;
				break;
			}
		}
		for ($i = 0; $i < count($arr_team_A); $i++) {
			if ($arr_team_A[$i]->rank == ($strength_difference + 2)) {
				$player_picker_A = $i;
				break;
			}
		}

		if ($player_picker_A >= 0 && $player_picker_B >= 0) {

			$X = $arr_team_A[$player_picker_A];
			$arr_team_A[$player_picker_A] = $arr_team_B[$player_picker_B];
			$arr_team_B[$player_picker_B] = $X;
		}
	} else {
		for ($i = 0; $i < count($arr_team_B); $i++) {
			if ($arr_team_B[$i]->rank == ($strength_difference + 2)) {
				$player_picker_B = $i;
				break;
			}
		}
		for ($i = 0; $i < count($arr_team_A); $i++) {
			if ($arr_team_A[$i]->rank == ($strength_difference + 1)) {
				$player_picker_A = $i;
				break;
			}
		}

		if ($player_picker_A >= 0 && $player_picker_B >= 0) {
			echo $arr_team_B[$player_picker_B]->name . " = " . $arr_team_A[$player_picker_A]->name . "<br>";
			$X = $arr_team_B[$player_picker_B];
			$arr_team_B[$player_picker_B] = $arr_team_A[$player_picker_A];
			$arr_team_A[$player_picker_A] = $X;
		}
	}
	$Array = array($arr_team_A, $arr_team_B);
	//print_team($Array, "OPTIMIZING");
	print_team($Array, "Optimizing " . $cnt);
	$curr_team_strength = StrengthCalculator($Array);
	if ($cnt >= 3 or ($arr_team_strengths[0] = $curr_team_strength[0] && $arr_team_strengths[1] = $curr_team_strength[1])) {
		//var_dump(array_intersect($Array, $arr_selected_teams));
		return $Array;
	}

	optimize($Array, $cnt + 1);
	return $Array;

}
function StrengthCalculator($arr_teams) {
	//CALCULATING TEAM STENGTH

	$arr_team_A = $arr_teams[0];
	$arr_team_B = $arr_teams[1];

	$strength_team_A = $strength_team_B = 0;

	foreach ($arr_team_A as $player) {
		$strength_team_A += $player->rank;
	}

	foreach ($arr_team_B as $player) {
		$strength_team_B += $player->rank;
	}

	return array($strength_team_A, $strength_team_B);
}
function MakethePool($arr_players_pool, $arr_now_present_players) {

	//GETTING THE PLAYER OBJECT FROM
	//THE POOL FOR ONLY THOSE ARE PRESENT

	$arr_present_players = array();
	foreach ($arr_now_present_players as $now_present_player) {
		foreach ($arr_players_pool as $player) {
			if ($player->id == $now_present_player) {
				array_push($arr_present_players, $player);
			}
		}
	}

	return $arr_present_players;
}
function print_team($arr_current_teams, $Title = "") {
	$arr_team_strength = StrengthCalculator($arr_current_teams);
	$Str1 = $Str2 = "<table border=0>";
	foreach ($arr_current_teams[0] as $selected_player) {
		//$Str1 .= "<tr><td>" . $selected_player->name . "[" . $selected_player->rank . "]</td></tr>";
		$Str1 .= "<tr><td>" . $selected_player->name . "</td></tr>";
	}
	$Str1 .= "<tr><td style='border-top:1px solid red'>" . $arr_team_strength[0] . "</td></tr></table>";
	foreach ($arr_current_teams[1] as $selected_player) {
		//$Str2 .= "<tr><td>" . $selected_player->name . "[" . $selected_player->rank . "]</td></tr>";
		$Str2 .= "<tr><td>" . $selected_player->name . "</td></tr>";

	}
	$Str2 .= "<tr><td style='border-top:1px solid red'>" . $arr_team_strength[1] . "</td></tr></table>";

	$Str = "<table border=1>
			<tr><th colspan=2>" . $Title . "</th></tr>
			<tr>
				<td>" . $Str1 . "</td>
		  		<td>" . $Str2 . "</td>
		  	</tr>
		  	</table>";
	echo $Str;
}
function cmp($a, $b) {
	//Comparison function for USORT
	if ($a->rank == $b->rank) {
		return 0;
	}
	return ($a->rank > $b->rank) ? -1 : 1;
}
?>

</body>
</html>