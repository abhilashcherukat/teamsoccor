<?php

$Pool = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
$Team = array(array(), array());

for ($i = 0; $i < count($Pool); $i++) {
	echo $Pool[$i] . " ";
	array_push($Team[$i % 2], $Pool[$i]);
}
print_team($Team, "Initial");
$Team = optimize($Team);
print_team($Team, "Optimized");

function optimize($Team) {
	$Strength = StrengthCalculator($Team);

	$Difference = $Strength[0] - $Strength[1];
	echo "Diffenerce:" . $Difference . "<br>";
	if (abs($Difference) <= 2) {
		return $Team;
	}

	if ($Difference > 0) {
		$ToSwap1 = FindPlayer($Difference, $Team[1]);
		$ToSwap2 = FindPlayer($Difference * 2, $Team[0]);
	} else {
		$ToSwap2 = FindPlayer($Difference * -1, $Team[0]);
		$ToSwap1 = FindPlayer($Difference * -2, $Team[1]);
	}

	echo $ToSwap1 . " - " . $ToSwap2;

	$X = $Team[1][$ToSwap1];
	$Team[1][$ToSwap1] = $Team[0][$ToSwap2];
	$Team[0][$ToSwap2] = $X;
	print_team($Team, "Optimizing");
	optimize($Team);

}

function FindPlayer($Difference, $Team) {

	echo $Difference . "<br>";
	for ($i = 0; $i < count($Team); $i++) {
		if ($Team[$i] == $Difference || $Difference == 0) {

			return $i;
		}
	}

	FindPlayer($Difference - 1, $Team);

}

function StrengthCalculator($arr_teams) {
	//CALCULATING TEAM STENGTH

	$arr_team_A = $arr_teams[0];
	$arr_team_B = $arr_teams[1];

	$strength_team_A = $strength_team_B = 0;

	foreach ($arr_team_A as $player) {
		$strength_team_A += $player;
	}

	foreach ($arr_team_B as $player) {
		$strength_team_B += $player;
	}

	return array($strength_team_A, $strength_team_B);
}

function print_team($arr_current_teams, $Title = "") {
	$arr_team_strength = StrengthCalculator($arr_current_teams);
	$Str1 = $Str2 = "<table border=0>";
	foreach ($arr_current_teams[0] as $selected_player) {

		$Str1 .= "<tr><td>" . $selected_player . "</td></tr>";
	}
	$Str1 .= "<tr><td style='border-top:1px solid red'>" . $arr_team_strength[0] . "</td></tr></table>";
	foreach ($arr_current_teams[1] as $selected_player) {

		$Str2 .= "<tr><td>" . $selected_player . "</td></tr>";

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

?>