<?php

namespace App\Helpers;
use App\Models\Dropdowns;
use App\Models\Services;
use App\Models\Settings;
use App\Models\User;

class Common
{

  public static function getSetting($setting_name)
  {

    return Settings::where('name', $setting_name)->value('value');

  }

  /*  public static function settings()
   {
     return Settings::all()->pluck('value', 'name');
   } */

  public static function settings($key = null, $default = null)
  {
    $settings = cache()->rememberForever('settings', function () {
      return Settings::pluck('value', 'name')->toArray();
    });

    return $key ? ($settings[$key] ?? $default) : $settings;
  }



  public static function AccountTypes($id = null)
  {
    $types = [
      'Asset' => 'Asset',
      'Liability' => 'Liability',
      'Equity' => 'Equity',
      'Revenue' => 'Revenue',
      'Expense' => 'Expense'

    ];
    if ($id) {
      return $types[$id];
    } else {
      return $types;
    }
  }

  public static function dropdown($items, $selected = null, $parentId = null, $prefix = '')
  {
    $html = '';
    $select = '';
    //$items = Accounts::all(['id', 'name', 'account_parent_id'])->groupBy('account_parent_id');

    // Get categories grouped by parent_id
    if (isset($items[$parentId])) {
      foreach ($items[$parentId] as $item) {
        if ($selected) {
          if ($item->id == $selected) {
            $select = 'selected';
          }
        }

        $html .= '<option value="' . $item->id . '" ' . $select . '>' . $prefix . $item->name . '</option>';
        $html .= self::dropdown($items, $selected, $item->id, $prefix . '⮞ ');
      }
    }

    return $html;
  }



  public static function DateFormat($date)
  {
    return date('d-M-Y', strtotime($date));

  }
  public static function MonthFormat($date)
  {
    return date('M Y', strtotime($date));

  }

  public static function DateTimeFormat($date)
  {
    return date('d M Y h:i A', strtotime($date));

  }
  public static function Dropdowns($key)
  {
    $dropdown = Dropdowns::where('key', $key)->first();
    $values = json_decode($dropdown->values);
    return array_combine($values, $values);
  }

  public static function UserName($id)
  {
    $user = User::find($id);
    if ($user) {
      return $user->name;
    }

  }


}
