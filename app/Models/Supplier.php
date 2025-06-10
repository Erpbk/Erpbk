<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Accounts;

class Supplier extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'email',
    'phone',
    'company_name',
    'address',
    'account_id',
    'status'
  ];
  public function account()
  {
    return $this->belongsTo(Accounts::class, 'account_id');
  }
}
