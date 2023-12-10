<?php

function pdo_connect_mysql() {
    $DATABASE_HOST = 'localhost';
    $DATABASE_PORT = '3312'; // Set the desired port here
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '1234';
    $DATABASE_NAME = 'sir-crud';

    try {
        $pdo = new PDO('mysql:host=' . $DATABASE_HOST . ';port=' . $DATABASE_PORT . ';dbname=' 
            . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);

        // Return the PDO object for your database connection
        return $pdo;
    } catch (PDOException $exception) {
        // Display an error message and exit
        exit('Failed to connect to the database: ' . $exception->getMessage());
    }
}

// Example usage
$pdo = pdo_connect_mysql();
// Now $pdo contains the PDO object for your database connection

// You can add your database operations here using $pdo
// For example: $stmt = $pdo->query('SELECT * FROM your_table');
// ...

// Remember to close the connection when you're done (optional)
//$pdo = null;
?>
