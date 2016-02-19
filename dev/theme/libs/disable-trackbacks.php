<?php

/**
 * Disables trackbacks/pingbacks
 *
 * You can enable/disable this feature in functions.php (or lib/setup.php if you're using Sage):
 * add_theme_support('soil-disable-trackbacks');
 */

/**
 * Disable pingback XMLRPC method
 */
function filter_xmlrpc_method($methods) {
  unset($methods['pingback.ping']);
  return $methods;
}
add_filter('xmlrpc_methods', 'filter_xmlrpc_method', 10, 1);

/**
 * Remove pingback header
 */
function filter_headers($headers) {
  if (isset($headers['X-Pingback'])) {
    unset($headers['X-Pingback']);
  }
  return $headers;
}
add_filter('wp_headers', 'filter_headers', 10, 1);

/**
 * Kill trackback rewrite rule
 */
function filter_rewrites($rules) {
  foreach ($rules as $rule => $rewrite) {
    if (preg_match('/trackback\/\?\$$/i', $rule)) {
      unset($rules[$rule]);
    }
  }
  return $rules;
}
add_filter('rewrite_rules_array', 'filter_rewrites');

/**
 * Kill bloginfo('pingback_url')
 */
function kill_pingback_url($output, $show) {
  if ($show === 'pingback_url') {
    $output = '';
  }
  return $output;
}
add_filter('bloginfo_url', 'kill_pingback_url', 10, 2);

/**
 * Disable XMLRPC call
 */
function kill_xmlrpc($action) {
  if ($action === 'pingback.ping') {
    wp_die('Pingbacks are not supported', 'Not Allowed!', ['response' => 403]);
  }
}
add_action('xmlrpc_call', 'kill_xmlrpc');
