
<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = getenv("DB_HOST");
$user = getenv("DB_USER");
$password = getenv("DB_PASSWORD");
$database = getenv("DB_NAME");
$port = (int) getenv("DB_PORT");
$ca = getenv("DB_SSL_CA");

if (!$host || !$user || !$password || !$database || !$port || !$ca) {
    die("Database configuration environment variables are missing.");
}

if (!file_exists($ca) || !is_readable($ca)) {
    die("SSL certificate missing or not readable: " . $ca);
}

$conn = mysqli_init();

if (!$conn) {
    die("MySQL initialization failed.");
}

try {

    // Verify server certificate
    $conn->options(
        MYSQLI_OPT_SSL_VERIFY_SERVER_CERT,
        true
    );

    // Configure SSL certificate
    if (!$conn->ssl_set(NULL, NULL, $ca, NULL, NULL)) {
        throw new Exception("SSL configuration failed.");
    }

    // Connect to TiDB Cloud
    $conn->real_connect(
        $host,
        $user,
        $password,
        $database,
        $port,
        NULL,
        MYSQLI_CLIENT_SSL
    );

    $conn->set_charset("utf8mb4");

} catch (Throwable $e) {

    error_log("Database connection error: " . $e->getMessage());

    die("Database connection failed. Please check server configuration and logs.");

}

?>
