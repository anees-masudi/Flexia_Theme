<?php /* Template Name: End user login */ ?>
<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>
<style>
.login-user {
    
  /* Center child horizontally*/
  display: flex;
  justify-content: center;
}
nav.gf_login_links {
    display: none;
}
</style>
<?php

echo '<div class="login-user">';

echo do_shortcode('[gravityform action="login" description="false" logged_in_message="Yay! You are logged in!"  login_redirect="https://wake.runnerscamp.org/user-dashboard/" logout_redirect="https://wake.runnerscamp.org/user-login/" /]');
    echo '</div>';

        


if ( is_user_logged_in() ) {
    wp_redirect( get_permalink(16772) ); // redirect to dashboard page
    exit;
} 



get_footer();


?>