<?php
header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once("./userrouter.php");
$method = isset($_POST['method']) ? $_POST['method'] : notexists();
if (function_exists($method)) {
    call_user_func($method);
} else {
    notexists();
}
function notexists()
{
    echo json_encode(array("retval" => -1));
}
function saveUser()
{
    $user = array(
        "studentid" => $_POST['studentid'],
        "fullname" => $_POST['fullname'],
        "course" => $_POST['course'],
        "gradesection" => $_POST['gradesection'],
        "age" => $_POST['age'],
        "username" => $_POST['username']
    );
    $ret = saveUsers($user);
    echo json_encode(array("ret" => $ret));
}
function readUser()
{
    $result = readUser();
    echo $result;
}
function updateUser()
{
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $studentid = isset($_POST['studentid']) ? $_POST['studentid'] : '';
    $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
    $gradesection = isset($_POST['gradesection']) ? $_POST['gradesection'] : '';
    $course = isset($_POST['course']) ? $_POST['course'] : '';
    $age = isset($_POST['age']) ? $_POST['age'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $user = array(
        "studentid" => $studentid,
        "fullname" => $fullname,
        "gradesection" => $gradesection,
        "course" => $course,
        "age" => $age,
        "username" => $username,
        "password" => $password
    );
    $ret = updateUsers($id, $user);
    echo json_encode(array("ret" => $ret));
}

function deleteUser()
{
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $ret = deleteUsersID($id);
    echo json_encode(array("ret" => $ret));
}
function checkLoginUser()
{
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $ret = checkLoginUsers($username, $password);
    echo json_encode(array("ret" => $ret));
}
function createNewUser()
{
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $ret = createNewUsers($username, $password);
    echo json_encode(array("ret" => $ret));
}
function checkUsername()
{
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $ret = checkUsersUsername($username);
    echo json_encode(array("ret" => $ret));
}
function checkUserStudentID()
{
    $studentid = isset($_POST['studentid']) ? $_POST['studentid'] : '';
    $ret = checkUsersStudentID($studentid);
    echo json_encode(array("ret" => $ret));
}
function checkUserFullName()
{
    $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
    $ret = checkUsersFullName($fullname);
    echo json_encode(array("ret" => $ret));
}
function checkUserEnrollment()
{
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $ret = checkUsersEnrollment($username);
    echo json_encode(array("ret" => $ret));
}
?>