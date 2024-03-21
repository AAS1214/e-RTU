<?php
// This file is part of Moodle Course Rollover Plugin
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package     local_auto_proctor
 * @author      Angelica
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */

require_once(__DIR__ . '/../../../../config.php'); // Setup moodle global variable also
require_login();
// Get the global $DB object

global $DB, $USER, $CFG;

// if (isset($_POST['quiz_id'])) {
//     $quiz_id = $_POST['quiz_id'];
//     $quiz_name = $_POST['quiz_name'];

//     // Your SQL query
//     $sql = "SELECT *
//             FROM {auto_proctor_activity_report_tb}
//             WHERE quizid = :quiz_id";

//     // Parameters for the query
//     $params = array('quiz_id' => $quiz_id);

//     // Fetch records from the database
//     $all_quiz_reports = $DB->get_records_sql($sql, $params);

//     if ($all_quiz_reports) {
//         // Initialize CSV content
//         $csvContent = '';

//         // Define CSV headers
//         $headers = array('EVENT_DATETIME', 'USERID', 'QUIZID', 'ATTEMPT', 'ACTIVITY_TYPE', 'EVIDENCE');

//         // Add headers to CSV content
//         $csvContent .= implode(',', $headers) . PHP_EOL;

//         // Append records to CSV content
//         foreach ($all_quiz_reports as $report) {
//             // Adjust this according to your table structure
//             $row = array(
//                 $report->event_datetime,
//                 $report->userid,
//                 $report->quizid,
//                 $report->attempt,
//                 $report->activity_type,
//                 $report->evidence,
//             );
//             $csvContent .= implode(',', $row) . PHP_EOL;
//         }

//         // Set the CSV filename
//         $filename = 'quiz_reports.csv';

//         // Set up the zip file
//         $zip = new ZipArchive();
//         $zipFileName = 'quiz_reports.zip';
//         if ($zip->open($zipFileName, ZipArchive::CREATE) === true) {
//             // Add CSV content to zip archive
//             $zip->addFromString($filename, $csvContent);

//             // Close the zip archive
//             $zip->close();

//             // Output the zip file
//             header('Content-Type: application/zip');
//             header('Content-Disposition: attachment; filename="' . $zipFileName . '"');
//             header('Pragma: no-cache');
//             header('Expires: 0');
//             readfile($zipFileName);

//             // Delete the zip file after download
//             unlink($zipFileName);

//             exit;
//         } else {
//             echo 'Failed to create zip file.';
//         }
//     } else {
//         // Handle the case where no records were fetched
//         echo "No quiz reports found for the specified quiz ID.";
//     }
    
// } else {
//     echo "Quiz ID not received.";
// }


// if (isset($_POST['quiz_id'])) {
//     $quiz_id = $_POST['quiz_id'];
//     $quiz_name = $_POST['quiz_name'];

//     // Your SQL query
//     $sql = "SELECT *
//             FROM {auto_proctor_activity_report_tb}
//             WHERE quizid = :quiz_id";

//     // Parameters for the query
//     $params = array('quiz_id' => $quiz_id);

//     // Fetch records from the database
//     $all_quiz_reports = $DB->get_records_sql($sql, $params);

//     if ($all_quiz_reports) {
//         // Define CSV headers
//         $headers = array('EVENT_DATETIME', 'USERID', 'QUIZID', 'ATTEMPT', 'ACTIVITY_TYPE', 'EVIDENCE'); // Replace with your column names
    
//         // Set the CSV filename
//         $filename = 'quiz_reports.csv';
    
//         // Output CSV data
//         header('Content-Type: text/csv');
//         header('Content-Disposition: attachment; filename="' . $filename . '"');
    
//         // Open output stream
//         ob_start();
//         $output = fopen('php://output', 'w');
    
//         // Write CSV headers
//         fputcsv($output, $headers);
    
//         // Write CSV rows
//         foreach ($all_quiz_reports as $report) {
//             // Adjust this according to your table structure
//             $row = array(
//                 $report->event_datetime,
//                 $report->userid,
//                 $report->quizid,
//                 $report->attempt,
//                 $report->activity_type,
//                 $report->evidence,
//             );
//             fputcsv($output, $row);
//         }
    
//         // Close the output stream
//         fclose($output);
//         $csv_content = ob_get_clean();
//     } else {
//         // Handle the case where no records were fetched
//         $csv_content = "No quiz reports found for the specified quiz ID.";
//     }

//     // Create a new ZipArchive instance
//     $zip = new ZipArchive();

//     // Path to the zip file
//     $zipFilePath = 'downloaded_files.zip';

//     // Open the zip file for writing
//     if ($zip->open($zipFilePath, ZipArchive::CREATE) === true) {
//         // Add the CSV content to the zip archive
//         $zip->addFromString($filename, $csv_content);

//         // Download files from URLs and add them to the zip archive
//         foreach ($fileUrls as $fileUrl) {
//             $fileContents = file_get_contents($fileUrl);
//             $fileName = basename($fileUrl);
//             $zip->addFromString($fileName, $fileContents);
//         }
        
//         // Close the zip archive
//         $zip->close();

//         // Prompt the user to download the zip file
//         header("Content-type: application/zip");
//         header("Content-Disposition: attachment; filename=$zipFilePath");
//         header("Pragma: no-cache");
//         header("Expires: 0");
//         readfile($zipFilePath);

//         // Delete the zip file after download
//         unlink($zipFilePath);
        
//         exit;
//     } else {
//         echo 'Failed to create zip file.';
//     }
    
// } else {
//     echo "Quiz ID not received.";
// }


if (isset($_POST['quiz_id'])) {
    $quiz_id = $_POST['quiz_id'];
    $quiz_name = $_POST['quiz_name'];

    // ===== SELECT ACITIVITY REPORTS
        $sql = "SELECT *
                FROM {auto_proctor_activity_report_tb}
                WHERE quizid = :quiz_id
                ORDER BY userid
            ;
        ";

        // Parameters for the query
        $params = array('quiz_id' => $quiz_id);

        // Fetch records from the database
        $all_quiz_reports = $DB->get_records_sql($sql, $params);

        $all_quiz_camera_recording = $DB->get_records_sql($sql, $params);

        if ($all_quiz_reports) {
            // Define CSV headers
            $headers = array('EVENT_DATETIME', 'USERID', 'FIRSTNAME', 'LASTNAME', 'ATTEMPT', 'ACTIVITY_TYPE', 'EVIDENCE'); // Add USERNAME header
        
            // Set the CSV filename
            $filename = 'activity_reports.csv';
        
            // Output CSV data
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
        
            // Open output stream
            ob_start();
            $output = fopen('php://output', 'w');
        
            // Write CSV headers
            fputcsv($output, $headers);
        
            // Add files from URLs to the zip archive
            $fileUrls = array();
            // Write CSV rows
            foreach ($all_quiz_reports as $report) {
                $activity_type = $report->activity_type;

                switch ($activity_type) {
                    case 1:
                        $activity_name = 'Did not share screen';
                        break;
                    case 2:
                        $activity_name = 'Shared Screen';
                        break;
                    case 3:
                        $activity_name = 'Stops Sharing';
                        break;
                    case 4:
                        $activity_name = 'Tab Switch';
                        break;
                    case 5:
                        $activity_name = 'Tab switch but not shared';
                        break;
                    case 6:
                        $activity_name = 'Camera permission denied';
                        break;
                    case 7:
                        $activity_name = 'Camera permission denied during quiz';
                        break;
                    case 8:
                        $activity_name = 'No Face';
                        break;
                    case 9:
                        $activity_name = 'Multiple Face';
                        break;
                    case 10:
                        $activity_name = 'Suspicious Movement';
                        break;
                    case 11:
                        $activity_name = 'Microphone permission denied';
                        break;
                    case 12:
                        $activity_name = 'Microphone permission denied during quiz';
                        break;
                    case 13:
                        $activity_name = 'Speech detected';
                        break;
                    case 14:
                        $activity_name = 'Loud noise';
                        break;
                }

                // Fetch user information based on userid
                $userid = $report->userid;
                $sql = "SELECT * FROM {user} WHERE id = :userid";
                $params = array('userid' => $userid);
                $userinfo = $DB->get_record_sql($sql, $params);
                
                // Construct the full name
                $firstname = $userinfo->firstname;
                $lastname = $userinfo->lastname;
                $idnumber = $userinfo->idnumber;
                

                // Get the file extension from the evidence URL
                $extension = pathinfo(parse_url($report->evidence, PHP_URL_PATH), PATHINFO_EXTENSION);
                
                // Determine the directory based on the file extension
                if ($extension === "png" || $extension === "webm"){
                    if ($activity_type >= 1 && $activity_type <= 5){
                        //echo "<script>console.log(". $activity_type .");</script>";urlencode($report->evidence)
                        $directory = $CFG->wwwroot . '/local/auto_proctor/proctor_tools/evidences/screen_capture_evidence/' . urlencode($report->evidence);
                    }
                    if ($activity_type >= 6 && $activity_type <= 10){
                        //echo "<script>console.log(". $activity_type .");</script>";
                        $directory = $CFG->wwwroot . '/local/auto_proctor/proctor_tools/evidences/camera_capture_evidence/' . urlencode($report->evidence);
                    }
                }
                else if ($extension === "wav"){
                    $directory = $CFG->wwwroot . '/local/auto_proctor/proctor_tools/evidences/microphone_capture_evidence/' . urlencode($report->evidence);
                }

                if ($directory){
                    $fileUrls[] = $directory;
                }
                
                // Adjust this according to your table structure
                $row = array(
                    $report->event_datetime,
                    $idnumber,
                    $firstname,
                    $lastname,
                    $report->attempt,
                    $report->activity_type,
                    urlencode($report->evidence),
                );
                fputcsv($output, $row);
            }
            
        
            // Close the output stream
            fclose($output);
            $csv_content = ob_get_clean();
        } else {
            // Handle the case where no records were fetched
            $csv_content = "No quiz reports found for the specified quiz ID.";
        }

    // ===== SELECT CAMERA RECORDINGS
    $sql = "SELECT *
            FROM {auto_proctor_session_camera_recording}
            WHERE quizid = :quiz_id
            ORDER BY userid
        ;
    ";

    // Parameters for the query
    $params = array('quiz_id' => $quiz_id);
    $all_quiz_camera_recording = $DB->get_records_sql($sql, $params);

    if ($all_quiz_camera_recording) {
        // Define CSV headers
        $headers = array('EVENT_DATETIME', 'USERID', 'FIRSTNAME', 'LASTNAME', 'ATTEMPT', 'CAMERA RECORDING'); // Add USERNAME header
    
        // Set the CSV filename
        $camera_recording_filename = 'camera_recordings.csv';
    
        // Output CSV data
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $camera_recording_filename . '"');
    
        // Open output stream
        ob_start();
        $output = fopen('php://output', 'w');
    
        // Write CSV headers
        fputcsv($output, $headers);

        // Write CSV rows
        foreach ($all_quiz_camera_recording as $recording) {

            // Fetch user information based on userid
            $userid = $recording->userid;
            $sql = "SELECT * FROM {user} WHERE id = :userid";
            $params = array('userid' => $userid);
            $userinfo = $DB->get_record_sql($sql, $params);
            
            // Construct the full name
            $firstname = $userinfo->firstname;
            $lastname = $userinfo->lastname;
            $idnumber = $userinfo->idnumber;
        
        
            if ($recording->camera_recording){
                $directory = $CFG->wwwroot . '/local/auto_proctor/proctor_tools/evidences/camera_capture_evidence/' . urlencode($recording->camera_recording);
                $fileUrls[] = $directory;
            }
            
             // Adjust this according to your table structure
             $row = array(
                $recording->event_datetime,
                $idnumber,
                $firstname,
                $lastname,
                $recording->attempt,
                urlencode($recording->camera_recording),
            );
            fputcsv($output, $row);
        }
        
    
        // Close the output stream
        fclose($output);
        $csv_camera_recordings = ob_get_clean();
    } else {
        // Handle the case where no records were fetched
        $csv_camera_recordings = "No quiz recording found for the specified quiz ID.";
    }


    // ===== SELECT TRUST SCORES
    $sql = "SELECT *
            FROM {auto_proctor_trust_score_tb}
            WHERE quizid = :quiz_id
            ORDER BY userid
        ;
    ";

    // Parameters for the query
    $params = array('quiz_id' => $quiz_id);
    $all_quiz_trust_score= $DB->get_records_sql($sql, $params);

    if ($all_quiz_trust_score) {
        // Define CSV headers
        $headers = array('EVENT_DATETIME', 'USERID', 'FIRSTNAME', 'LASTNAME', 'ATTEMPT', 'TRUST SCORE'); // Add USERNAME header
    
        // Set the CSV filename
        $trust_score_filename = 'trust_score.csv';
    
        // Output CSV data
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $trust_score_filename . '"');
    
        // Open output stream
        ob_start();
        $output = fopen('php://output', 'w');
    
        // Write CSV headers
        fputcsv($output, $headers);

        // Write CSV rows
        foreach ($all_quiz_trust_score as $trust_score) {

            // Fetch user information based on userid
            $userid = $trust_score->userid;
            $sql = "SELECT * FROM {user} WHERE id = :userid";
            $params = array('userid' => $userid);
            $userinfo = $DB->get_record_sql($sql, $params);
            
            // Construct the full name
            $firstname = $userinfo->firstname;
            $lastname = $userinfo->lastname;
            $idnumber = $userinfo->idnumber;
            
             // Adjust this according to your table structure
             $row = array(
                $trust_score->event_datetime,
                $idnumber,
                $firstname,
                $lastname,
                $trust_score->attempt,
                $trust_score->trust_score,
            );
            fputcsv($output, $row);
        }
        
    
        // Close the output stream
        fclose($output);
        $csv_trust_score = ob_get_clean();
    } else {
        // Handle the case where no records were fetched
        $csv_trust_score = "No quiz recording found for the specified quiz ID.";
    }

    // Create a new ZipArchive instance
    $zip = new ZipArchive();

    // Path to the zip file
    $zipFilePath = 'downloaded_files.zip';

    // Open the zip file for writing
    if ($zip->open($zipFilePath, ZipArchive::CREATE) === true) {
        // Add the CSV content to the zip archive
        $zip->addFromString($filename, $csv_content);
        $zip->addFromString($camera_recording_filename, $csv_camera_recordings);
        $zip->addFromString($trust_score_filename, $csv_trust_score);

        foreach ($fileUrls as $fileUrl) {
            $fileContent = file_get_contents($fileUrl);
            if ($fileContent !== false) {
                $fileName = basename($fileUrl);
                $folderName = 'EVIDENCES';
                $zip->addFromString("$folderName/$fileName", $fileContent);
            } else {
                // Log or handle the case where file download failed
            }
        }
        
        // Close the zip archive
        $zip->close();

        // Prompt the user to download the zip file
        header("Content-type: application/zip");
        header("Content-Disposition: attachment; filename=$zipFilePath");
        header("Pragma: no-cache");
        header("Expires: 0");
        readfile($zipFilePath);

        // Delete the zip file after download
        unlink($zipFilePath);
        
        exit;
    } else {
        echo 'Failed to create zip file.';
    }
    
} else {
    echo "Quiz ID not received.";
}
?>
