<?php 
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function alert_back($data)
{
    echo "<script>alert('$data');history.go(-1);</script>";
    exit;
}
?>