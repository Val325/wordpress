<?php
session_start();
get_header();




error_reporting(E_ALL ^ E_WARNING); 
global $wp;
?>




<?php 


    $current = absint(
      max(
        1,
        get_query_var( 'paged' ) ? get_query_var( 'paged' ) : get_query_var( 'page' )
      )
    );
    $posts_per_page = 4;

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $posts_per_page,
        'paged'          => $current
    );

    $query = new WP_Query($args);


function santilize($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


// if user url is localhost
if (home_url( $wp->request ) == "http://localhost") {




    echo "<div class='posts'>";
    if ($query->have_posts() ) :
        while ( $query->have_posts() ) : $query->the_post();
            the_title( '<h1>', '</h1>' );
            echo '<span class="pub-date blacktext">'.get_the_date( 'j F, Y').'</span>';
            echo "<p class='post'>";
            if ( has_post_thumbnail() ) {
               echo "<div class='image_post'>";
               the_post_thumbnail('thumbnail');
               echo "</div>";
            } 

            the_content();
            echo "</p>";

            echo "<a class='linkpost' href=";
            the_permalink();
            echo ">Show post</a>"; 

        endwhile;
        echo '<br>';
        echo "<div class='pagination'>";
        wp_reset_postdata();
        echo wp_kses_post(
        paginate_links(
          [
            'total'   => $query->max_num_pages,
            'current' => $current,
          ])
        );
        echo '</div>';
    else:
        _e( 'Sorry, no pages matched your criteria.', 'textdomain' );
    endif;
    echo "</div>";
} elseif (home_url( $wp->request ) == "http://localhost/About") {

    echo "<h1 class='blacktext'>About</h1>";
    echo "<p class='blacktext'>...<p>";

} elseif (home_url( $wp->request ) == "http://localhost/user/registration") {

    echo "<h1 class='blacktext textcenter'>Registration</h1>";
    echo("<div class='form-container'>
        <form action='/user/registration' method='post'>
            <input type='text' name='login' placeholder='Email address or phone number'> <br>
            <input type='password' name='pass' placeholder='Password'> <br>
            <a href=>Forgotten password?</a> <br>
            <input type='submit' value='Registration'>
        </form>
    </div>");

    if (isset($_POST["login"]) && isset($_POST["pass"])) {

        echo "<p class='blacktext'> login: " . $_POST['login'] . '</p>';
        echo "<p class='blacktext'> password: " . $_POST['pass'] . '</p>';
        $userdata = array(
            'user_login' =>  $_POST['login'],
            'user_pass'  =>  $_POST['pass'] // When creating an user, `user_pass` is expected.
        );
        $user_id = wp_insert_user( $userdata ) ;
        /*echo "User created : ". $user_id;*/
        // On success.
        if ( ! is_wp_error( $user_id ) ) {

            $_SESSION["User"] = $_POST["login"];
            $_SESSION["isAuth"] = true;
            echo "<h1 class='blacktext textcenter'>User created : ". $user_id . "</h1>" ;
            wp_redirect( 'http://localhost' );
            exit;

        }

    }
} elseif (home_url( $wp->request ) == "http://localhost/user/login") {

    echo "<h1 class='blacktext textcenter'>Login</h1>";
    echo("<div class='form-container'>
        <form action='/user/login' method='post'>
            <input type='text' name='login' placeholder='Email address or phone number'> <br>
            <input type='password' name='pass' placeholder='Password'> <br>
            <a href=>Forgotten password?</a> <br>
            <input type='submit' value='Login'>
        </form>
    </div>");

    if (isset($_POST["login"]) && isset($_POST["pass"])) {
        echo "<p class='blacktext'> login: " . $_POST['login'] . '</p>';
        echo "<p class='blacktext'> password: " . $_POST['pass'] . '</p>';
    }

    $user = get_user_by( 'login', $_POST['login'] );

    if ( $user && wp_check_password( $_POST['pass'], $user->data->user_pass, $user->ID ) ) {
        echo "<h1 class='blacktext textcenter'>User exist</h1>";
        $_SESSION["User"] = $_POST["login"];
        $_SESSION["isAuth"] = true;
        wp_redirect( 'http://localhost' );
        exit;
    } else {
        echo "<h1 class='blacktext textcenter'>User not exist</h1>";
    }
    //echo "<h1 class='blacktext textcenter'>".  ."</h1>";
} elseif (home_url( $wp->request ) == "http://localhost/logout") {
    

    session_destroy();
    wp_redirect( 'http://localhost' );
    exit;
} else {
        echo "<div class='posts'>";
    if ($query->have_posts() ) :
        while ( $query->have_posts() ) : $query->the_post();
            the_title( '<h1>', '</h1>' );
            echo '<span class="pub-date blacktext">'.get_the_date( 'j F, Y').'</span>';
            echo "<p>";
            the_content();
            echo "</p>";

            echo "<a class='linkpost' href=";
            the_permalink();
            echo ">Show post</a>"; 

        endwhile;
        echo '<br>';
        echo "<div class='pagination'>";
        wp_reset_postdata();
        echo wp_kses_post(
        paginate_links(
          [
            'total'   => $query->max_num_pages,
            'current' => $current,
          ])
        );
        echo '</div>';
    else:
        _e( 'Sorry, no pages matched your criteria.', 'textdomain' );
    endif;
    echo "</div>";
}
wp_head();
?>