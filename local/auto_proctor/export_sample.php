<?php
// // URL of the file on the server
// $url = 'http://localhost/PROJECTS/e-RTU/local/auto_proctor/proctor_tools/evidences/microphone_capture_evidence/EVD_USER_2_QUIZ_2_ATTEMPT_1_02292024115852PMGMT+8_847_speech_detected_.wav';

// // Local path where you want to save the file
// $localPath = 'C:/Users/angel/OneDrive/Desktop/export.mp4';

// // Fetch the file contents from the server
// $fileContents = file_get_contents($url);

// if ($fileContents !== false) {
//     // Save the file contents to the local path
//     $result = file_put_contents($localPath, $fileContents);

//     if ($result !== false) {
//         echo "File saved successfully to $localPath";
//     } else {
//         echo "Failed to save the file to $localPath";
//     }
// } else {
//     echo "Failed to fetch the file from $url";
// }

// URL of the file to download
// URLs of the files to download




// $fileUrls = array(
//     'http://localhost/PROJECTS/e-RTU/local/auto_proctor/proctor_tools/evidences/camera_capture_evidence/EVD_USER_3_QUIZ_13_ATTEMPT_1_03202024120014PMGMT+8_198_RECORDING.webm',
//     'http://localhost/PROJECTS/e-RTU/local/auto_proctor/proctor_tools/evidences/camera_capture_evidence/EVD_USER_3_QUIZ_13_ATTEMPT_1_03202024120009PMGMT+8_558_suspicious_movement.png'
// );

// // Create a new ZipArchive instance
// $zip = new ZipArchive();

// // Path to the zip file
// $zipFilePath = 'downloaded_files.zip';

// // Open the zip file for writing
// if ($zip->open($zipFilePath, ZipArchive::CREATE) === true) {
//     // Loop through each file URL
//     foreach ($fileUrls as $fileUrl) {
//         // Fetch the file contents from the URL
//         $fileContents = file_get_contents($fileUrl);
        
//         // Add the file contents to the zip archive
//         $zip->addFromString(basename($fileUrl), $fileContents);
//     }
    
//     // Close the zip archive
//     $zip->close();

//     // Prompt the user to download the zip file
//     header("Content-type: application/zip");
//     header("Content-Disposition: attachment; filename=$zipFilePath");
//     header("Pragma: no-cache");
//     header("Expires: 0");
//     readfile($zipFilePath);

//     // Delete the zip file after download
//     unlink($zipFilePath);
    
//     exit;
// } else {
//     echo 'Failed to create zip file.';
// }
?>
