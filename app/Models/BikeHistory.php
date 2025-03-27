<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BikeHistory extends Model
{
  public $table = 'bike_histories';

  public $fillable = [
    'bike_id',
    'rider_id',
    'notes',
    'note_date',
    'warehouse',
    'contract'
  ];

  protected $casts = [
    'notes' => 'string',
    'note_date' => 'date',
    'warehouse' => 'string',
    'contract' => 'string'
  ];

  public static array $rules = [
    'bike_id' => 'required',
    'rider_id' => 'nullable',
    'notes' => 'nullable|string|max:65535',
    'created_at' => 'nullable',
    'updated_at' => 'nullable',
    'note_date' => 'nullable',
    'warehouse' => 'nullable|string|max:50',
    'contract' => 'nullable|string|max:255'
  ];

  public function rider()
  {
    return $this->belongsTo(Riders::class, 'rider_id', 'id');
  }
  public function bike()
  {
    return $this->belongsTo(Bikes::class, 'bike_id', 'id');
  }
}
