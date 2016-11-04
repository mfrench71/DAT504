<?php
require_once 'connect.php';

$query = "SELECT * FROM users";
$result = $connection->query($query);


if (!$result) die ($connection->error);

$rows = $result->num_rows;

for ($i = 0; $i < $rows; ++$i) {
    $result->data_seek($i);
    echo 'Username: ' .$result->fetch_assoc()['username'] . '<br/>';
    $result->data_seek($i);
    echo 'First Name: ' .$result->fetch_assoc()['firstname'] . '<br/>';
    $result->data_seek($i);
    echo 'Last Name: ' .$result->fetch_assoc()['lastname'] . '<br/><br/>';
}

$result->close();
$connection->close();

?>