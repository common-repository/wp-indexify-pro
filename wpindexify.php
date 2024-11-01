<?php
/*
  Plugin Name: WP Indexify PRO
  Plugin URI: http://www.visitmetrix.com/wordpress-indexing-plugin
  Description: Backlinks indexing is required for improving your web site's ranking in Google. This plugin submits your new pages and posts automatically to the leading backlink crawling and indexing services. Simply sign up at an individual service and add your API key into the settings section.
  Version: 2.0.1
  Author: Visit Metrix
  Author URI: http://visitmetrix.com
  License: GPLv2 or later
 */

global $options, $pluginApi, $LinksPerDay;
$nl = array();
$options = array_merge(get_option('onehourindexing_plugin_options', $nl), get_option('general_plugin_options', $nl), get_option('Linklicious_plugin_options', $nl), get_option('Linklicious_plugin_options', $nl), get_option('Indexification_plugin_options', $nl), get_option('Lindexed_plugin_options', $nl));

$LinksPerDay = "10";

include 'wpindexify_Options.php';
include 'wpindexify_widget.php';
include 'wpindexify_scud.php';

add_action('plugins_loaded', create_function('', '$onehourindexing_Options = new onehourindexing_Options;'));
add_action('onehourindexing_scheduled_send_hook', 'onehourindexing_scheduled');

function onehourindexing_scheduled() {
    onehourindexing_scheduled_send();
}

function cron_add_frq($schedules) {


    for ($index = 1; $index <= 24; $index++) {
        $schedules[$index . '_h'] = array('interval' => (60 * 60 * $index), 'display' => __($index . '_h'));
    }

    return $schedules;
}

add_filter('cron_schedules', 'cron_add_frq');

$back_up = get_option('options_back_up', $nl);



if ($options != $back_up) {
  
    onehourindexing_scheduled_send();

    wp_clear_scheduled_hook('onehourindexing_scheduled_send_hook');
    wp_schedule_event(time(), $options['api_frq'] . '_h', 'onehourindexing_scheduled_send_hook');

    update_option('options_back_up', $options);
}
?>