<?php
$db = mysqli_connect("localhost", "root", "", "mathdb");
if (!$db) {
    die("Connection failed: ".mysqli_error($db));
}
$bookTitle = mysqli_real_escape_string($db, filter_input(INPUT_POST, "bookTitle"));
$subtitle = mysqli_real_escape_string($db, filter_input(INPUT_POST, "subtitle"));
$authors = mysqli_real_escape_string($db, filter_input(INPUT_POST, "authors"));
$isbn = filter_input(INPUT_POST, "isbn");
$publisher = mysqli_real_escape_string($db, filter_input(INPUT_POST, "publisher"));
$edition = filter_input(INPUT_POST, "edition");
if(!is_numeric($edition) || $edition < 0) {$edition = "";}
$year = filter_input(INPUT_POST, "year");
if(!is_numeric($year) || $year < 0) {$year = "";}
$chapters = filter_input(INPUT_POST, "chapters");
if(!is_numeric($chapters) || $chapters < 0) {$chapters = "";}

if($bookTitle === "" || $authors === "" || $isbn === "" || $publisher === "" || $edition === "" || $year === "" || $chapters === "") {
    echo "Error: The following fields MUST contain a value!\nBook Title\nAuthors\nISBN\nPublisher\nEdition\nYear\nChapters\nEnsure all fields have a value!";
    exit(1);
}

$insert = "INSERT INTO book (book_title, subtitle, authors, isbn, edition_number, year_number, publisher, number_of_chapters)"
        . " VALUES ('{$bookTitle}', '{$subtitle}', '{$authors}', '{$isbn}', {$edition}, {$year}, '{$publisher}', {$chapters});";

$query = "SELECT isbn FROM book WHERE isbn = '{$isbn}';";
$result = mysqli_query($db, $query);
$count = mysqli_num_rows($result);
if($count > 0) {
    echo "Duplicate entry: ISBN already exists!";
    exit(0);
}
    
if(mysqli_query($db, $insert)) {
    echo "Inserted book successflly into database";
} else {
    echo "Error: " . $insert . "<br />" . mysqli_error($db);
}
mysqli_close($db);
?>