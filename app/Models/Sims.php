<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sims extends Model
{
    public $table = 'sims';

    public $fillable = [
        'number',
        'company',
        'assign_to',
        'created_by',
        'updated_by',
        'fleet_supervisor',
        'status',
        'emi',
        'vendor'
    ];

    protected $casts = [
        'number' => 'string',
        'company' => 'string',
        'fleet_supervisor' => 'string',
        'status' => 'string',
        'emi' => 'string'
    ];

    public static array $rules = [
        'number' => 'required|string|max:191',
        'company' => 'required|string|max:191',
        'assign_to' => 'required',
        'created_by' => 'nullable',
        'updated_by' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'fleet_supervisor' => 'nullable|string|max:50',
        'status' => 'nullable|string|max:50',
        'emi' => 'nullable|string|max:100',
        'vendor' => 'nullable'
    ];

    
}
