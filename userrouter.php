<?php
require_once("./dbcontroller.php");
function saveUsers($users)
{
    $db = new DbController();
    if ($db->getState() == true) {
        $con = $db->getDb();
        $sql = "INSERT INTO studentenrollment (studentid,fullname,age,gradesection,course) VALUES(:studentid,:fullname,:age,:gradesection,:course)";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":studentid", $users['studentid']);
        $stmt->bindParam(":fullname", $users['fullname']);
        $stmt->bindParam(":age", $users['age']);
        $stmt->bindParam(":gradesection", $users['gradesection']);
        $stmt->bindParam(":course", $users['course']);
        $stmt->execute();
        if ($stmt) {
            return 1;
        } else {
            return 0;
        }
    }
}
function readUsers()
{
    try {
        $db = new DbController();
        if ($db->getState() == true) {
            $conn = $db->getDb();
            $sql = "SELECT * FROM studentenrollment";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($users) {
                echo json_encode(array("retval" => 1, "users" => $users));
            } else {
                echo json_encode(array("retval" => 0, "message" => "No enrolled students found."));
            }
        } else {
            echo json_encode(array("retval" => 0, "message" => "Failed to connect to the database"));
        }
    } catch (Exception $e) {
        echo json_encode(array("retval" => -1, "message" => "Error: " . $e->getMessage()));
    }
}
function updateUsers($id, $users)
{
    $db = new DbController();
    if ($db->getState() == true) {
        $con = $db->getDb();
        $sql = "UPDATE studentenrollment SET studentid = :studentid, fullname = :fullname, age = :age, gradesection = :gradesection, course = :course WHERE id = :id";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":studentid", $users['studentid']);
        $stmt->bindParam(":fullname", $users['fullname']);
        $stmt->bindParam(":age", $users['age']);
        $stmt->bindParam(":gradesection", $users['gradesection']);
        $stmt->bindParam(":course", $users['course']);
        $stmt->execute();
        if ($stmt) {
            return 1;
        } else {
            return 0;
        }
    }
}
?>