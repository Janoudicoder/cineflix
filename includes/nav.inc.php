<?php
$menu = array(
    'gast' => array(
        'Home' => 'home',
        'Movies' => 'movies',
        'login' => 'login',
    ),
    'gebruiker' => array(
        'Home' => 'home',   
        'Movies' => 'movies',
    ),
    'admin' => array(
        'Home' => 'home',
        'Movies' => 'movies',
        'zalen' => 'movies',
        'Add film' => 'add_movie',

    ),
);

echo '<nav class="navbar navbar-expand-lg navbar-dark bg-danger">';
echo '<a class="navbar-brand" href="index.php?page=home">MQM</a>';
echo '<ul class="navbar-nav ml-auto">';
foreach($menu[$user] as $label => $link ) {
    echo '<li class="nav-item">
            <a class="nav-link" href="index.php?page=' . $link . '">' . $label . '</a>
          </li>';
}
echo '</ul>';

if ($user != 'gast') {
  
    
    echo '<a class="nav-link text-white" href="php/logout.php"> 
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
            </svg>
          </a>';
}

echo '</div>';
echo '</nav>';
?>
