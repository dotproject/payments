<?php
/*
 * Name:      Payments
 * Directory: payments
 * Version:   0.1
 * Class:     user
 * UI Name:   Payments
 * UI Icon:   monkeychat-48.png
 */

// MODULE CONFIGURATION DEFINITION
$config = array();
$config['mod_name'] = 'Payments';
$config['mod_version'] = '0.1';
$config['mod_directory'] = 'payments';
$config['mod_setup_class'] = 'CSetupPayments';
$config['mod_type'] = 'user';
$config['mod_ui_name'] = 'Payments';
$config['mod_ui_icon'] = 'applet3-48.png';
$config['mod_description'] = 'A module for payments';

if (@$a == 'setup') {
	echo dPshowModuleConfig( $config );
}

class CSetupPayments {   

	function install() {
	  $sql = "CREATE TABLE payments (" .
	     "payment_id int(11) NOT NULL auto_increment," .
	     "payment_company int(11) NOT NULL default '0'," .
	     "payment_authcode int(11) NOT NULL default '0'," .
	     "payment_amount float(5,2) NOT NULL default '0.00'," .
	     "payment_type int(11) NOT NULL default '0'," .
	     "payment_date datetime NOT NULL default '0000-00-00 00:00:00'," .
	     "payment_owner int(11) NOT NULL default '0'," .
	     "PRIMARY KEY  (payment_id)" .
	     ") TYPE=MyISAM";
	  db_exec( $sql );
	  $sql2 = "CREATE TABLE invoice_payment (" .
	     "payment_id int(11) NOT NULL default '0'," .
	     "invoice_id int(11) NOT NULL default '0'," .
	     "KEY invoice_id (invoice_id)," .
	     "KEY payment_id (payment_id)" .
	     ") TYPE=MyISAM";
	  db_exec( $sql2 );
	  return null;
	}
	
	function remove() {
		db_exec( "DROP TABLE payments" );
		db_exec( "DROP TABLE invoice_payment" );
		db_exec( "delete from permissions where permission_grant_on like 'payments'");
		return null;
	}
	
	function upgrade() {
		return null;
	}
}

?>	
	
