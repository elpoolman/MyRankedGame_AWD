<?php
function createUserJson($username, $email, $birthdate) {
    $folderPath = __DIR__ . "/new_json";
    if (!is_dir($folderPath)) {
        mkdir($folderPath, 0777, true);
    }

    $timestamp = date("Ymd_His");
    $filename = "new_ac_" . $username . "_" . $timestamp . ".json";
    $filePath = $folderPath . "/" . $filename;

    $data = [
        "username" => $username,
        "email" => $email,
        "birthdate" => $birthdate,
        "created_at" => date("Y-m-d H:i:s")
    ];

    file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));

    return $filePath;
}
?>
