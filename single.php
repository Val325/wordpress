<?php
session_start();
get_header();
?>

<?php 
/*
wp_nav_menu(array(
    'menu_class' => 'horizontal-menu', // Класс для стилизации меню
))
*/
?>

<?php
	echo "<div class='posts'>";
    the_title( '<h1>', '</h1>' );

    echo '<span class="pub-date blacktext">'.get_the_date( 'j F, Y').'</span>';  
    if ( has_post_thumbnail() ) {
        the_post_thumbnail('thumbnail');
    } 
    the_content();
    echo "</div>";
?>