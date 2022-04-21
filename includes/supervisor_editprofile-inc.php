<?php
session_start();

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['researchAreas'])) {
    require_once 'connection-inc.php';

    $data = [];
    $errors = [];

    if (empty($_POST['name'])) {
        $errors['name'] = "Name is a required field.";
    }

    if (empty($_POST['email'])) {
        $errors['email'] = "Email is a required field.";
    }

    if (empty($_POST['researchAreas'])) {
        $errors['researchAreas'] = "Research area(s) is a required field.";
    }

    if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['researchAreas'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $researchAreas = $_POST['researchAreas'];
        $proposedTopics = $_POST['proposedTopics'];
        $description = $_POST['description'];
        $supervisorID = $_SESSION['userID'];

        $sql = "UPDATE supervisor_details SET name = ?, email = ?, research_area = ?, proposed_topics = ?, description = ? WHERE supervisorID = ?";
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindParam(1, $name, PDO::PARAM_STR);
            $stmt->bindParam(2, $email, PDO::PARAM_STR);
            $stmt->bindParam(3, $researchAreas, PDO::PARAM_STR);
            $stmt->bindParam(4, $proposedTopics, PDO::PARAM_STR);
            $stmt->bindParam(5, $description, PDO::PARAM_STR);
            $stmt->bindParam(6, $supervisorID, PDO::PARAM_STR);

            $stmt->execute();
        } catch (PDOException $e) {
            $errors['sql'] = $e->getMessage();
        }
    }

    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;
    } else {
        $data['success'] = true;
        $data['message'] = 'Success';
    }

    echo json_encode($data);
} else {
    header("location: ../profile.php?id=" . $_SESSION['userID']);
    exit();
}
