<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
  public $table = 'items';

  public $fillable = [
    'name',
    'item_unit',
    'detail',
    'price',
    'cost',
    'vat',
    'code',
    'barcode',
    'created_by',
    'updated_by',
    'status'
  ];

  protected $casts = [
    'name' => 'string',
    'detail' => 'string',
    'price' => 'decimal:2',
    'cost' => 'decimal:2',
    'vat' => 'decimal:2'
  ];

  public static array $rules = [
    'name' => 'required|string|max:255',
    'detail' => 'nullable|string|max:500',
    'price' => 'required|numeric',
    'cost' => 'required|numeric',
    'vat' => 'nullable|numeric',
    'created_at' => 'nullable',
    'updated_at' => 'nullable'
  ];

  public static function dropdown()
  {
    $query = self::select('id', 'name')->pluck('name', 'id')->prepend('Select', '');
    return $query;

  }
}
