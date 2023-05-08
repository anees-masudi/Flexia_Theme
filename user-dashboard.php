<?php /* Template Name: User Dashboard */ ?>
<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;
get_header(); 
$user_ID = get_current_user_id(); 
$user_meta = get_userdata($user_ID);
 $user_roles = $user_meta->roles;
  if( current_user_can('basic_contributor') || current_user_can('administrator') ) {  
//if ( in_array( 'basic_contributor', 'administrator', (array) $user_roles[0] , (array) $user_roles[1]) && is_user_logged_in() ) {
?>
<div id="content" class="site-content">
    <div class="flexia-wrapper flexia-blank-container">
        <div id="primary" class="content-area">
            <main id="main" class="site-main flexia-container">
            <style>
body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.product-box{
  width: 400px;
  background: #f3f3f3;
  border-radius: 10px;
  padding: 50px;
  margin: 20px;
  display: inline-block;
}
.product-box:hover
{    
  box-shadow: 0 0 11px rgb(33 33 33 / 20%);
}
.product-h{
  text-align: center;
    font-size: 26px;
}
.btn-edit{
  background-color: #1958a0; 
  border: none;
  color: white;
  padding: 10px 40px;
    width: 100%;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
}
.btn-link{
  font-size: 1em;
    color: white;
}
.btn-hide{
  cursor:pointer;
  float: right;
}



.topnav {
  overflow: hidden;
  background-color: #ffff;
  margin-top: 40px;
  display: flex;
    justify-content: center;
}


</style>
</head>
<body>
  
      <?php  
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 10,
        'product_cat'    => 'camp'
    );

    $loop = new WP_Query( $args );

    while ( $loop->have_posts() ) : $loop->the_post();
        global $product;
        $id = $product->get_id();
        $home_url   = get_home_url(); 
        $product_edit_url  = $home_url . '/wp-admin/post.php?post='.$id.'&action=edit'; 

        
        echo '<div class="product-box" id="product-box-1">
        <br />'.woocommerce_get_product_thumbnail();
       
        

        echo '<br /><h1 class="product-h">'.get_the_title().'</h1>';
        echo '<br /><button class= "btn-edit" id="show-iframe-'.$id.'" >Edit</button>';
       

       echo '</div>';

       echo '<div id="eniro" style="display:none">

       <div class="topnav">
 
      <button id="camp-settings" >Camp Settings</button>
      <button id="registration" >Registration</button>
      <button id="waitlist" >Waitlist</button>
      <button id="reports" >Reports</button>
      <button id="camp-setup" >Camp Setup</button>
      <button id="shortcodes" >Shortcodes</button>
      <button id="new-camp-setup" >Add Camp</button>
      <button id="add-coupon" >Add Coupon</button>
      <button id="edit-user" >Profile</button>

      </div>

       <br /><iframe id="settingIframe" class="iframe-placeholder" src="'.$home_url.'/wp-admin/admin.php?page=rc_settings" style="background:#fff; height:3100px; width:100%; margin-top: -22px;" frameborder="0" scrolling="no" ></iframe>
      
        
       </div>';

    endwhile;

    wp_reset_query();
?>


    </div>
   </main><!-- #main -->
        </div><!-- #primary -->


    </div><!-- #flexia-wrapper -->
</div><!-- #content -->
</div>
<?php  $camp_product = get_option('rc_product_id');  ?>
  <script>
    jQuery("[id^=show-iframe-]").click(function() {
      console.log('edit click');
      var iframe = jQuery("#settingIframe");
      iframe.attr("src", iframe.data("src"));
      jQuery("#eniro").css("display", "block");
      jQuery("#product-box-1").css("display", "none");

      jQuery("#settingIframe").css("height", "3051px");
      jQuery("#settingIframe").css("width", "100%");

    });

    jQuery('#registration').bind('click', function() {
    var siteUrl = document.location.origin;
    //console.log("document.location.origin : "+siteUrl);
      var iframe = jQuery("#settingIframe");
      iframe.attr("src", siteUrl+"/wp-admin/admin.php?page=rc_registrations");
    // iframe.src="https://runerscamp.staging-server.online/wp-admin/admin.php?page=rc_waitlist"

    });

    jQuery('#reports').bind('click', function() {
      var siteUrl = document.location.origin;
      var iframe = jQuery("#settingIframe");
      iframe.attr("src", siteUrl+"/wp-admin/admin.php?page=rc_reports");

    });

    jQuery('#shortcodes').bind('click', function() {
      var siteUrl = document.location.origin;
      var iframe = jQuery("#settingIframe");
      iframe.attr("src", siteUrl+"/wp-admin/admin.php?page=rc_shortcodes");

    });

    jQuery('#waitlist').bind('click', function() {
      var siteUrl = document.location.origin;
      var iframe = jQuery("#settingIframe");
      iframe.attr("src", siteUrl+"/wp-admin/admin.php?page=rc_waitlist");

    });

    jQuery('#camp-setup').bind('click', function() {
		 var proid = "<?php echo $camp_product; ?>";
      var siteUrl = document.location.origin;
      var iframe = jQuery("#settingIframe");
      iframe.attr("src", siteUrl+"/wp-admin/post.php?post="+proid+"&action=edit");

    });

    jQuery('#new-camp-setup').bind('click', function() {
      var siteUrl = document.location.origin;
      var iframe = jQuery("#settingIframe");
      iframe.attr("src", siteUrl+"/wp-admin/post.php?action=edit&post=17023");

    });
    jQuery('#add-coupon').bind('click', function() {
      var siteUrl = document.location.origin;
      var iframe = jQuery("#settingIframe");
      iframe.attr("src", siteUrl+"/wp-admin/post-new.php?post_type=shop_coupon");

    });


    jQuery('#camp-settings').bind('click', function() {
      var siteUrl = document.location.origin;
      var iframe = jQuery("#settingIframe");
      iframe.attr("src", siteUrl+"/wp-admin/admin.php?page=rc_settings");

    });

    jQuery('#edit-user').bind('click', function() {
      var siteUrl = document.location.origin;
      var iframe = jQuery("#settingIframe");
      iframe.attr("src", siteUrl+"/wp-admin/profile.php");

    });

    jQuery('iframe').on("load reload", function(e) {
        //console.log(e.type, this)
        var h = this.contentWindow.document.body.scrollHeight
        var w = this.contentWindow.document.body.scrollWidth
        jQuery(this).css({
          height: "",
          width: "100%"
        })
        var h1 = this.contentWindow.document.body.scrollHeight
        var w1 = this.contentWindow.document.body.scrollWidth
        jQuery(this).css({
          height: h,
          width: w
        }).animate({
          height: h1,
          width: w1
        }, 300, function() {
          //console.log(["animated", h, w, h1, w1])
          parent.$ && parent.jQuery('iframe').trigger('reload');
        })
      })


    jQuery('#hide-iframe').click(function() {
    
      jQuery("#eniro").css("display", "none");
      jQuery("#product-box-1").css("display", "block");

    });

  </script>

<!-- #page -->

<?php
}
else{
  wp_logout();
  wp_redirect( home_url()); // redirect to login page
  exit;
}
get_footer();

?>