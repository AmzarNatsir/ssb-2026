<?php

namespace App\Repository\Warehouse;

use Hamcrest\Arrays\IsArray;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class WarehouseRepository
{
  const STATUS = [
    1 => 'Purchasing request',
    2 => 'Price Comparison',
    3 => 'Purchasig Order',
    4 => 'Receiving',
    5 => 'Part Return',
    6 => 'issued'

  ];

  const NUMBER_PREFIX = '{number}';

  const SUBTITUTE_DETAIL_ATTRIBUTE_KEY = true;

  public $model;
  public $detail;
  private $subtituteDetailAttributesKey = [ 'remarks' => 'part_remarks' ];
  private $masterNumberColumnName = 'number';
  protected $status;
  protected $defaultRelation = ['details.sparepart'];

  public function __construct($id = null)
  {

  }

  public function generateNumber(): string
  {
    $lastNumber = $this->getLastNumber() + 1 ;

    return preg_replace('/{(.*)}/', $lastNumber, $this->getNumberPrefix());
  }

  public function create( array $attributes = null ): object
  {
    // try {

    $master = $this->createMaster($attributes);
    $detail = $this->createDetail($master, $attributes);

    $childClass =  get_class($this);
    $childClassObject = new $childClass($master->id);
    $this->checkReference($childClassObject);

    return $childClassObject;
    // } catch (\Exception $e) {
    // return false;
    // }

  }

  public function update(array $attributes): object
  {
    // try {
    $master = $this->updateMaster($attributes);
    $detail = $this->createDetail($master, $attributes, true);

    $childClass =  get_class($this);
    $childClassObject = new $childClass($master->id);
    $this->checkReference($childClassObject);

    return $childClassObject;

    // } catch (\Exception $e) {

    //     return false;

    // }

  }

  public function remove(int $id = null ): bool
  {
    // try {
    $this->checkReference($this, 'redo');

    $detail = $this->removeDetail();
    $master = $this->removeMaster();


    return true;

    // } catch (\Exception $e) {

    //     return false;

    // }
  }

  public function list(array $options = []): LengthAwarePaginator
  {
    $model = $this->model;

    if (Arr::exists($options,'search')){
      $model = $model->where('number', 'like', '%'.$options['search'].'%');
    }

    if (Arr::exists($options,'keyword')){
      $model = $model->where('number', 'like', '%'.$options['keyword'].'%');
    }

    if (Arr::exists($options, 'date_range') && isset($options['date_range'][0])){
      $model = $model->filterDateRange($options['date_range'][0], $options['date_range'][1], $options['date_range'][2]);
    }

    if (Arr::exists($options, 'where_like')) {
      foreach ($options['where_like'] as $key => $value) {
        if (!isset($value)) {
          continue;
        } else {
          $explodedStr = explode('.', $key);
          if (count($explodedStr) > 1){
//            dd($explodedStr);
            $model = $model->orWhereHas($explodedStr[0], function($query) use($explodedStr, $value){
              return $query->where($explodedStr[1], 'like', '%'.$value.'%');
            });
          } else {
            $model = $model->orWhere($key, 'like', '%'.$value.'%');
          }
        }
      }
    }

    if (Arr::exists($options,'where')){
      foreach ($options['where'] as $key => $value) {
        if (!isset($value)){
          continue;
        }else{
          $explodedStr = explode('.', $key);
          if (count($explodedStr) > 1){
            $model = $model->whereHas($explodedStr[0], function($query) use($explodedStr, $value){
              return $query->where($explodedStr[1], $value);
            });
          } else {
            $model = $model->where($key, $value);
          }
        }
      }
    }

    $defaultRelation = $this->defaultRelation;

    if (Arr::exists($options, 'with')) {
      $model = $model->with( array_merge($options['with'], $defaultRelation));
    }

    $model = $model->latest()->paginate($this->model::PAGE_LIMIT);

    return $model;

  }

  public function view(int $id): array
  {
    # code...
  }

  public function getReferenceObject(): object
  {
    # code...
  }

  public function getOne(int $id)
  {
    return $this->model->findOrFail($id)->with('details.sparepart');
  }

  private function createMaster(array $attributes)
  {
    $master = new $this->model;

    $master = $master->fill($attributes);

    $numberColumnName = $this->masterNumberColumnName;

    $master->$numberColumnName = $this->generateNumber();

    $master->status = $master->getCurrentStatus();

    $master->save();

    return $master;
  }

  private function updateMaster(array $attributes)
  {
    $master = $this->model;

    $master = $master->fill($attributes);

    $master->save();

    return $master;
  }

  private function createDetail($master , array $attributes, $deleteDetails = false )
  {

    $attributes = static::SUBTITUTE_DETAIL_ATTRIBUTE_KEY ? $this->subtituteDetailAttributesKey($attributes) : $attributes ;

    $details = $this->prepareDetail($attributes);

    if ($deleteDetails) {
      $master->details()->delete();
    }

    foreach ($details as $key => $value) {
      $master->details()->create($value);
    }
  }

  private function prepareDetail($attributes): array
  {
    $detailAttributes = (new $this->detail)->getFillable();
    $details = [];

    foreach ($detailAttributes as $detailAttributesKey => $detailAttributesValue) {

      if (array_key_exists($detailAttributesValue, $attributes) && is_array($attributes[$detailAttributesValue])) {

        foreach ($attributes[$detailAttributesValue] as $attributesKey => $attributesValue) {

          if (isset($attributes[$detailAttributesValue][$attributesKey])) {
            $details[$attributesKey][$detailAttributesValue] = $attributes[$detailAttributesValue][$attributesKey];
          }
        }

      }
    }

    return $details;
  }

  private function subtituteDetailAttributesKey(array $attributes): array
  {
    foreach ($this->subtituteDetailAttributesKey as $key => $value) {
      unset($attributes[$key]);
      $attributes[$key] = $attributes[$value];
    }

    return $attributes;
  }

  private function removeMaster()
  {
    return $this->model->delete();
  }

  private function removeDetail()
  {
    return $this->model->details()->delete();
  }


  public function getNumberPrefix()
  {
    return static::NUMBER_PREFIX;
  }

  public function getLastNumber(): int
  {
    $identifierPos = strpos($this->getNumberPrefix(),'{') + 1;

    $lastNumber =  $this->model->selectRaw("CAST(SUBSTRING(number,".$identifierPos.",10) AS UNSIGNED) as latest_number")
      ->orderByRaw('CAST(SUBSTRING(number,'.$identifierPos.',10) AS UNSIGNED) desc')
      ->limit(1)
      ->get('latest_number');

    return $lastNumber->count() ? $lastNumber->first()->latest_number : 0;
  }

  public function numbering($number)
  {
    switch ($number) {
      case $number < 10 :
        return '0000'.$number;
        break;
      case $number < 100 :
        return '000'.$number;
        break;
      case $number < 1000 :
        return '00'.$number;
        break;
      case $number < 10000 :
        return '0'.$number;
        break;
      default:
        return $number;
        break;
    }
  }

  public function extractPrefix()
  {
    $prefix = $this->getNumberPrefix();

    $prefix = preg_replace('/{year}/',date('Y'),$prefix);
    $prefix = preg_replace('/{month}/',date('m'),$prefix);

    return $prefix;
  }

  protected function checkReference($object, $method = 'update'){
    if ($object->model->reference_id) {
      if ($method === 'update') {
        $object->updateStatusOnReference();
      } else {
        $object->redoStatusOnReference();
      }
    }
  }

  protected function updateStatusOnReference(){
    return true;
  }

  protected function redoStatusOnReference(){
    return true;
  }



}
