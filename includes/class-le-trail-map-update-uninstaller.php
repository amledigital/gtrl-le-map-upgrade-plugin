<?php 


class LE_Trail_Map_Update_Uninstaller {

    public static function uninstall() {
        global $wpdb;
        $wpdb->query('SET FOREIGN_KEY_CHECKS = 0;');
        self::dropActivityJoinTable();
        self::dropActivityTable();
        self::dropTrailHeadJoinTable();
        self::dropTrailHeadTable();
        self::dropPropertyCountyJoinTable();
        self::dropPropertyCounties();
        self::dropPropertyTypeJoinTable();
        self::dropPropertyTypeTable();
        self::dropTrailTable();
        $wpdb->query('SET FOREIGN_KEY_CHECKS = 1;');
        wp_cache_flush();
    }

    private static function dropTable($table_name) {
        global $wpdb;
        $wpdb->query("DROP TABLE IF EXISTS $table_name");
    }

    public static function dropTrailTable() {
        self::dropTable($GLOBALS['wpdb']->prefix . 'properties');
    }

    public static function dropPropertyTypeTable() {
        self::dropTable($GLOBALS['wpdb']->prefix . 'property_types');
    }

    public static function dropPropertyTypeJoinTable() {
        self::dropTable($GLOBALS['wpdb']->prefix . 'property_type_joins');
    }

    public static function dropPropertyCounties() {
        self::dropTable($GLOBALS['wpdb']->prefix . 'property_counties');
    }

    public static function dropPropertyCountyJoinTable() {
        self::dropTable($GLOBALS['wpdb']->prefix . 'property_county_joins');
    }

    public static function dropTrailHeadTable() {
        self::dropTable($GLOBALS['wpdb']->prefix . 'property_trailheads');
    }

    public static function dropTrailHeadJoinTable() {
        self::dropTable($GLOBALS['wpdb']->prefix . 'property_trailhead_joins');
    }

    public static function dropActivityTable() {
        self::dropTable($GLOBALS['wpdb']->prefix . 'property_activities');
    }

    public static function dropActivityJoinTable() {
        self::dropTable($GLOBALS['wpdb']->prefix . 'property_activity_joins');
    }
}