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
        "age" => $_POST['age'],
        "gradesection" => $_POST['gradesection'],
        "course" => $_POST['course']
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
    $age = isset($_POST['age']) ? $_POST['age'] : '';
    $gradesection = isset($_POST['gradesection']) ? $_POST['gradesection'] : '';
    $course = isset($_POST['course']) ? $_POST['course'] : '';
    $user = array(
        "studentid" => $studentid,
        "fullname" => $fullname,
        "age" => $age,
        "gradesection" => $gradesection,
        "course" => $course
    );
    $ret = updateUsers($id, $user);
    echo json_encode(array("ret" => $ret));
}
function deleteUser()
{
    $userId = $_POST['id'];
    try {
        $db = new DbController();
        if ($db->getState() == true) {
            $conn = $db->getDb();
            $stmt = $conn->prepare("DELETE FROM studentenrollment WHERE id = :id");
            $stmt->bindParam(":id", $userId);
            $stmt->execute();
            $stmt = $conn->prepare("SET @id := 0; UPDATE studentenrollment SET id = (@id := @id + 1)");
            $stmt->execute();
            $stmt = $conn->prepare("ALTER TABLE studentenrollment AUTO_INCREMENT = 1");
            $stmt->execute();
            echo json_encode(array("retval" => 1, "message" => "User deleted successfully!"));
        } else {
            echo json_encode(array("retval" => 0, "message" => "Failed to connect to the database"));
        }
    } catch (Exception $e) {
        echo json_encode(array("retval" => -1, "message" => "Error: " . $e->getMessage()));
    }
}
?>