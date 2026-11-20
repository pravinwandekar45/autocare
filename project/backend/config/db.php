
<?php

$host = getenv("DB_HOST");
$user = getenv("DB_USER");
$password = getenv("DB_PASSWORD");
$database = getenv("DB_NAME");
$port = (int) getenv("DB_PORT");
$ca = getenv("DB_SSL_CA");

if (!$host || !$user || !$password || !$database || !$port) {
    die("Database configuration environment variables are missing.");
}

$conn = mysqli_init();

if (!$conn) {
    die("MySQL initialization failed.");
}

// Enable SSL if CA certificate is configured
if (!empty($ca)) {

    if (!file_exists($ca)) {
        die("SSL certificate file not found: " . $ca);
    }

    $conn->ssl_set(NULL, NULL, $ca, NULL, NULL);

    $ssl = MYSQLI_CLIENT_SSL;

} else {
    die("DB_SSL_CA environment variable is missing.");
}

try {

    $conn->real_connect(
        $host,
        $user,
        $password,
        $database,
        $port,
        NULL,
        $ssl
    );

} catch (mysqli_sql_exception $e) {

    die("Database connection failed: " . $e->getMessage());

}

?>
