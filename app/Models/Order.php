<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public function company(){
        return $this->belongsTo(Company::class);
    }
    public function client(){
        return $this->belongsTo(Client::class);
    }
    public function vessel(){
        return $this->belongsTo(Vessel::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function service_report(){
        return $this->hasMany(ServiceReport::class);
    }
    public function delivery_report(){
        return $this->hasMany(DeliveryReport::class);
    }
    public function invoice_report(){
        return $this->hasMany(InvoiceReport::class);
    }
    public function work_done_report(){
        return $this->hasMany(WorkDoneReport::class);
    }
    public function product_requisition()
    {
        return $this->belongsTo(ProductRequisiton::class);
    }
    public function requisitions()
    {
        return $this->hasMany(Requisition::class);
    }
}
