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
// Get user user id
$user_id = $USER->id;

if (isset($_POST['quiz_id'])) {
    $quiz_id = $_POST['quiz_id'];

    // Your SQL query
    $sql = "SELECT *
            FROM {auto_proctor_activity_report_tb}
            WHERE quizid = :quiz_id";

    // Parameters for the query
    $params = array('quiz_id' => $quiz_id);

    // Fetch records from the database
    $all_quiz_reports = $DB->get_records_sql($sql, $params);

    if ($all_quiz_reports) {
        // Define CSV headers
        $headers = array('EVENT_DATETIME', 'USERID', 'QUIZID', 'ATTEMPT', 'ACTIVITY_TYPE', 'EVIDENCE'); // Replace with your column names
    
        // Set the CSV filename
        $filename = 'quiz_reports.csv';
    
        // Output CSV data
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
    
        // Open output stream
        ob_start();
        $output = fopen('php://output', 'w');
    
        // Write CSV headers
        fputcsv($output, $headers);
    
        // Write CSV rows
        foreach ($all_quiz_reports as $report) {
            // Adjust this according to your table structure
            $row = array(
                $report->event_datetime,
                $report->userid,
                $report->quizid,
                $report->attempt,
                $report->activity_type,
                $report->evidence,
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
    
    echo $csv_content;
} else {
    echo "Quiz ID not received.";
}
?>
