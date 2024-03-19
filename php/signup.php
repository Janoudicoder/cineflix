<?php
session_start();
require '../private/conn.php';

if (isset($_POST['register']))
{
    $firstname = $_POST['first_name'];
    $lastname = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $birth_date = $_POST['birth_date'];

    // Password validation
    $uppercase = preg_match('@[A-Z]@', $password);
    $numbers = preg_match('@[0-9]{2,}@', $password);

    // Check if birth date is greater than 16 years ago
    $currentDate = new DateTime();
    $userBirthDate = new DateTime($birth_date);
    $minBirthDate = $currentDate->modify('-16 years');

    if ($password === $confirm_password && $uppercase && $numbers && strlen($password) >= 8 && $userBirthDate <= $minBirthDate)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Get the role ID for 'user' from the 'role' table
        $userRoleQuery = "SELECT role_id FROM role WHERE role_name = 'user'";
        $userRoleStmt = $dbh->prepare($userRoleQuery);
        $userRoleStmt->execute();
        $userRoleID = $userRoleStmt->fetchColumn();

        // Insert user with the default 'user' role
        $sql = "INSERT INTO users (first_name, last_name, email, password, birth_date, role_id) VALUES (:first_name, :last_name, :email, :password, :birth_date, :role_id)";
        $stmt = $dbh->prepare($sql);
        $data = [
            ':first_name' => $firstname,
            ':last_name' => $lastname,
            ':email' => $email,
            ':password' => $hashedPassword,
            ':birth_date' => $birth_date,
            ':role_id' => $userRoleID,
        ];
        $stmt->execute($data);

        header('Location: ../index.php?page=login');
        exit();
    } else
    {
        $_SESSION['melding'] = "Password and Confirm Password do not match, or do not meet the specified criteria, or the birth date is not greater than 16 years. Please try again.";
        header('Location: ../index.php?page=login');
        exit();
    }
}
?>
