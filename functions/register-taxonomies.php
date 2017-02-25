<?php

$ore_log_cpt = array('ore_log');

$log_type_labels = array(
    'name'              => _x( 'Log Types', 'taxonomy general name', 'sot' ),
    'singular_name'     => _x( 'Log Type', 'taxonomy singular name', 'sot' ),
    'search_items'      => __( 'Search Log Types', 'sot' ),
    'all_items'         => __( 'All Log Types', 'sot' ),
    'parent_item'       => __( 'Parent Log Type', 'sot' ),
    'parent_item_colon' => __( 'Parent Log Type:', 'sot' ),
    'edit_item'         => __( 'Edit Log Type', 'sot' ),
    'update_item'       => __( 'Update Log Type', 'sot' ),
    'add_new_item'      => __( 'Add New Log Type', 'sot' ),
    'new_item_name'     => __( 'New Log Type Name', 'sot' ),
    'menu_name'         => __( 'Log Types', 'sot' )
);

$log_type_args = array(
    'labels'                => $log_type_labels,
    'show_ui'               => true,
    'show_admin_column'     => true
);

register_taxonomy( 'log_type', $ore_log_cpt, $log_type_args);