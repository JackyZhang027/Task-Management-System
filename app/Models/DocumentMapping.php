<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentMapping extends Model
{
    use HasFactory;
    public function service()
    {
        return $this->belongsTo(Services::class, 'service_id');
    }
    public function category()
    {
        return $this->belongsTo(ProcessCategory::class, 'process_id');
    }
    protected $table = 'document_mapping';

    protected $fillable = [
        'name',
        'description',
        'service_id',
        'process_id',
        'sequence_no',
        'is_active',
        'created_by',
        'updated_by',
    ];
}
