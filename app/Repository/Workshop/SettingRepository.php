<?php

namespace App\Repository\Workshop;

use Illuminate\Support\Facades\Storage;

class SettingRepository
{

    public const TYPE_SELECT = 'select';
    public const TYPE_MULTIPLE_SELECT = 'multiple_select';

    protected $settings_items = [
        'workshop_manager' => [
            "type" => self::TYPE_SELECT,
            "value" => null,
            "source" => 'users'
        ],
        'mechanic_manager' => [
            'type' => self::TYPE_SELECT,
            'value' => null,
            "source" => 'karyawans'
        ],
        'mechanic_position' => [
            'type' => self::TYPE_SELECT,
            'value' => null,
            "source" => 'positions'
        ],
        'driver_position' => [
            'type' => self::TYPE_MULTIPLE_SELECT,
            'value' => null,
            "source" => 'positions'
        ],
        'workshop_department' => [
            'type' => self::TYPE_SELECT,
            'value' => null,
            "source" => 'departments'
        ]
    ];

    /**
     * initiate settings item and get the value from storage
     */

    public function __construct()
    {
        if (!$this->check()) {
            // write the settings file if not exists
            $this->write();
        }
        // parse the settings item from storage into class property
        $this->parse();

        return $this;
    }

    public static function getAll()
    {
        $settings = new self();

        return collect($settings->settings_items);
    }

    public static function get($key = '')
    {
        return (new self)->settings_items[$key]['value'];
    }

    public function set($key = '', $value = null)
    {
        // set the setting item and save it to storage
        $this->settings_items[$key] = $value;
    }

    private function write()
    {
        if (Storage::put('settings/workshop', collect($this->settings_items))) {
            return true;
        }

        return false;
    }

    /**
     * Check if the setting file is exists
     *
     * 
     * @return bool
     */
    private function check()
    {
        return Storage::exists('settings/workshop');
    }

    private function extract()
    {
        return Storage::get('settings/workshop');
    }

    public static function buildSelectElement($type, $item_names, $data, $selected)
    {
        $multiple = $type == static::TYPE_MULTIPLE_SELECT ? 'multiple="multiple"' : null;
        // if ($type == static::TYPE_MULTIPLE_SELECT ) {
        //     dd($type, $item_names, $data, $selected);
        // }
        $element = '<select class="form-control" name="' . $item_names . ($multiple ? '[]' : '') . '" ' . $multiple . ' >';
        if (isset($data)) {
            foreach ($data as $key => $value) {

                if (is_array($selected) && in_array($key, $selected)) {
                    $element .= '<option selected value="' . $key . '" >' . $value . '</option>';
                } elseif ($selected && $selected == $key) {
                    $element .= '<option selected value="' . $key . '" >' . $value . '</option>';
                } else {
                    $element .= '<option value="' . $key . '" >' . $value . '</option>';
                }
            }
        }
        $element .= '</select>';

        return $element;
    }

    public static function save($attributes)
    {
        $settings = new self();
        $settings->fill($attributes);
        if ($settings->write()) {
            return true;
        }
        return false;
    }

    private function fill($attributes)
    {
        foreach ($attributes as $key => $value) {
            if (array_key_exists($key, $this->settings_items)) {
                $this->settings_items[$key]['value'] = $value;
            }
        }
    }

    private function parse()
    {
        $settings = collect(json_decode($this->extract(), TRUE));
        foreach ($settings as $key => $item) {
            $this->set($key, $item);
        }
    }
}
