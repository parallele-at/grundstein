<?php

function magic_login_handle_form_submit_post() {
  if( !wp_verify_nonce( $_POST['nonce'], 'magic-login' ) ) {
    return 'nonce';
  }

  if ( !wp_get_current_user() && !isset( $_POST['password'] ) || !isset( $_POST['email'] ) ) {
    return 'invalid';
  }
}

function magic_login_form() {
  if ( $error = magic_login_handle_form_submit_post() ) {
    print($error);
    if ( str_contains( '?', $_SERVER['HTTP_REFERER'] ) ) {
      $ref = $_SERVER['HTTP_REFERER'] . '&error=' . $error;
    } else {
      $ref = $_SERVER['HTTP_REFERER'] . '?error=' . $error;
    }
    wp_redirect( $ref);
    exit;
  }

  if ( !username_exists( $_POST['email'] ) && !email_exists($_POST['email']) ) {
    wp_redirect( '/register?email=' . $_POST['email']);
    return;
  }

  $credentials = array(
    'user_login' => $_POST['email'],
    'user_password' => $_POST['password'],
    'remember' => isset($_POST['remember']) ? $_POST['remember'] : false,
  );

  $signon = wp_signon( $credentials );

  wp_redirect( '/profile' );
}

add_action( 'admin_post_nopriv_login_form', 'magic_login_form' );
add_action( 'admin_post_login_form', 'magic_login_form' );
