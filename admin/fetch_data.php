<?php
// Your database connection and other necessary includes

// Fetch data from the database
// Replace this with your actual query to get the data you need for the chart
$data = array(
    array("name" => "Charles", "votes" => 340),
    array("name" => "Meander", "votes" => 100),
    array("name" => "Asare", "votes" => 128),
    array("name" => "Alex", "votes" => 78),
    array("name" => "James", "votes" => 421),
    array("name" => "Christiano", "votes" => 384)
);

// Return the data as JSON
echo json_encode($data);
