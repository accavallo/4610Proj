<!DOCTYPE html>
<!--   Author: Anthony Cavallo
       Date: 20160404
       This is the client-side to entering a math book
-->
<html lang="en">
    <head>
        <title> Book Page </title>
        <meta charset="utf-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <style type="text/css">
            //<!-- td {text-align: right} -->
            .textbox {width: 300px;}
            .title {width: 300px}
            input[type=text] {
                padding: 3px;
            }
            input[type=text]:focus {
                border: solid lightseagreen;
            }
        </style>
    </head>
    <body>
        <script>
            $(document).ready(function() {
                $("#bookTitle").change(function () {
                    if($("#bookTitle").val() === "") {
                        $(".textbox").css("background-color", "white");
                    } else {
                        if ($(".textbox").val() === "") {
                            $(".textbox").css("background-color", "red");
                        }
                    }
                });
                $(".textbox").change(function () {
                    if($(this).val() === "" && $("#book").val() !== "") {
                        $(this).css("background-color", "red");
                    } else {
                        $(this).css("background-color", "white");
                    }
                });
            });
            function checkBook() {
                var bookTitle = document.getElementById("bookTitle").value;
                var subtitle = document.getElementById("subtitle").value;
                var authors = document.getElementById("authors").value;
                var isbn = document.getElementById("isbn").value;
                var publisher = document.getElementById("publisher").value;
                var edition = document.getElementById("edition").value;
                var year = document.getElementById("year").value;
                var chapters = document.getElementById("chapters").value;                
                
                var request = new XMLHttpRequest();
                request.onreadystatechange = function() {
                    if (request.readyState === 4 && request.status === 200) {
                        var response = request.responseText;
                        alert (response);
                    }
                    console.log(response);
                };
                request.open("POST", "Enterbook.php", true);
                request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                request.send("&bookTitle="+bookTitle+"&subtitle="+subtitle+"&authors="+authors+"&isbn="+isbn+"&publisher="+publisher+"&edition="+edition+"&year="+year+"&chapters="+chapters);
            }
        </script>
        <form id="bookForm" action="#" method = "POST" onsubmit="return checkBook()">
            <table>
                <tr>
                    <td align="right"> Book Title: </td>
                    <td> <input class="title" type="text" name="bookTitle" id="bookTitle" autofocus/> </td>
                </tr>
                <tr>
                    <td align="right"> Subtitle: </td>
                    <td> <input class="textbox" type="text" name="subtitle" id="subtitle"/> </td>
                </tr>
                <tr>
                    <td align="right"> Authors: </td>
                    <td> <input class="textbox" type="text" name="authors" id="authors"/> </td>
                </tr>
                <tr>
                    <td align="right"> ISBN: </td>
                    <td> <input class="textbox" type="text" name="isbn" id="isbn"/> </td>
                </tr>
                <tr>
                    <td align="right"> Publisher: </td>
                    <td> <input class="textbox" type="text" name="publisher" id="publisher"/> </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td> &nbsp &nbsp &nbsp Edition:
                    <input size="4" type="text" name="edition" id="edition"/>
                    Year: <input align="left" size="4" type="text" name="year" id="year"/> 
                    Chapters: <input size="4" type="text" name="chapters" id="chapters"/> </td>
                </tr>
            </table>
            <input type = "submit" value="Enter" id="enter"/> &nbsp;
            <input type="button" value="Book-Off" onclick="window.location.href='Index.php'"/>
        </form>
<!--        <form method="LINK" ACTION="Index.php">
            <input type="submit" formaction="Index.php" value="Book-Off" />
        </form>-->
    </body>
</html>