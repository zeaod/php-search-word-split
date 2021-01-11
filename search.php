<?php


$dbServername = "localhost";

$dbUsername = "root";

$dbPassword = "";

$dbName = "mou_namelist";

$conn = mysqli_connect ($dbServername, $dbUsername, $dbPassword, $dbName);

?>



<div class="border_search container"> 

<div class="row">

<div class="col-lg-6 offset-lg-3">

<?php

$text_cut_eng = $_POST['ccc'];

$eng = '/[a-z,A-Z]/'; 

$cut_done = preg_replace($eng,'', $text_cut_eng);  

$text_to_segment = trim($cut_done);

include(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'THSplitLib/segment.php');

$segment = new Segment(); 

$key_cut = $segment->get_segment_array($text_to_segment);

$keyword_serchmore = implode(' ', $key_cut); //สำหรับ searchmore

$keyword = implode(' ', $key_cut); 

$wordsAry = explode(" ", $keyword);

function highlightKeywords($text, $keyword) {

    $wordsAry = explode(" ", $keyword);

    $wordsCount = count($wordsAry);    

    for($i=0;$i<$wordsCount;$i++) {

      $highlighted_text = "<span style='background-color:#4dffff;'>$wordsAry[$i]</span>";

      $text = str_ireplace($wordsAry[$i], $highlighted_text, $text);

    }

    return $text;

}

?>
 

<?php

    $wordsCount = count($wordsAry);

    //กำหนด condition สำหรับค้นหา
    $queryCondition = " WHERE ";
        for($i=0;$i<$wordsCount;$i++) {
        $queryCondition .= "ccc LIKE '%" . $wordsAry[$i] . "%'";
            if($i != $wordsCount-1) {
                $queryCondition .= " OR ";
            }
        } 

  $sql = "SELECT * FROM namelist_tb " . $queryCondition . " ORDER BY id DESC limit 0,129";

  $result = mysqli_query($conn,$sql); 

while ($row = mysqli_fetch_assoc($result)) { 
    $foundname = highlightKeywords($row["ccc"],$keyword);
 
}

$data = "<div style='text-align:center;margin:3rem;'>";
$data .= $foundname."<hr>";
$data .= "</div>";

echo $data;
?>
 