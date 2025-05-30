<?php
require_once("./dbcontroller.php");
function saveUsers($users)
{
    $db = new DbController();
    if ($db->getState() == true) {
        $con = $db->getDb();
        $sql = "UPDATE studentenrollment SET studentid = :studentid, fullname = :fullname, gradesection = :gradesection, course = :course, age = :age WHERE username = :username";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":studentid", $users['studentid']);
        $stmt->bindParam(":fullname", $users['fullname']);
        $stmt->bindParam(":gradesection", $users['gradesection']);
        $stmt->bindParam(":course", $users['course']);
        $stmt->bindParam(":age", $users['age']);
        $stmt->bindParam(":username", $users['username']);
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

        $stmt = $con->prepare("SELECT password FROM studentenrollment WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        $currentPassword = $existing ? $existing['password'] : '';

        // Use existing password if new one is not provided
        $passwordToSave = !empty($users['password']) ? $users['password'] : $currentPassword;

        $sql = "UPDATE studentenrollment 
                SET studentid = :studentid, 
                    fullname = :fullname, 
                    gradesection = :gradesection, 
                    course = :course, 
                    age = :age, 
                    username = :username, 
                    password = :password 
                WHERE id = :id";

        $stmt = $con->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":studentid", $users['studentid']);
        $stmt->bindParam(":fullname", $users['fullname']);
        $stmt->bindParam(":gradesection", $users['gradesection']);
        $stmt->bindParam(":course", $users['course']);
        $stmt->bindParam(":age", $users['age']);
        $stmt->bindParam(":username", $users['username']);
        $stmt->bindParam(":password", $passwordToSave);
        $stmt->execute();

        return $stmt ? 1 : 0;
    }
}

function deleteUsersID($id)
{
    $id = $_POST['id'];
    try {
        $db = new DbController();
        if ($db->getState() == true) {
            $conn = $db->getDb();
            $stmt = $conn->prepare("DELETE FROM studentenrollment WHERE id = :id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $stmt = $conn->prepare("SET @id := 0; UPDATE studentenrollment SET id = (@id := @id + 1)");
            $stmt->execute();
            $stmt = $conn->prepare("ALTER TABLE studentenrollment AUTO_INCREMENT = 1");
            $stmt->execute();
            if ($stmt) {
                return 1;
            } else {
                return 0;
            }
        }
    } catch (Exception $e) {
        echo json_encode(array("retval" => -1, "message" => "Error: " . $e->getMessage()));
    }
}
function checkLoginUsers($username, $password)
{
    $db = new DbController();
    if ($db->getState() == true) {
        $con = $db->getDb();
        $sql = "SELECT * FROM studentenrollment WHERE username = :username AND password = :password";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $password);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            return true;
        } else {
            return false;
        }
    }
}
function createNewUsers($username, $password)
{
    $db = new DbController();
    if ($db->getState() == true) {
        $con = $db->getDb();
        $sql = "INSERT INTO studentenrollment (username, password) VALUES (:username, :password)";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $password);
        $stmt->execute();
        if ($stmt) {
            return 1;
        } else {
            return 0;
        }
    }
}
function checkUsersUsername($username)
{
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $db = new DbController();
    if ($db->getState() == true) {
        $con = $db->getDb();
        $sql = "SELECT * FROM studentenrollment WHERE username = :username";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            return true;
        } else {
            return false;
        }
    }
}
function checkUsersStudentID($studentid)
{
    $studentid = isset($_POST['studentid']) ? $_POST['studentid'] : '';
    $db = new DbController();
    if ($db->getState() == true) {
        $con = $db->getDb();
        $sql = "SELECT * FROM studentenrollment WHERE studentid = :studentid";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":studentid", $studentid);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            return true;
        } else {
            return false;
        }
    }
}
function checkUsersFullName($fullname)
{
    $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
    $db = new DbController();
    if ($db->getState() == true) {
        $con = $db->getDb();
        $sql = "SELECT * FROM studentenrollment WHERE fullname = :fullname";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":fullname", $fullname);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            return true;
        } else {
            return false;
        }
    }
}
function checkUsersEnrollment($username)
{
    $db = new DbController();
    if ($db->getState() == true) {
        $con = $db->getDb();
        $sql = "SELECT * FROM studentenrollment WHERE username = :username 
                AND studentid IS NOT NULL AND TRIM(studentid) <> ''
                AND fullname IS NOT NULL AND TRIM(fullname) <> ''
                AND course IS NOT NULL AND TRIM(course) <> ''
                AND gradesection IS NOT NULL AND TRIM(gradesection) <> ''
                AND age IS NOT NULL AND TRIM(age) <> ''";

        $stmt = $con->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ? true : false;
    }
    return false;
}
?>