<?php
session_start();

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 'movies';
}
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
} else {
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <style>
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        .content {
            flex: 1;
        }
    </style>
</head>

<body>
    <?php include 'includes/nav.inc.php'; ?>
    <div class="container text-center">
        <?php if (isset($_SESSION['melding'])): ?>
            <div id="alertBox" class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['melding']; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <script>
                setTimeout(function() {
                    $('#alertBox').alert('close');
                }, 5000); 
            </script>
        <?php
        unset($_SESSION['melding']);
        endif;
        ?>
    </div>
    <div class="content">
        <?php include 'includes/' . $page . '.inc.php'; ?>
    </div>
    <footer class="bg-danger text-white text-center py-3">
        <p>&copy; 2024 Cinema MQM</p>
    </footer>
</body>
</html>