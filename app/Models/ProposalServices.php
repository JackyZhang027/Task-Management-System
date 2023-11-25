<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalServices extends Model
{
    use HasFactory;
    /**
    * Get the Proposal that owns the Services.
    */
   public function proposal()
   {
       return $this->belongsTo(Proposal::class);
   }
   
   public function service()
   {
       return $this->belongsTo(Services::class, 'service_id');
   }
   protected $fillable = [
        'service_id',
        'fee',
    ];

}
