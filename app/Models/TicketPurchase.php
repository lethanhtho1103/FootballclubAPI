<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketPurchase extends Model
{
    use HasFactory;

    protected $primaryKey = 'purchase_id'; // Assuming 'id' is the primary key
    public $timestamps = true; // If 'created_at' and 'updated_at' timestamps are being used

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'ticket_id',
        'purchase_date',
    ];

    /**
     * Get the ticket associated with the purchase.
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id', 'ticket_id');
    }
}
