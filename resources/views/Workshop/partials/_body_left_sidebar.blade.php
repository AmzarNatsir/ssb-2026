<!-- Sidebar  -->
<div class="iq-sidebar">
    <div class="iq-sidebar-logo d-flex justify-content-between">
        <a href="/">
            <img src="{{ asset('assets/images/logo.png') }}" class="img-fluid" alt="">
            <span style="font-size: 25px;">Workshop</span>
        </a>
        <div class="iq-menu-bt align-self-center">
            <div class="wrapper-menu">
                <div class="line-menu half start"></div>
                <div class="line-menu"></div>
                <div class="line-menu half end"></div>
            </div>
        </div>
    </div>
    <div id="sidebar-scrollbar">
        <nav class="iq-sidebar-menu">
            @php
                $menu = Menu::new()
                    ->addClass('iq-menu')
                    ->add(Spatie\Menu\Html::raw('<i class="ri-separator"></i><span>Main</span></li>')->addParentClass('iq-menu-title'))
                    ->submenuIf(current_user_has_permission_to('workshop-dashboard.view'), Spatie\Menu\Link::to('#', '<i class="ri-home-4-line"></i><span>Dashboard</span><i class="ri-arrow-right-s-line iq-arrow-right"></i>')->addClass('iq-waves-effect'), Menu::new())
                    ->submenuIf(current_user_has_permission_to('workshop-operating_sheet.view'), Spatie\Menu\Link::to(route('workshop.inspection.index'), '<i class="ri-todo-line"></i><span>Operating Sheet</span>')->addClass('iq-waves-effect'), Menu::new()->addClass('iq-submenu'))
                    ->submenuIf(current_user_has_permission_to('workshop-work_request.view'), Spatie\Menu\Link::to(route('workshop.work-request.index'), '<i class="ri-file-list-line"></i><span>Work Request</span>')->addClass('iq-waves-effect'), Menu::new()->addClass('iq-submenu'))
                    ->submenuIf(current_user_has_permission_to('workshop-work_order.view'), Spatie\Menu\Link::to(route('workshop.work-order.index'), '<i class="ri-article-line"></i><span>Work Order</span>')->addClass('iq-waves-effect'), Menu::new()->addClass('iq-submenu'))
                    ->add(Spatie\Menu\Html::raw('<i class="ri-separator"></i><span>SPARE PART</span></li>')->addParentClass('iq-menu-title'))
                    ->submenuIf(current_user_has_permission_to('warehouse-spare_part.purchasing_request.view'), Spatie\Menu\Link::to(route('warehouse.purchasing-request.index'), '<i class="ri-pantone-line"></i><span>Purchasing Request</span>')->addClass('iq-waves-effect'), Menu::new()->addClass('iq-submenu'))
                    ->submenuIf(current_user_has_permission_to('warehouse-spare_part.purchasing_comparison.view'), Spatie\Menu\Link::to(route('warehouse.purchasing-comparison.index'), '<i class="ri-stack-line"></i><span>Purchasing Comparison</span>')->addClass('iq-waves-effect'), Menu::new()->addClass('iq-submenu'))
                    ->submenuIf(current_user_has_permission_to('warehouse-spare_part.purchasing_order.view'), Spatie\Menu\Link::to(route('warehouse.purchasing-order.index'), '<i class="ri-file-list-line"></i><span>Purchasing order</span>')->addClass('iq-waves-effect'), Menu::new()->addClass('iq-submenu'))
                    ->submenuIf(current_user_has_permission_to('warehouse-spare_part.receiving.view'), Spatie\Menu\Link::to(route('warehouse.receiving.index'), '<i class="ri-truck-line"></i><span>Receiving</span>')->addClass('iq-waves-effect'), Menu::new()->addClass('iq-submenu'))
                    ->submenuIf(current_user_has_permission_to('warehouse-spare_part.return.view'), Spatie\Menu\Link::to(route('warehouse.part-return.index'), '<i class="ri-direction-fill"></i><span>Return</span>')->addClass('iq-waves-effect'), Menu::new()->addClass('iq-submenu'))
                    ->submenuIf(current_user_has_permission_to('warehouse-spare_part.issued.view'), Spatie\Menu\Link::to(route('warehouse.issued.index'), '<i class="ri-book-line"></i><span>Issued</span>')->addClass('iq-waves-effect'), Menu::new()->addClass('iq-submenu'))
                    ->add(Spatie\Menu\Html::raw('<i class="ri-separator"></i><span>BBM</span></li>')->addParentClass('iq-menu-title'))
                    ->submenuIf(current_user_has_permission_to('warehouse-bbm.receiving.view'), Spatie\Menu\Link::to(route('warehouse.fuel-receiving.index'), '<i class="ri-truck-line"></i><span>Receiving</span>')->addClass('iq-waves-effect'), Menu::new()->addClass('iq-submenu'))
                    ->add(Spatie\Menu\Html::raw('<i class="ri-separator"></i><span>BBM CONSUMPTION/ISSUED</span></li>')->addParentClass('iq-menu-title'))
                    ->submenuIf(current_user_has_permission_to('warehouse-bbm_consumption/issued.fuel_tank.view'), Spatie\Menu\Link::to(route('warehouse.fuel-tank-consumption.index'), '<i class="ri-building-line"></i><span>Fuel Tank</span>')->addClass('iq-waves-effect'), Menu::new()->addClass('iq-submenu'))
                    ->submenuIf(current_user_has_permission_to('warehouse-bbm_consumption/issued.fuel_truck.view'), Spatie\Menu\Link::to(route('warehouse.fuel-truck-consumption.index'), '<i class="ri-truck-fill"></i><span>Fuel Truck</span>')->addClass('iq-waves-effect'), Menu::new()->addClass('iq-submenu'))
                    ->add(Spatie\Menu\Html::raw('<i class="ri-separator"></i><span>Tools Management</span></li>')->addParentClass('iq-menu-title'))
                    ->submenuIf(current_user_has_permission_to('workshop-tool_management.tool_usage.view'), Spatie\Menu\Link::to(route('workshop.tool-usage.index'), '<i class="ri-pencil-ruler-line"></i><span>Tool Usage</span>')->addClass('iq-waves-effect'), Menu::new()->addClass('iq-submenu'))
                    ->submenuIf(current_user_has_permission_to('workshop-tool_management.tool_receiving.view'), Spatie\Menu\Link::to(route('workshop.tool-receiving.index'), '<i class="ri-truck-line"></i><span>Tool Receiving</span>')->addClass('iq-waves-effect'), Menu::new()->addClass('iq-submenu'))
                    ->add(Spatie\Menu\Html::raw('<i class="ri-separator"></i><span>Scrap Management</span></li>')->addParentClass('iq-menu-title'))
                    ->submenuIf(current_user_has_permission_to('workshop-scrap_management.scrap.view'), Spatie\Menu\Link::to(route('workshop.scrap.index'), '<i class="ri-delete-bin-line"></i><span>Scrap</span>')->addClass('iq-waves-effect'), Menu::new()->addClass('iq-submenu'))
                    ->add(Spatie\Menu\Html::raw('<i class="ri-separator"></i><span>Master Data</span></li>')->addParentClass('iq-menu-title'))
                    ->submenuIf(current_user_has_permission_to('workshop-master_data.equipment.view'), Spatie\Menu\Link::to(route('workshop.master-data.equipment.index'), '<i class="ri-truck-line"></i><span>Unit / Assets</span>')->addClass('iq-waves-effect'), Menu::new()->addClass('iq-submenu'))
                    ->submenuIf(current_user_has_permission_to('workshop-master_data.equipment_category.view'), Spatie\Menu\Link::to(route('workshop.master-data.equipment-category.index'), '<i class="ri-file-list-line"></i><span>Unit Category</span>')->addClass('iq-waves-effect'), Menu::new()->addClass('iq-submenu'))
                    ->submenuIf(current_user_has_permission_to('workshop-master_data.tools.view'), Spatie\Menu\Link::to(route('workshop.master-data.tools.index'), '<i class="ri-pencil-ruler-fill"></i><span>Tools</span>')->addClass('iq-waves-effect'), Menu::new()->addClass('iq-submenu'))
                    ->submenuIf(current_user_has_permission_to('workshop-master_data.tool_category.view'), Spatie\Menu\Link::to(route('workshop.master-data.tools-category.index'), '<i class="ri-settings-2-line"></i><span>Tools Category</span>')->addClass('iq-waves-effect'), Menu::new()->addClass('iq-submenu'))
                    ->submenuIf(current_user_has_permission_to('workshop-master_data.inspection_checklist.view'), Spatie\Menu\Link::to(route('workshop.master-data.inspection-checklist.index'), '<i class="ri-checkbox-line"></i><span>Inspection Checklist</span>')->addClass('iq-waves-effect'), Menu::new()->addClass('iq-submenu'))
                    ->submenuIf(current_user_has_permission_to('workshop-master_data.setting.view'), Spatie\Menu\Link::to(route('workshop.master-data.settings.index'), '<i class="ri-settings-fill"></i><span>Settings</span>')->addClass('iq-waves-effect'), Menu::new()->addClass('iq-submenu'))
                    ->submenuIf(current_user_has_permission_to('warehouse-master_data.spare_part.view'), Spatie\Menu\Link::to(route('warehouse.master-data.spare-part.index'), '<i class="fa fa-cogs"></i><span>Spare Part</span>')->addClass('iq-waves-effect'), Menu::new()->addClass('iq-submenu'), Menu::new()->addClass('iq-submenu'))
                    ->submenuIf(current_user_has_permission_to('warehouse-master_data.uop.view'), Spatie\Menu\Link::to(route('warehouse.master-data.uop.index'), '<i class="ri-ruler-line"></i><span>Uom</span>')->addClass('iq-waves-effect'), Menu::new()->addClass('iq-submenu'), Menu::new()->addClass('iq-submenu'))
                    ->submenuIf(current_user_has_permission_to('warehouse-master_data.brand.view'), Spatie\Menu\Link::to(route('warehouse.master-data.brand.index'), '<i class="ri-git-repository-line"></i><span>Brand</span>')->addClass('iq-waves-effect'), Menu::new()->addClass('iq-submenu'), Menu::new()->addClass('iq-submenu'))
                    ->submenuIf(current_user_has_permission_to('warehouse-master_data.supplier.view'), Spatie\Menu\Link::to(route('warehouse.master-data.supplier.index'), '<i class="ri-shopping-cart-line"></i><span>Supplier</span>')->addClass('iq-waves-effect'), Menu::new()->addClass('iq-submenu'), Menu::new()->addClass('iq-submenu'))
                    ->submenuIf(current_user_has_permission_to('warehouse-master_data.category.view'), Spatie\Menu\Link::to(route('warehouse.master-data.category.index'), '<i class="ri-file-list-fill"></i><span>Kategori</span>')->addClass('iq-waves-effect'), Menu::new()->addClass('iq-submenu'), Menu::new()->addClass('iq-submenu'))
                    ->submenuIf(current_user_has_permission_to('warehouse-master_data.fuel_tank.view'), Spatie\Menu\Link::to(route('warehouse.master-data.fuel-tank.index'), '<i class="ri-building-line"></i><span>Fuel Tank</span>')->addClass('iq-waves-effect'), Menu::new()->addClass('iq-submenu'), Menu::new()->addClass('iq-submenu'))
                    ->submenuIf(current_user_has_permission_to('warehouse-master_data.fuel_truck.view'), Spatie\Menu\Link::to(route('warehouse.master-data.fuel-truck.index'), '<i class="ri-truck-fill"></i><span>Fuel Truck</span>')->addClass('iq-waves-effect'), Menu::new()->addClass('iq-submenu'), Menu::new()->addClass('iq-submenu'));

            @endphp
            {!! $menu->setActiveFromRequest()->render() !!}
        </nav>
        <div class="p-3"></div>
    </div>
</div>
