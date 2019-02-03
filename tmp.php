<?php 

$test = [1,2,3,4,5,6,7,8,9,10];

function find(array $arr, float $val):int {
    $a0 = 0;
    $a1 = count($arr)-1;
    $aa = round($a1/2);
    while(true) {
        if ((float)$arr[$aa] === $val) {
            return $aa;
        } elseif ($val > (float)$arr[$aa]) {
            $a0 = $aa;
            $aa = $aa + round(($a1-$a0)/2);
        } else {
            $a1 = $aa;
            $aa = $aa - round(($a1-$a0)/2);
        }
    }

    return -1;
}

$count = 3;
$string = "У нас всего есть $count яблока.";
echo $string;


echo 'Hi. "I\'ll be" started.'.PHP_EOL;
for ($i=1; $i<=10; $i++) {
    $res = find($test, $i);
    echo "Result is {$res}".PHP_EOL;
}
