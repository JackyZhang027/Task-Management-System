<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalProcessTransaction extends Model
{
    use HasFactory;
    
    public function proposal()
    {
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }
    
    public function service()
    {
        return $this->belongsTo(Services::class, 'service_id');
    }
    public function mapping()
    {
        return $this->belongsTo(DocumentMapping::class, 'services_mapping_id');
    }
    public function checkedByUser()
    {
        return $this->belongsTo(User::class, 'checked_by');
    }

    protected $fillable = [
        'proposal_id',
        'service_id',
        'services_mapping_id',
        'is_checked', 
        'remark',
        'checked_by',
        'checked_date'
    ];
}
