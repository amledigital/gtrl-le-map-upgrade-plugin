<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    LE_Trail_Map_Update
 * @subpackage LE_Trail_Map_Update/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    LE_Trail_Map_Update
 * @subpackage LE_Trail_Map_Update/includes
 * @author     Your Name <email@example.com>
 */
class LE_Trail_Map_Update_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		self::createTrailTable();
		self::createPropertyTypeTable();
		self::createPropertyTypeJoinTable();
		self::createPropertyCounties();
		self::createPropertyCountyJoinTable();
		self::createTrailHeadTable();
		self::createTrailHeadJoinTable();
		self::createActivityTable();
		self::createActivityJoinTable();
	}

	/**
	 * creatTrailTable creates base table which we use to join
	 * the relevant tables together
	 */
	public static function createTrailTable():void {
		global $wpdb;

		$table_name = $wpdb->prefix . 'properties';
		$charset_collate = $wpdb->get_charset_collate();


		$stmt = "CREATE TABLE IF NOT EXISTS $table_name (
		id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		post_id BIGINT(20) UNSIGNED,
        title VARCHAR(140) NOT NULL UNIQUE DEFAULT '',
		website_acreage_sf BIGINT(20) NOT NULL DEFAULT 0,
		acreage_sf BIGINT(20) NOT NULL DEFAULT 0,
		trail_miles DECIMAL NOT NULL DEFAULT 0.00,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        version BIGINT(20) UNSIGNED NOT NULL DEFAULT 1,
        PRIMARY KEY (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta( $stmt );
	}

	public static function createPropertyTypeTable():void {
		global $wpdb;
	
		$table_name = $wpdb->prefix . 'property_types';
		$charset_collate = $wpdb->get_charset_collate();
	
		$stmt = "CREATE TABLE IF NOT EXISTS $table_name (
			id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			type_key VARCHAR(140) NOT NULL UNIQUE DEFAULT '',
			type_name VARCHAR(140) NOT NULL UNIQUE DEFAULT '',
			created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
			updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			version BIGINT(20) UNSIGNED NOT NULL DEFAULT 1,
			PRIMARY KEY (id)
		) $charset_collate;";
	
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	
		dbDelta( $stmt );
	}

	public static function createPropertyTypeJoinTable():void {
		global $wpdb;

		$table_name = $wpdb->prefix . 'property_type_joins';
		$properties_table = $wpdb->prefix . 'properties';
    	$property_types_table = $wpdb->prefix . 'property_types';
		$charset_collate = $wpdb->get_charset_collate();

		$stmt = "CREATE TABLE IF NOT EXISTS {$table_name} (
			id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			property_id BIGINT(20) UNSIGNED NOT NULL,
			type_id BIGINT(20) UNSIGNED NOT NULL,
			created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
			updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			version BIGINT(20) UNSIGNED NOT NULL DEFAULT 1,
			PRIMARY KEY (id),
			CONSTRAINT fk_prop_type_joins_properties_id FOREIGN KEY (property_id) REFERENCES $properties_table(id) ON DELETE CASCADE,
			CONSTRAINT fk_prop_type_joins_property_types_id FOREIGN KEY (type_id) REFERENCES $property_types_table(id) ON DELETE CASCADE
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta( $stmt );
	}

	public static function createPropertyCounties():void {
		global $wpdb;
	
		$table_name = $wpdb->prefix . 'property_counties';
		$charset_collate = $wpdb->get_charset_collate();
	
		$stmt = "CREATE TABLE IF NOT EXISTS $table_name (
			id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			county_key VARCHAR(140) NOT NULL UNIQUE DEFAULT '',
			county_name VARCHAR(140) NOT NULL UNIQUE DEFAULT '',
			created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
			updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			version BIGINT(20) UNSIGNED NOT NULL DEFAULT 1,
			PRIMARY KEY (id)
		) $charset_collate;";
	
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	
		dbDelta( $stmt );
	}

	public static function createPropertyCountyJoinTable():void {
		global $wpdb;

		$table_name = $wpdb->prefix . 'property_county_joins';
		$properties_table = $wpdb->prefix . 'properties';
    	$property_joins_table = $wpdb->prefix . 'property_counties';
		$charset_collate = $wpdb->get_charset_collate();

		$stmt = "CREATE TABLE IF NOT EXISTS $table_name (
			id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			property_id BIGINT(20) UNSIGNED NOT NULL,
			county_id BIGINT(20) UNSIGNED NOT NULL,
			created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
			updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			version BIGINT(20) UNSIGNED NOT NULL DEFAULT 1,
			PRIMARY KEY (id),
			CONSTRAINT fk_county_joins_properties_id FOREIGN KEY (property_id) REFERENCES $properties_table(id) ON DELETE CASCADE,
			CONSTRAINT fk_county_joins_property_types_id FOREIGN KEY (county_id) REFERENCES $property_joins_table(id) ON DELETE CASCADE
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta( $stmt );
	}


	public static function createTrailHeadTable():void {
		global $wpdb;

		$table_name = $wpdb->prefix . 'property_trailheads';
		$charset_collate = $wpdb->get_charset_collate();

		$stmt = "CREATE TABLE IF NOT EXISTS $table_name (
			id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			title VARCHAR(140) NOT NULL UNIQUE DEFAULT '',
			trailhead_lat VARCHAR(24) NOT NULL DEFAULT '',
			trailhead_lon VARCHAR(24) NOT NULL DEFAULT '',
			created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
			updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			version BIGINT(20) UNSIGNED NOT NULL DEFAULT 1,
			PRIMARY KEY (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta( $stmt );


	}

	public static function createTrailHeadJoinTable():void {

		global $wpdb;

		$table_name = $wpdb->prefix . 'property_trailhead_joins';
		$properties_table = $wpdb->prefix . 'properties';
		$trailhead_table_name = $wpdb->prefix . 'property_trailheads';
		$charset_collate = $wpdb->get_charset_collate();

		$stmt = "CREATE TABLE IF NOT EXISTS $table_name (
			id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			property_id BIGINT(20) UNSIGNED NOT NULL,
			trailhead_id BIGINT(20) UNSIGNED,
			created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
			updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			version BIGINT(20) UNSIGNED NOT NULL DEFAULT 1,
			PRIMARY KEY (id),
			CONSTRAINT fk_trailhead_joins_property_id FOREIGN KEY (property_id) REFERENCES $properties_table(id) ON DELETE CASCADE,
			CONSTRAINT fk_trailhead_joins_trailhead_id FOREIGN KEY (trailhead_id) REFERENCES $trailhead_table_name(id) ON DELETE CASCADE
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta( $stmt );

	}

	public static function createActivityTable():void {
		global $wpdb;

		$table_name = $wpdb->prefix . "property_activities";
		$charset_collate = $wpdb->get_charset_collate();

		$stmt = "CREATE TABLE IF NOT EXISTS $table_name (
			id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			activity_key VARCHAR(140) NOT NULL UNIQUE DEFAULT '',
			activity_title VARCHAR(140) NOT NULL UNIQUE DEFAULT '',
			created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
			updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			version BIGINT(20) UNSIGNED NOT NULL DEFAULT 1,
			PRIMARY KEY (id)

		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta( $stmt );

	}

	public static function createActivityJoinTable():void {
		global $wpdb;

		$table_name = $wpdb->prefix . 'property_activity_joins';
		$fk_properties_table = $wpdb->prefix . 'properties';
		$fk_activities_table = $wpdb->prefix . 'property_activities';
		$charset_collate = $wpdb->get_charset_collate();

		$stmt = "CREATE TABLE IF NOT EXISTS $table_name(
		id BIGINT(20) NOT NULL AUTO_INCREMENT,
		property_id BIGINT(20) UNSIGNED NOT NULL,
		activity_id BIGINT(20) UNSIGNED NOT NULL,
		created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
		updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		version BIGINT(20) UNSIGNED NOT NULL DEFAULT 1,
		PRIMARY KEY (id),
		CONSTRAINT fk_activity_join_property_id FOREIGN KEY (property_id) REFERENCES $fk_properties_table (id) ON DELETE CASCADE,
		CONSTRAINT fk_activity_join_activity_id FOREIGN KEY (activity_id) REFERENCES $fk_activities_table (id) ON DELETE CASCADE
		)$charset_collate;";




		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta($stmt);
	}

}
