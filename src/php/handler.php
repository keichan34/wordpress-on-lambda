<?php

// A special handler.

// All requests through API Gateway are HTTPS.
$_SERVER['HTTPS'] = 'on';

$extension_map = array(
    "css" => "text/css",
    "js" => "application/javascript",
    "png" => "image/png",
    "jpeg" => "image/jpeg",
    "jpg" => "image/jpeg",
    "svg" => "image/svg+xml"
);

$request_uri = explode("?", $_SERVER['REQUEST_URI']);
$local_file_path = $_SERVER['DOCUMENT_ROOT'] . $request_uri[0];

if ( $local_file_path == __FILE__ ) {
    http_response_code(400);
    echo 'Sorry';
    exit();
}

// echo '<pre>';
// var_dump($_SERVER);
// echo '</pre>';

// echo "X-ScriptFilename: " . $local_file_path;
// exit();

$split = explode(".", $local_file_path);
$extension = end($split);
$mapped_type = $extension_map[$extension];

if ( $mapped_type && file_exists( $local_file_path ) ) {
    header("Content-Type: {$mapped_type}");
    readfile($local_file_path);

} elseif ( $extension == "php" && file_exists( $local_file_path ) ) {
    header("X-ExecFile: {$local_file_path}");
    require( $local_file_path );

} elseif ( substr($local_file_path, -1) == "/" && file_exists( $local_file_path . "index.php" ) ) {
    $exec_file_path = $local_file_path . "index.php";
    header("X-ExecFile: {$exec_file_path}");
    require( $exec_file_path );

} else {
    $exec_file_path = dirname(__FILE__) . '/index.php';
    header("X-ExecFile: {$exec_file_path}");
    require( $exec_file_path );
}
