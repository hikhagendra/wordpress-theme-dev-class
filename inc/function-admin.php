<?php

// @package sunsettheme
//     =======================
//     ADMIN PAGE
//     =======================


function sunset_add_admin_page() {
    add_menu_page( 'Sunset Theme Options', 'Sunset', 'manage_options', 'khagendra_sunset', 'sunset_theme_create_page', get_template_directory_uri().'/img/sunset-icon.png', 110 );
    add_submenu_page( 'khagendra_sunset', 'Sunset Sidebar Options', 'Sidebar', 'manage_options', 'khagendra_sunset', 'sunset_theme_create_page');
    add_submenu_page( 'khagendra_sunset', 'Sunset Theme Options', 'Theme Options', 'manage_options', 'khagendra_sunset_theme', 'sunset_theme_support_page' );
    add_submenu_page( 'khagendra_sunset', 'Sunset Contact Form', 'Contact Form', 'manage_options', 'khagendra_sunset_theme_contact', 'sunset_contact_form_page' );
    add_submenu_page( 'khagendra_sunset', 'Sunset CSS Options', 'Custom CSS', 'manage_options', 'khagendra_sunset_css', 'sunset_theme_settings_page');

    // Activate Custom Settings
    add_action( 'admin_init', 'sunset_custom_settings' );
}

add_action( 'admin_menu', 'sunset_add_admin_page' );

function sunset_custom_settings() {
    // Sidebar Options
    register_setting( 'sunset-settings-group', 'profile_picture' );
    register_setting( 'sunset-settings-group', 'first_name' );
    register_setting( 'sunset-settings-group', 'last_name' );
    register_setting( 'sunset-settings-group', 'user_description' );
    register_setting( 'sunset-settings-group', 'twitter_handler', 'sunset_sanitize_twitter_handler' );
    register_setting( 'sunset-settings-group', 'facebook_handler' );
    register_setting( 'sunset-settings-group', 'gplus_handler' );

    add_settings_section( 'sunset-sidebar-options', 'Sidebar Options', 'sunset_sidebar_options', 'khagendra_sunset' );

    add_settings_field( 'sidebar-profile-picture', 'Profile Picture', 'sunset_sidebar_profile', 'khagendra_sunset', 'sunset-sidebar-options' );
    add_settings_field( 'sidebar-name', 'Full Name', 'sunset_sidebar_name', 'khagendra_sunset', 'sunset-sidebar-options' );
    add_settings_field( 'sidebar-description', 'Description', 'sunset_sidebar_description', 'khagendra_sunset', 'sunset-sidebar-options' );
    add_settings_field( 'sidebar-twitter', 'Twitter Handler', 'sunset_sidebar_twitter', 'khagendra_sunset', 'sunset-sidebar-options' );
    add_settings_field( 'sidebar-facebook', 'Facebook Handler', 'sunset_sidebar_facebook', 'khagendra_sunset', 'sunset-sidebar-options' );
    add_settings_field( 'sidebar-gplus', 'Google+ Handler', 'sunset_sidebar_gplus', 'khagendra_sunset', 'sunset-sidebar-options' );

    // Theme Support Options
    register_setting( 'sunset-theme-support', 'post_formats' );
    register_setting( 'sunset-theme-support', 'custom_header' );
    register_setting( 'sunset-theme-support', 'custom_background' );

    add_settings_section( 'sunset-theme-options', 'Theme Options', 'sunset_theme_options', 'khagendra_sunset_theme' );

    add_settings_field( 'post-formats', 'Post Formats', 'sunset_post_formats', 'khagendra_sunset_theme', 'sunset-theme-options' );
    add_settings_field( 'custom-header', 'Custom Header', 'sunset_custom_header', 'khagendra_sunset_theme', 'sunset-theme-options' );
    add_settings_field( 'custom-background', 'Custom Background', 'sunset_custom_background', 'khagendra_sunset_theme', 'sunset-theme-options' );

    // Contact Form Options
    register_setting( 'sunset-contact-options', 'activate_contact' );

    add_settings_section( 'sunset-contact-section', 'Contact Form', 'sunset_contact_section', 'khagendra_sunset_theme_contact' );
    
    add_settings_field( 'activate-form', 'Activate Contact Form', 'sunset_activate_contact', 'khagendra_sunset_theme_contact', 'sunset-contact-section' );

    // Custom CSS Options
    register_setting( 'sunset-custom-css-options', 'sunset_css', 'sunset_sanitize_custom_css' );
    
    add_settings_section( 'sunset-custom-css-section', 'Custom CSS', 'sunset_custom_css_section_callback', 'khagendra_sunset_css' );

    add_settings_field( 'custom-css', 'Insert Your Custom CSS', 'sunset_custom_css_callback', 'khagendra_sunset_css', 'sunset-custom-css-section' );
}

function sunset_custom_css_section_callback() {
    echo "Customize Sunset Theme with Your Own CSS";
}

function sunset_custom_css_callback() {
    $css = get_option( 'sunset_css' );
    $css = ( empty( $css ) ? ' /*Sunset Theme Custom CSS */ ' : $css );
    echo '<div id="customCss">'.$css.'</div><textarea id="sunset_css" name="sunset_css" style="display: none; visibility: hidden">' . $css . '</textarea>';
}

function sunset_theme_options() {
    echo "Activate and Deactivate the Built-in Contact Form";
}

function sunset_contact_section() {
    echo "Activate and Deactivate Specific Theme Support Options";
}

function sunset_post_formats() {
    $options = get_option( 'post_formats' );
    $formats = array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' );

    $output = '';
    foreach( $formats as $format ) {
        $checked = ( @$options[$format] == 1 ? 'checked' : '' );
        $output .= '<label><input type="checkbox" id="'.$format.'" name="post_formats['.$format.']" value="1" '.$checked.' />'.$format.'</label></br>';
    }

    echo $output;
}

function sunset_activate_contact() {
    $options = get_option( 'activate_contact' );
    $checked = ( @$options == 1 ? 'checked' : '' );
    echo '<label><input type="checkbox" id="activate_contact" name="activate_contact" value="1" '.$checked.' /></label></br>';
}

function sunset_custom_header() {
    $options = get_option( 'custom_header' );
    $checked = ( @$options == 1 ? 'checked' : '' );
    echo '<label><input type="checkbox" id="custom_header" name="custom_header" value="1" '.$checked.' />Activate the Custom Header</label></br>';
}

function sunset_custom_background() {
    $options = get_option( 'custom_background' );
    $checked = ( @$options == 1 ? 'checked' : '' );
    echo '<label><input type="checkbox" id="custom_background" name="custom_background" value="1" '.$checked.' />Activate the Custom Background</label></br>';
}

// Sidebar Options Functions
function sunset_sidebar_options() {
    echo 'Customize your sidebar information';
}

function sunset_sidebar_profile() {
    $picture = esc_attr(get_option( 'profile_picture' ));

    if ( empty($picture) ) {
        echo '<input type="button" class="button button-secondary" value="Upload Profile Picture" id="upload-button" />
          <input type="hidden" id="profile-picture" name="profile_picture" value="'.$picture.'"/>';
    } else {
        echo '<input type="button" class="button button-secondary" value="Replace" id="upload-button" />
          <input type="hidden" id="profile-picture" name="profile_picture" value="'.$picture.'"/> <input type="button" class="button button-secondary" value="Remove" id="remove-picture" />';
    }
}

function sunset_sidebar_name() {
    $firstName = esc_attr(get_option( 'first_name' ));
    $lastName = esc_attr(get_option( 'last_name' ));
    echo '<input type="text" name="first_name" value="'.$firstName.'" placeholder="First Name"> <input type="text" name="last_name" value="'.$lastName.'" placeholder="First Name">';
}

function sunset_sidebar_description() {
    $description = esc_attr(get_option( 'user_description' ));
    echo '<input type="text" name="user_description" value="'.$description.'" placeholder="Description"> <p class="description">Write something smart.</p>';
}

function sunset_sidebar_twitter() {
    $twitter = esc_attr(get_option( 'twitter_handler' ));
    echo '<input type="text" name="twitter_handler" value="'.$twitter.'" placeholder="Twitter Handler"> <p class="description">Input your Twitter username without @ character</p>';
}

function sunset_sidebar_facebook() {
    $facebook = esc_attr(get_option( 'facebook_handler' ));
    echo '<input type="text" name="facebook_handler" value="'.$facebook.'" placeholder="Facebook Handler">';
}

function sunset_sidebar_gplus() {
    $gplus = esc_attr(get_option( 'gplus_handler' ));
    echo '<input type="text" name="gplus_handler" value="'.$gplus.'" placeholder="Google+ Handler">';
}

// Sanitization Settings
function sunset_sanitize_twitter_handler($input) {
    $output = sanitize_text_field( $input );
    $output = str_replace('@', '', $output);
    return $output;
}

function sunset_sanitize_custom_css($input) {
    $output = esc_textarea( $input );
    return $output;
}

// Template submenu functions
function sunset_theme_create_page() {
    require_once( get_template_directory().'/inc/templates/sunset-admin.php');
}

function sunset_theme_support_page() {
    require_once( get_template_directory().'/inc/templates/sunset-theme-support.php');
}

function sunset_contact_form_page() {
    require_once( get_template_directory().'/inc/templates/sunset-contact-form.php');
}

function sunset_theme_settings_page() {
    require_once( get_template_directory().'/inc/templates/sunset-custom-css.php');
}