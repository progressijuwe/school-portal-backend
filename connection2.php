<?php

$connection = mysqli_connect("localhost", "root", "root", "school_db", 3307);

if ($connection -> connect_error){
    die ("Connection failed: ". $connection -> connect_error);
}

?>