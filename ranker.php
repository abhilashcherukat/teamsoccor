<?php

$fp = fopen('player.json', 'r') or die("Unable to open file!");
$filecontent = fread($fp, filesize('player.json'));
fclose($fp);
$arr_player_pool = json_decode($filecontent);
$Str = "<form action='" . $_SERVER['PHP_SELF'] . "' method='post'><table border=0>
<tr><td><select name='player'><option value='-1'>Select your name</option>";
$k = 0;
foreach ($arr_player_pool as $players) {
	/*if ($k != 0 && $k % 4 == 0) {
		$Str .= "</tr><tr>";
	}*/
	$Str .= "<option value='" . $players->id . "'>" . $players->name . "</option>";

}

//$Str .= "</tr><tr><td><input type='submit' name='btnsubmit' value='Generate'></td></tr></table></form>";
$Str .= "</select></td></tr>
	<tr><td>Over all Ball Control<td>
<td style='padding-right: 22px;'>1 <input type='radio' name='ballcontrol' checked value='1'></td>
	<td style='padding-right: 22px;'>2 <input type='radio' name='ballcontrol' value='2'></td>
	<td style='padding-right: 22px;'>3 <input type='radio' name='ballcontrol' value='3'></td>
	<td style='padding-right: 22px;'>4 <input type='radio' name='ballcontrol' value='4'></td>
	<td style='padding-right: 22px;'>5 <input type='radio' name='ballcontrol' value='5'></td>
	<td style='padding-right: 22px;'>6 <input type='radio' name='ballcontrol' value='6'></td>
	</tr>

	<tr><td>Speed and Agility<td>
<td style='padding-right: 22px;'>1 <input type='radio' name='Speed' checked value='1'></td>
	<td style='padding-right: 22px;'>2 <input type='radio' name='Speed' value='2'></td>
	<td style='padding-right: 22px;'>3 <input type='radio' name='Speed' value='3'></td>
	<td style='padding-right: 22px;'>4 <input type='radio' name='Speed' value='4'></td>
	<td style='padding-right: 22px;'>5 <input type='radio' name='Speed' value='5'></td>
	<td style='padding-right: 22px;'>6 <input type='radio' name='Speed' value='6'></td>
	</tr>

	<tr><td>Dribbling and Passing<td>
<td style='padding-right: 22px;'>1 <input type='radio' name='Passing' checked value='1'></td>
	<td style='padding-right: 22px;'>2 <input type='radio' name='Passing' value='2'></td>
	<td style='padding-right: 22px;'>3 <input type='radio' name='Passing' value='3'></td>
	<td style='padding-right: 22px;'>4 <input type='radio' name='Passing' value='4'></td>
	<td style='padding-right: 22px;'>5 <input type='radio' name='Passing' value='5'></td>
	<td style='padding-right: 22px;'>6 <input type='radio' name='Passing' value='6'></td>
	</tr>


	<tr><td>Shielding, Tackling and Trapping.<td>
<td style='padding-right: 22px;'>1 <input type='radio' name='Trapping' checked value='1'></td>
	<td style='padding-right: 22px;'>2 <input type='radio' name='Trapping'  value='2'></td>
	<td style='padding-right: 22px;'>3 <input type='radio' name='Trapping' value='3'></td>
	<td style='padding-right: 22px;'>4 <input type='radio' name='Trapping' value='4'></td>
	<td style='padding-right: 22px;'>5 <input type='radio' name='Trapping' value='5'></td>
	<td style='padding-right: 22px;'>6 <input type='radio' name='Trapping' value='6'></td>
	</tr>

	<tr><td>Shooting and Goalkeeping<td>
<td style='padding-right: 22px;'>1 <input type='radio' name='Goalkeeping' checked value='1'></td>
	<td style='padding-right: 22px;'>2 <input type='radio' name='Goalkeeping'  value='2'></td>
	<td style='padding-right: 22px;'>3 <input type='radio' name='Goalkeeping' value='3'></td>
	<td style='padding-right: 22px;'>4 <input type='radio' name='Goalkeeping' value='4'></td>
	<td style='padding-right: 22px;'>5 <input type='radio' name='Goalkeeping' value='5'></td>
	<td style='padding-right: 22px;'>6 <input type='radio' name='Goalkeeping' value='6'></td>
	</tr>

<tr><td>
<span style='color:red;font-weight:bold'>MAKE SURE YOU SUBMIT ONCE. AND ONLY FOR YOUR NAME</span><br>
<input type='submit' name='btnsubmit' value='Save'></td></tr></table></form>";

echo $Str;

if (isset($_POST['btnsubmit'])) {
	if ($_POST['player'] === "-1") {
		echo "SELECT YOUR NAME FIRST!!!!";
	}
	$fp = fopen($_POST['player'] . ".txt", "w");
	fwrite($fp, json_encode($_POST));
}
?>
