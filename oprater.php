<?php

$variable1 = 9;
$variable2 = 10;


// Arithmetic Operators

echo "The value of variable1 + variable2 is ";
echo $variable1 + $variable2;
echo "\n";

echo "The value of variable1 - variable2 is ";
echo $variable1 - $variable2;
echo "\n";

echo "The value of variable1 * variable2 is ";
echo $variable1 * $variable2;
echo "\n";

echo "The value of variable1 / variable2 is ";
echo $variable1 / $variable2;
echo "\n";


// Assignment Operators

$variable2 = $variable1;

echo "The value of the variable now is ";
echo $variable2;
echo "\n";

$variable2 += 10;

echo "The value of the variable now is ";
echo $variable2;
echo "\n";

$variable2 -= 10;

echo "The value of the variable now is ";
echo $variable2;
echo "\n";

$variable2 *= 10;

echo "The value of the variable now is ";
echo $variable2;
echo "\n";

$variable2 /= 10;

echo "The value of the variable now is ";
echo $variable2;
echo "\n";


// Comparison Operators

echo "The value of 1==4 is ";
var_dump(1 == 4);
echo "\n";

echo "The value of 1!=4 is ";
var_dump(1 != 4);
echo "\n";

echo "The value of 1>=4 is ";
var_dump(1 >= 4);
echo "\n";

echo "The value of 1<=4 is ";
var_dump(1 <= 4);
echo "\n";


// Increment / Decrement Operators

echo $variable1++;
echo "\n";

echo $variable1--;
echo "\n";

echo ++$variable1;
echo "\n";

echo --$variable1;
echo "\n";

echo $variable1;
echo "\n";


// Logical Operators

$myVar = (true and true);
var_dump($myVar);
echo "\n";

$myVar = (false and true);
var_dump($myVar);
echo "\n";

$myVar = (false and false);
var_dump($myVar);
echo "\n";

$myVar = (true and false);
var_dump($myVar);
echo "\n";

$myVar = (true or false);
var_dump($myVar);
echo "\n";

$myVar = (true xor true);
var_dump($myVar);
echo "\n";

$myVar = (false xor false);
var_dump($myVar);
echo "\n";

$myVar = (true and false);
var_dump($myVar);
echo "\n";

?>