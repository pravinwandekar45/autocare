
<?php

$host = getenv("DB_HOST");
$user = getenv("DB_USER");
$password = getenv("DB_PASSWORD");
$database = getenv("DB_NAME");
$port = (int) getenv("DB_PORT");
$ca = getenv("DB_SSL_CA");

$conn = mysqli_init();

$conn->ssl_set(NULL, NULL, $ca, NULL, NULL);

if (!$conn->real_connect(
    $host,
    $user,
    $password,
    $database,
    $port,
    NULL,
    MYSQLI_CLIENT_SSL
)) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
