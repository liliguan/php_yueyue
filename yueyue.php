
<!DOCTYPE html>
<html>
<body>

<?php 
$x = 30;
$y = 65; 

function addition() {
   $GLOBALS['z'] = $GLOBALS['x'] + $GLOBALS['y'];
}

echo $x;
echo $z;
?>

</body>
</html>