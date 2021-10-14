<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionRecord extends Model
{
    use HasFactory;

    public function getTransactionDetails($userid, $session, $term, $schoolid)
    {

        $getInvoiceDetails = FeesInvoice::join('addstudent_secs', 'addstudent_secs.id','=','fees_invoices.system_id')
                            ->join('users', 'users.id','=','addstudent_secs.usernamesystem')
                            ->join('classlist_secs', 'classlist_secs.id','=','fees_invoices.classid')
                            ->join('fees_tables', 'fees_tables.invoice_id','=','fees_invoices.id')
                            ->where(['addstudent_secs.usernamesystem' => $userid, 'fees_invoices.session' => $session, 'fees_invoices.term' => $term, 'fees_invoices.schoolid' => $schoolid])
                            ->select('fees_invoices.*', 'users.firstname', 'users.middlename', 'users.lastname', 'classlist_secs.classname', 'fees_tables.amount_paid')->first();

        return $getInvoiceDetails;
        
    }
}
