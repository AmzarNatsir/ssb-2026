<?php

use Illuminate\Support\Facades\Config;

if (!function_exists('generate_menu_warehouse')) {
    function generate_menu_warehouse($roles = null)
    {
        $rawMenu = Config::get('constants.menu.warehouse');
        $result = '';
        $menuPerefix = 'warehouse-';
        foreach ($rawMenu as $menuName => $item) {
            $result .= '<tr>';
            $result .= '<td class="list-menu-title" onclick="checkAll(this)" style="cursor:pointer;width: 50%; padding-left:5rem"><strong >' . strtoupper(str_replace('_', ' ', $menuName)) . '</strong></td>';
            $result .= generate_warehouse_menu_permission($menuPerefix . $menuName, $item, $roles);
            $result .= '</tr>';
            if (isset($item['submenu']) && $item['submenu']) {
                $result .= generate_warehouse_submenu($menuPerefix . $menuName, $item['submenu'], $roles);
            }
        }

        return $result;
    }
}

if (!function_exists('generate_warehouse_menu_permission')) {
    function generate_warehouse_menu_permission($name, $item, $roles = null)
    {
        $result = '';
        if (isset($item['permission']) && count($item['permission'])) {
            foreach ($item['permission'] as $permissionName => $permissionValue) {
                $result .= '<td>';
                $generatedPermimssionName = $name . '.' . $permissionName;
                $checked = '';
                if ($roles && isset($roles->permissions)) {
                    $checked = $roles->permissions->contains('name', $generatedPermimssionName) ? 'checked' : '';
                }

                if ($permissionValue == true) {
                    $result .= '<div class="custom-control custom-checkbox">
                                        <input type="checkbox" id="' . $name . '" class="custom-control" name="menu_warehouse[]" value="' . $generatedPermimssionName . '" ' . $checked . '>
                                    </div>';
                }
                $result .= '</td>';
            }
        } else {
            $result .= '<td></td><td></td><td></td><td></td><td></td><td></td>';
        }

        return $result;
    }
}

if (!function_exists('generate_warehouse_submenu')) {
    function generate_warehouse_submenu($name, $submenu, $roles = null)
    {
        $result = '';
        foreach ($submenu as $submenuName => $submenuItem) {
            // dd($submenuName);
            $result .= '<tr>';
            $result .= generate_menu_title($submenuName);
            $result .= generate_warehouse_menu_permission($name . '.' . $submenuName, $submenuItem, $roles);
            $result .= '</tr>';
        }

        return $result;
    }
}

if (!function_exists('generate_menu_title')) {
    function generate_menu_title($name)
    {
        return  "<td style='padding-left:8rem;cursor:pointer;width: 50%' onclick='checkAll(this)' >" . strtoupper(str_replace('_', ' ', $name)) . '</td>';
    }
}

if (!function_exists('generate_menu_workshop')) {
    function generate_menu_workshop($roles = null)
    {
        $rawMenu = Config::get('constants.menu.workshop');
        $result = '';
        $menuPerefix = 'workshop-';
        foreach ($rawMenu as $menuName => $item) {
            $result .= '<tr>';
            $result .= '<td class="list-menu-title" onclick="checkAll(this)" style="cursor:pointer; width:50%; padding-left:5rem"><strong >' . strtoupper(str_replace('_', ' ', $menuName)) . '</strong></td>';
            $result .= generate_workshop_menu_permission($menuPerefix . $menuName, $item, $roles);
            $result .= '</tr>';
            if (isset($item['submenu']) && $item['submenu']) {
                $result .= generate_workshop_submenu($menuPerefix . $menuName, $item['submenu'], $roles);
            }
        }

        return $result;
    }
}

if (!function_exists('generate_workshop_menu_permission')) {
    function generate_workshop_menu_permission($name, $item, $roles = null)
    {
        $result = '';
        if (isset($item['permission']) && count($item['permission'])) {
            foreach ($item['permission'] as $permissionName => $permissionValue) {
                $result .= '<td>';
                $generatedPermimssionName = $name . '.' . $permissionName;
                $checked = '';
                if ($roles && isset($roles->permissions)) {
                    $checked = $roles->permissions->contains('name', $generatedPermimssionName) ? 'checked' : '';
                }

                if ($permissionValue == true) {
                    $result .= '<div class="custom-control custom-checkbox">
                                        <input type="checkbox" id="' . $name . '" class="custom-control" name="menu_workshop[]" value="' . $generatedPermimssionName . '" ' . $checked . '>
                                    </div>';
                }
                $result .= '</td>';
            }
        } else {
            $result .= '<td></td><td></td><td></td><td></td><td></td><td></td>';
        }

        return $result;
    }
}

if (!function_exists('generate_workshop_submenu')) {
    function generate_workshop_submenu($name, $submenu, $roles = null)
    {
        $result = '';
        foreach ($submenu as $submenuName => $submenuItem) {
            // dd($submenuName);
            $result .= '<tr>';
            $result .= generate_menu_title($submenuName);
            $result .= generate_workshop_menu_permission($name . '.' . $submenuName, $submenuItem, $roles);
            $result .= '</tr>';
        }

        return $result;
    }
}

if (!function_exists('current_user_has_permission_to')) {
    function current_user_has_permission_to($permission_name)
    {
        return auth()->user()->hasAnyPermission([$permission_name, 'super_admin']);
    }
}
