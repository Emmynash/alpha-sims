<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\InventoryModel;

class InvoicesInventory extends Model
{
    use HasFactory;

    public function getInvoiceItems()
    {
        return $this->hasMany('App\OrderInvoiceModel', 'invoice_id');
    }

    public function getItemName($item_id)
    {
        $getItemId = InventoryModel::where('id', $item_id)->first();

        return $getItemId;
    }
}
