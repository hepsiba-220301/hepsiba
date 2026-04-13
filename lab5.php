
<?php

echo "<h2>🔹 PHP Variables</h2>";

// Variables
$name = "Smart Parking";
$slots = 20;
$price = 50.5;

echo "Name: $name <br>";
echo "Total Slots: $slots <br>";
echo "Price per hour: $price <br>";


// -----------------------------

echo "<h2>🔹 Variable Scope</h2>";

// GLOBAL SCOPE
$x = 10;

function testGlobal() {
    global $x;
    echo "Global variable inside function: $x <br>";
}
testGlobal();


// LOCAL SCOPE
function testLocal() {
    $y = 20;
    echo "Local variable inside function: $y <br>";
}
testLocal();

// echo $y; ❌ ERROR (outside function)


// STATIC SCOPE
function testStatic() {
    static $z = 0;
    $z++;
    echo "Static variable value: $z <br>";
}

testStatic();
testStatic();
testStatic();


// -----------------------------

echo "<h2>🔹 PHP String Functions</h2>";

$text = "Smart Parking System";

// strlen()
echo "Length: " . strlen($text) . "<br>";

// str_word_count()
echo "Word Count: " . str_word_count($text) . "<br>";

// strrev()
echo "Reverse: " . strrev($text) . "<br>";

// strpos()
echo "Position of 'Parking': " . strpos($text, "Parking") . "<br>";

// str_replace()
echo "Replace word: " . str_replace("Parking", "Car", $text) . "<br>";

// strtoupper()
echo "Uppercase: " . strtoupper($text) . "<br>";

// strtolower()
echo "Lowercase: " . strtolower($text) . "<br>";

?>

