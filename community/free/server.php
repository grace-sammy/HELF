<?php
// connect to database
// session_start();
// include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/db_connector.php";
// $con = mysqli_connect('localhost', 'root', '123456', 'helf');
include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/common_func.php";

if (!$conn) {
    die("Error connecting to database: " . mysqli_connect_error($conn));
    exit();
}
if(!isset($_SESSION['user_id'])){
  echo "<script>alert('권한이 없습니다.');history.go(-1);</script>";
  exit;
}

$user_id = $_SESSION['user_id'];


// echo "<script>alert('server.php에서 접속한 게시판 아이디{$num}, 접속아이디: {$_SESSION['user_id']} ');</script>";

// 사용자가 좋아요 혹은 싫어요 버튼을 눌렀을 경우
if (isset($_POST['action'])) {
    $post_id = $_POST['post_id'];
    // echo "<script>alert('{$post_id}');</script>";
    $action = $_POST['action'];
    switch ($action) {
    case 'like':
         $sql="INSERT INTO rating_community_info (user_id, post_id, rating_action, b_code)
               VALUES ('$user_id', $post_id, 'like','자유게시판')
               ON DUPLICATE KEY UPDATE rating_action='like'";
         break;
    case 'dislike':
          $sql="INSERT INTO rating_community_info (user_id, post_id, rating_action, b_code)
               VALUES ('$user_id', $post_id, 'dislike', '자유게시판')
               ON DUPLICATE KEY UPDATE rating_action='dislike'";
         break;
    case 'unlike':
          $sql="DELETE FROM rating_community_info WHERE user_id='$user_id' AND post_id=$post_id AND b_code='자유게시판'";
          break;
    case 'undislike':
            $sql="DELETE FROM rating_community_info WHERE user_id='$user_id' AND post_id=$post_id AND b_code='자유게시판'";
      break;
    default:
        break;
  }

    // execute query to effect changes in the database ...
    mysqli_query($conn, $sql);
    echo getRating($post_id);
    exit(0);
}

// Get total number of likes for a particular post
function getLikes($id, $num)
{
    global $conn;
    // $id=(int)$id;
    $sql = "SELECT COUNT(*) FROM rating_community_info
          WHERE b_code='자유게시판' and post_id = $id AND rating_action='like'";
    $rs = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($rs);

    $sql2 = "UPDATE community SET likeit=$result[0] WHERE b_code='자유게시판' and num=$num;";
    mysqli_query($conn, $sql2);
    return $result[0];
}

// Get total number of dislikes for a particular post
function getDislikes($id)
{
    global $conn;
    $sql = "SELECT COUNT(*) FROM rating_community_info
          WHERE b_code='자유게시판' and post_id = $id AND rating_action='dislike'";
    $rs = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($rs);
    return $result[0];
}

// Get total number of likes and dislikes for a particular post
function getRating($id)
{
    global $conn;
    $rating = array();
    $likes_query = "SELECT COUNT(*) FROM rating_community_info WHERE b_code='자유게시판' and post_id = $id AND rating_action='like'";
    $dislikes_query = "SELECT COUNT(*) FROM rating_community_info
                 WHERE b_code='자유게시판' and post_id = $id AND rating_action='dislike'";
    $likes_rs = mysqli_query($conn, $likes_query);
    $dislikes_rs = mysqli_query($conn, $dislikes_query);
    $likes = mysqli_fetch_array($likes_rs);
    $dislikes = mysqli_fetch_array($dislikes_rs);
    $rating = [
    'likes' => $likes[0],
    'dislikes' => $dislikes[0]
  ];
    return json_encode($rating);
}

// Check if user already likes post or not
function userLiked($post_id)
{
    global $conn;
    global $user_id;
    $sql = "SELECT * FROM rating_community_info WHERE user_id='$user_id'
          AND b_code='자유게시판' and post_id=$post_id AND rating_action='like'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

// Check if user already dislikes post or not
function userDisliked($post_id)
{
    global $conn;
    global $user_id;
    $sql = "SELECT * FROM rating_community_info WHERE b_code='자유게시판' and user_id='$user_id'
          AND post_id=$post_id AND rating_action='dislike'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

$num = test_input($_GET["num"]);

$sql = "SELECT * FROM community where b_code='자유게시판' and num=$num"; //게시판 번호
$result_com = mysqli_query($conn, $sql);
// fetch all community from database
// return them as an associative array called $communities
$communities = mysqli_fetch_all($result_com, MYSQLI_ASSOC);
// $communities는 array로 리턴


?>
