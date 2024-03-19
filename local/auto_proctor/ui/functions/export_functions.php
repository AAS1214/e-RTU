<?php
$quiz_id = 
// Your SQL query
$sql = "SELECT *
        FROM {auto_proctor_activity_report_tb}
        WHERE quizid = :quiz_id;";

// Parameters for the query
$params = array('quiz_id' => $quiz_id);

// Fetch records from the database
$all_quiz_reports = $DB->get_records_sql($sql, $params);

// Define CSV headers
$headers = array('Column1', 'Column2', 'Column3'); // Replace with your column names

// Set the CSV filename
$filename = 'quiz_reports.csv';

// Output CSV data
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// Open output stream
$output = fopen('php://output', 'w');

// Write CSV headers
fputcsv($output, $headers);

// Write CSV rows
foreach ($all_quiz_reports as $report) {
    // Adjust this according to your table structure
    $row = array(
        $report->column1,
        $report->column2,
        $report->column3
    );
    fputcsv($output, $row);
}

// Close the output stream
fclose($output);
?>
