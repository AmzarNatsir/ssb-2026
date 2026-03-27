<!-- Sidebar  -->
<div class="iq-sidebar">
    <div class="iq-sidebar-logo d-flex justify-content-between">
        <a href="/">
            <img src="{{ asset('assets/images/logo.png') }}" class="img-fluid" alt="">
            <span style="font-size: 25px;">Warehouse</span>
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
                    ->submenuIf(current_user_has_permission_to('warehouse-dashboard.view'), Spatie\Menu\Link::to('#', '<i class="ri-home-4-line"></i><span>Dashboard</span><i class="ri-arrow-right-s-line iq-arrow-right"></i>')->addClass('iq-waves-effect'), Menu::new())
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
                    ->add(Spatie\Menu\Html::raw('<i class="ri-separator"></i><span>Master Data</span></li>')->addParentClass('iq-menu-title'))
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
