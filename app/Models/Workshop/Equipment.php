<?php

namespace App\Models\Workshop;

use App\Models\Tender\Project;
use App\Models\Warehouse\FuelTruck;
use App\Models\Workshop\MasterData\AdditionalAttributes;
use App\Models\Workshop\MasterData\Schedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
  use SoftDeletes;

  protected $table = 'equipment';
  protected $fillable = [
    'equipment_category_id',
    'location_id',
    'brand_id',
    'code',
    'name',
    'yop',
    'serial_number',
    'production_year',
    'model',
    'status',
    'pic',
    'description',
    'created_by',
    'updated_by',
    'location',
    'picture',
    'hm',
    'km',
    'poject_id'
  ];

  const PAGE_LIMIT = 20;
  const STATUS = [
    'Draft',
    'Active',
    'Iddle',
    'Requested',
    'Inactive',
    'Under Mainteanance',
    'On The Move',
    'Broken',
    'Ijarah',
    'Warehouse',
    'Usulan Scrap',
    'To Be Scrapped',
    'Scrap',
    'Sold'
  ];

  const STATUS_COLOR = [
    'light',
    'success',
    'secondary',
    'info',
    'secondary',
    'warning',
    'info',
    'danger',
    'info',
    'primary',
    'light',
    'warning',
    'danger',
    'dark'
  ];

  public function save(array $options = [])
  {
    if (auth()->user()) {
      $user = auth()->user()->id;
      if (!$this->created_by) {
        $this->created_by = $user;
      }

      $this->updated_by = $user;
    }

    return parent::save($options);
  }

  public function brand(): BelongsTo
  {
    return $this->belongsTo(\App\Models\Warehouse\Brand::class, 'brand_id', 'id');
  }

  public function equipment_category(): BelongsTo
  {
    return $this->belongsTo(EquipmentCategory::class, 'equipment_category_id', 'id');
  }

  public function pic_user(): BelongsTo
  {
    return $this->belongsTo(\App\User::class, 'pic', 'id');
  }

  public function created_by_user(): BelongsTo
  {
    return $this->belongsTo(\App\User::class, 'created_by', 'id');
  }

  public function updated_by_user(): BelongsTo
  {
    return $this->belongsTo(\App\User::class, 'updated_by', 'id');
  }

  public function additional_attributes()
  {
    return $this->morphMany(AdditionalAttributes::class, 'additional_attributeable', 'reference_type', 'reference_id');
  }

  public function schedule()
  {
    return $this->morphTo(Schedule::class, 'scheduleable', 'model', 'model_id');
  }

  public function category()
  {
    return $this->belongsTo(EquipmentCategory::class);
  }

  public function current_location()
  {
    return $this->belongsTo(Location::class, 'location_id', 'id');
  }

  public function fuel_truck()
  {
    return $this->hasOne(FuelTruck::class, 'equipment_id', 'id');
  }

  public function project()
  {
    return $this->belongsTo(Project::class, 'project_id', 'id');
  }

  public function scopeActive($q)
  {
    return $q->where('status', array_search('Active', self::STATUS));
  }

  public function scopeNotFuelTruck($q)
  {
    return $q->doesnthave('fuel_truck');
  }
}
