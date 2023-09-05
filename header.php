<?php 
wp_head();
if ($_SESSION["isAuth"]){
    get_template_part('template/headerLogin');
}else{
    get_template_part('template/headerRegister');
}
?>