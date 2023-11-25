<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function process()
    {
        return $this->belongsTo(ProcessCategory::class, 'process_id');
    }
    public function process_state()
    {
        return $this->belongsTo(ProcessCategoryState::class, 'process_state_id');
    }
    public function services()
    {
        return $this->hasMany(ProposalServices::class);
    }
    
    public function proposal_transaction()
    {
        return $this->hasMany(ProposalProcessTransaction::class);
    }
}
