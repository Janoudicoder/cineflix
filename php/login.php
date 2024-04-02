<?php
session_start();

require '../private/conn.php';

if (isset($_POST['email']) && isset($_POST['password'])) 
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = 'SELECT u.user_id, u.password, r.role_name 
            FROM users u 
            INNER JOIN role r ON u.role_id = r.role_id 
            WHERE u.email = :email';
    $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute(array(':email' => $email));

    $matchingUsers = $sth->fetchAll(PDO::FETCH_ASSOC);

    if (count($matchingUsers) > 0)
    {
        foreach ($matchingUsers as $rsUser)
        {
            if ($password == $rsUser['password'])
            {
                $_SESSION['user_id'] = $rsUser['id'];

                if (isset($rsUser['role_name']))
                {
                    if ($rsUser['role_name'] == 'admin')
                    {
                        $_SESSION['user'] = 'admin';

                        header('location: ../index.php?page=admin_dashboard');
                        exit();
                    }
                    else if ($rsUser['role_name'] == 'user')
                    {
                        $_SESSION['user'] = 'gebruiker';
                        header('location: ../index.php?page=movies');
                        exit();
                    }
                } else
                {
                    $_SESSION['medling'] = 'User type not found';
                    header('location: ../index.php?page=login');
                    exit();
                }
            }
        }

        $_SESSION['medling'] = 'Wrong password';
        header('location: ../index.php?page=login');
        exit();
    }
    else
    {
        $_SESSION['medling'] = 'Incorrect username';
        header('location: ../index.php?page=login');
        exit();
    }
} else
{
    $_SESSION['medling'] = 'Username and password are required.';
    header('location: ../index.php?page=login');
    exit();
}
