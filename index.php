<?php
session_start();

if (isset($_GET['page']))
{
    $page = $_GET['page'];
}
else
{
    $page = 'home';
}
if(isset($_SESSION['user']))
{
    $user = $_SESSION['user'];
}
else
{
    $user = 'gast';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cinema Home</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="style.css" rel="stylesheet">

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<?php
include 'includes/nav.inc.php';     




include 'includes/' . $page . '.inc.php';
?>
 <footer class="bg-danger text-white text-center py-3 mt-5">
    <p>&copy; 2024 Cinema Home</p>
  </footer>
</body>
</html>