<?php /* Template Name: End user register */ ?>
<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

echo '<div class="login-user">';

echo do_shortcode('[gravityform id=35]');
    echo '</div>';




get_footer();


?>