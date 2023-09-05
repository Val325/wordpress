<?php 
echo "<h1>User: " .$_SESSION["User"]. "</h1>";
wp_nav_menu(array(
    'menu_class' => 'horizontal-menu', // Класс для стилизации меню
))

?>