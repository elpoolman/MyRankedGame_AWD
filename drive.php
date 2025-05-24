<?php
require_once __DIR__ . '/google-api-php-client-main/vendor/autoload.php';

function uploadFileToDrive($filePath) {
    $client = new Google_Client();
    $client->setAuthConfig(__DIR__ . '/credentials.json');
    $client->addScope(Google_Service_Drive::DRIVE_FILE);
    $client->setAccessType('offline');

    $service = new Google_Service_Drive($client);

    // Folder ID of your Google Drive folder
    $driveFolderId = '1j6YeY9BQ17CdMmZ3zhTj4jfXtLBCbDfq';

    $fileMetadata = new Google_Service_Drive_DriveFile([
        'name' => basename($filePath),
        'parents' => [$driveFolderId]
    ]);

    $content = file_get_contents($filePath);

    $uploadedFile = $service->files->create($fileMetadata, [
        'data' => $content,
        'mimeType' => 'application/json',
        'uploadType' => 'multipart',
        'fields' => 'id'
    ]);

    return $uploadedFile->id;
}
?>
