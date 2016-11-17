<?php require_once 'header.php'; ?>

<?php

// Query DB for list of skills

$skills = queryMysql("SELECT * FROM skills ORDER BY skillname");

while ($row = $skills->fetch_assoc()) {

    echo $row['id'] . ". ";
    echo $row['skillname'] . "<br />";
    
}

?>

<?php require_once 'footer.php'; ?>