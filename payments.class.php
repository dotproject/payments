<?php /* PAYMENTS $Id: payments.class.php,v 0.1 2004/03/29 12:07:45 michaelfinger Exp $ */
/**
 *	@package dotProject
 *	@subpackage modules
 *	@version $Revision: 1.7 $
*/

require_once( $AppUI->getSystemClass ('dp' ) );

/**
 *	Companies Class
 *	@todo Move the 'address' fields to a generic table
 */
class CPayment extends CDpObject {
	var $payment_id = NULL;
	var $payment_authcode = NULL;
       	var $payment_company = NULL;
	var $payment_amount = NULL;
	var $payment_type = NULL;
	var $payment_date = NULL;
	var $payment_owner = NULL;

	function CPayment() {
		$this->CDpObject( 'payments', 'payment_id' );
	}

	function updatePaymentsInvoices( $cslist ) {
	// delete all current entries
		$sql = "DELETE FROM invoice_payment WHERE payment_id = $this->payment_id";
		db_exec( $sql );

	// process dependencies
		if(isset($cslist)) {
		  foreach ($cslist as $invoice_id) {
		    if (intval( $invoice_id ) > 0) {
		      $sql = "INSERT into invoice_payment (payment_id, invoice_id) VALUES ($this->payment_id, $invoice_id)";
		      db_exec($sql);
		      $sql = "UPDATE invoices set invoice_status = 1 where invoice_id = $invoice_id";
		      db_exec($sql);
		    }
		  }
		}
	}


// overload check
	function check() {
		if ($this->payment_id === NULL) {
			return 'payment id is NULL';
		}
		$this->payment_id = intval( $this->payment_id );

		return NULL; // object is ok
	}

// overload canDelete
	function canDelete( &$msg, $oid=null ) {
		$tables[] = array( 'label' => 'Payment Invoices', 'name' => 'invoice_payment', 'idfield' => 'invoice_id', 'joinfield' => 'payment_id' );
	// call the parent class method to assign the oid
		return CDpObject::canDelete( $msg, $oid, $tables );
	}
}
?>