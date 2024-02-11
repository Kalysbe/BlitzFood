$num1 = 83.9846667
$num2 = 83.10333333

$rounded = array();
$rounded[0] = round($num2,6);
for($i = 1 ; $i <= 4 ;$i++) {
  $rounded[$i] = round($rounded[$i-1], $i+2);
}

echo number_format($rounded[4],2,',',' ')