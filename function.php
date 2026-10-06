<?php

// match expression

$color="pink";
$text=match($color)
{
    "red"=>"you choose red",
    "pink"=>"you choose pink",
    "green"=>"you choose green",
};
echo $text;
echo "\n";

$a=5;
$number=match($a)
{
    1,2,3,4=>"between 1 to 4",
    5,6,7,8=>"between 5 to 8",
    9,10=>"9 or 10",
};
echo $number;
?>