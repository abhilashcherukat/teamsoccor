<?php
// PHP program to split
// an array into Two
// equal sum subarrays

// Returns split point.
// If not possible, then
// return -1.
function findSplitPoint($arr, $n) {
	$leftSum = 0;

	// traverse array element
	for ($i = 0; $i < $n; $i++) {

		// add current element
		// to left Sum
		$leftSum += $arr[$i];

		// find sum of rest array
		// elements (rightSum)
		$rightSum = 0;
		for ($j = $i + 1; $j < $n; $j++) {
			$rightSum += $arr[$j];
		}

		// split point index
		if ($leftSum == $rightSum || (abs($leftSum - $rightSum) == -1)) {
			return $i + 1;
		}

	}

	// if it is not possible
	// to split array into
	// two parts
	return -1;
}

// Prints two parts after
// finding split point using
// findSplitPoint()
function printTwoParts($arr, $n) {
	$splitPoint = findSplitPoint($arr, $n);

	if ($splitPoint == -1 or $splitPoint == $n) {
		echo "Not Possible";
		return;
	}
	for ($i = 0; $i < $n; $i++) {
		if ($splitPoint == $i) {
			echo "<br>";
		}

		echo $arr[$i], " ";
	}
}

// Driver Code
$arr = array(6, 4, 3, 2);
$n = count($arr);
printTwoParts($arr, $n);

// This code is contributed by anuj_67.
?>