<!DOCTYPE html>
<!--   Author: Anthony Cavallo
       Date: 20160404
       This is the client-side to entering a math question
-->
<html lang="en">
    <head>
        <title> Index </title>
        <meta charset = "utf-8" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="indexCSS.css"> <!-- I added an outside style sheet so it wouldn't clutter up this file any more than it already is. -->
    </head>
    <body>
        <script>
            //All of the script in here perform a couple different functions; coloring blank spaces if a book is selected, uncoloring them if information is entered,
            $(document).ready(function() {
                $("#book").change(function () {
                    if($("#book").val() === "-- Select a book --") {
                        $(".fields").css("background-color", "white");
                    } else {
                        if ($(".fields").val() === "") {
                            $(".fields").css("background-color", "red");
                        }
                    }
                });
                $(".fields").change(function () {
                    if($(this).val() === "" && $("#book").val() !== "-- Select a book --") {
                        $(this).css("background-color", "red");
                    } else {
                        $(this).css("background-color", "white");
                    }
                });
            });
            function checkQuestion() {
                var question = document.getElementById("question").value;
                var book = document.getElementById("book").value;
                var page = document.getElementById("page").value;
                var chapter = document.getElementById("chapter").value;
                var section = document.getElementById("section").value;
                var prob_number = document.getElementById("prob_number").value;
                
                var questionRequest =  new XMLHttpRequest();
                questionRequest.onreadystatechange = function() {
                    if (questionRequest.readyState === 4 && questionRequest.status === 200) {
                        var questionResponse = questionRequest.responseText;
                        alert(questionResponse);
                    }
                    console.log(questionResponse);
                };
                var formQuery = "&question="+question+"&book="+book+"&page="+page+"&chapter="+chapter+"&section="+section+"&prob_number="+prob_number;
                formQuery = formQuery.replace(/\+/g, ";--;");
                questionRequest.open("POST", "Question.php", true);
                questionRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                questionRequest.send(formQuery);
            }
        </script>
        <form id="problem" action="#" method="POST" onsubmit="return checkQuestion()">
            <textarea name="question" id="question" rows="4" cols="50" placeholder="Enter a problem" autofocus></textarea>
            <br /> <br />
            <select name="book" id="book" style="max-width: 150px">
                <option>-- Select a book --</option>
                <?php
                $db = mysqli_connect("localhost", "root", "", "mathdb");
                $result = mysqli_query($db, "SELECT book_title FROM book");
                while ($row = mysqli_fetch_array($result)) {
                    print "<option> {$row['book_title']} </option>";
                }
                ?>
            </select>
            <br />
            <br />
                  <input class="fields" name="page" id="page" type="text" size="6" placeholder="page"/>
            &nbsp <input class="fields" name="chapter" id="chapter" type="text" size="6" placeholder="chapter"/>
            &nbsp <input class="fields" name="section" id="section" type="text" size="6" placeholder="section"/>
            &nbsp <input class="fields" name="prob_number" id="prob_number" type="text" size="12" placeholder="prob-number"/>
            <br />
            <br />
            <input type="submit" value="Enter" id="enter"/> &nbsp
            <input type="button" value="Book-On" onclick="window.location.href='Book-on.php'"/>
        </form>
        <?php
        $query = "SELECT question, book_title, page_num, chapter_num, section_num, question_num ";
        $query .= "FROM math_questions ORDER BY qid DESC;";
        $output = "<table width=\"80%\"><tr><th>Question</th><th>Book</th><th>Page #</th><th>Chapter #</th><th>Section #</th><th>Question #</th></tr>";
        $result = mysqli_query($db, $query);
        $count = 0;
        $count = mysqli_num_rows($result);
        while ($row = mysqli_fetch_array($result)) {
            $output .= "<td>{$row['question']}</td>";
            $output .= "<td>{$row['book_title']}</td>";
            $output .= "<td align=\"center\">{$row['page_num']}</td>";
            $output .= "<td align=\"center\">{$row['chapter_num']}</td>";
            $output .= "<td align=\"center\">{$row['section_num']} </td>";
            $output .= "<td align=\"center\">{$row['question_num']} </td>";
            $output .= "</tr>";
        }
        $output .= "</table>";
        print $output;
        mysqli_close($db);
        ?>
    </body>
</html>