<?php
$db = mysqli_connect("localhost", "root", "", "mathdb");
if (!$db) {
    die("Connection failed: ".mysqli_error($db));
}
$bookTitle = mysqli_real_escape_string($db, filter_input(INPUT_POST, "book"));
$question = mysqli_real_escape_string($db, filter_input(INPUT_POST, "question"));
$question = str_replace(";--;", "+", $question);
if ($question === "") {
    echo 'Warning: Question is empty!';
    exit(1);
}

$page_num = filter_input(INPUT_POST, "page");
if (!is_numeric($page_num) || $page_num < 0) {
    $page_num = 0;}
$chapter = filter_input(INPUT_POST, "chapter");
if (!is_numeric($chapter) || $chapter < 0) {
    $chapter = 0;}
$section = filter_input(INPUT_POST, "section");
if (!is_numeric($section) || $section < 0) {
    $section = 0;}
$question_number = filter_input(INPUT_POST, "prob_number");
if (!is_numeric($question_number) || $question_number < 0) {
    $question_number = 0;}
if ($bookTitle == "-- Select a book --") {
    $bookTitle = "";}

if ($bookTitle !== "" && ($page_num == 0 || $question_number == 0)) {
    echo "Error: You must insert a page number AND problem number when a book is selected!";
    exit(1);
}
$query = "SELECT book_title, page_num, question_num FROM math_questions WHERE book_title='{$bookTitle}' AND page_num='{$page_num}' AND question_num='{$question_number}';";
$result = mysqli_query($db, $query);
$count = mysqli_num_rows($result);
if($count > 0) {
    echo "Duplicate entry: Question already exists";
    exit(1);
}

$insert = "INSERT INTO math_questions (question, book_title, page_num, chapter_num, section_num, question_num)"
        . " VALUES ('{$question}', '{$bookTitle}', '{$page_num}', '{$chapter}', '{$section}', '{$question_number}');";

if(mysqli_query($db, $insert)) {
    echo "Inserted question successfully into database";
} else {
    echo "Error: " . $insert . "<br />" . mysqli_error($db);
}

mysqli_close($db);
?>