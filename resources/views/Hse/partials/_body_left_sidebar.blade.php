<!-- Sidebar  -->
<div class="iq-sidebar">
    <div class="iq-sidebar-logo d-flex justify-content-between">
        <a href="index.html">
            <img src="{{ asset('assets/images/logo.png') }}" class="img-fluid" alt="">
            <span>Sofbox</span>
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
                ->add(Spatie\Menu\Html::raw('<i class="ri-separator"></i><span>Main</span></li>')
                    ->addParentClass('iq-menu-title')
                )
                ->submenu(
                    Spatie\Menu\Link::to('#', '<i class="ri-home-4-line"></i><span>Dashboard</span><i class="ri-arrow-right-s-line iq-arrow-right"></i>')
                        ->addClass('iq-waves-effect'),
                    Menu::new()
                        ->addClass('iq-submenu')
                        // ->route('dashboard-1', 'Dashboard 1')
                        // ->route('dashboard-2', 'Dashboard 2')
                        // ->route('analytics', 'Analytics')
                        // ->route('tracking', 'Tracking')
                        // ->route('web-analytics', 'Web Analytics')
                        // ->route('patient', 'Patient')
                )
                ->submenu(
                    Spatie\Menu\Link::to('#', '<i class="ri-mail-line"></i><span>Email</span><i class="ri-arrow-right-s-line iq-arrow-right"></i>')
                        ->addClass('iq-waves-effect'),
                    Menu::new()
                        ->addClass('iq-submenu')
                        // ->route('mail', 'Inbox')
                        // ->route('compose-mail', 'Email Compose')
                )
                ->add(Spatie\Menu\Link::to('calendar','<i class="ri-calendar-2-line"></i><span>Calendar</span>')
                    ->addClass('iq-waves-effect')
                )
                ->add(Spatie\Menu\Link::to('chat','<i class="ri-message-line"></i><span>Chat</span><small class="badge badge-pill badge-primary float-right font-weight-normal ml-auto">Soon</small>')
                    ->addClass('iq-waves-effect')
                )
                ->add(Spatie\Menu\Html::raw('<i class="ri-separator"></i><span>Components</span></li>')
                    ->addParentClass('iq-menu-title')
                )
                ->submenu(
                    Spatie\Menu\Link::to('#', '<i class="ri-pencil-ruler-line"></i><span>UI Elements</span><i class="ri-arrow-right-s-line iq-arrow-right"></i>')
                        ->addClass('iq-waves-effect'),
                    Menu::new()
                        ->addClass('iq-submenu')
                        // ->route('ui-color', 'Colors')
                        // ->route('ui-typography', 'Typography')
                        // ->route('ui-alert', 'Alerts')
                        // ->route('ui-badges', 'Badges')
                        // ->route('ui-breadcrumb', 'Breadcrumb')
                        // ->route('ui-button', 'Buttons')
                        // ->route('ui-card', 'Cards')
                        // ->route('ui-carousel', 'Carousel')
                        // ->route('ui-video', 'Video')
                        // ->route('ui-grid', 'Grid')
                        // ->route('ui-images', 'Images')
                        // ->route('ui-listgroup', 'Group')
                        // ->route('ui-media', 'Media')
                        // ->route('ui-modal', 'Modal')
                        // ->route('ui-notifications', 'Notifications')
                        // ->route('ui-pagination', 'Pagination')
                        // ->route('ui-popovers', 'Popovers')
                        // ->route('ui-progressbars', 'Progressbars')
                        // ->route('ui-tabs', 'Tabs')
                        // ->route('ui-tooltips', 'Tooltips')
                )
                ->submenu(
                    Spatie\Menu\Link::to('#', '<i class="ri-profile-line"></i><span>Forms</span><i class="ri-arrow-right-s-line iq-arrow-right"></i>')
                        ->addClass('iq-waves-effect'),
                    Menu::new()
                        ->addClass('iq-submenu')
                        // ->route('form-layout', 'Form Elements')
                        // ->route('form-validation', 'Form Validation')
                        // ->route('form-switch', 'Form Switch')
                        // ->route('form-chechbox', 'Form Checkbox')
                        // ->route('form-radio', 'Form Radio')
                )
                ->submenu(
                    Spatie\Menu\Link::to('#', '<i class="ri-table-line"></i><span>Table</span><i class="ri-arrow-right-s-line iq-arrow-right"></i>')
                        ->addClass('iq-waves-effect'),
                    Menu::new()
                        ->addClass('iq-submenu')
                        // ->route('basic-table', 'Basic Tables')
                        // ->route('data-table', 'Data Table')
                        // ->route('edit-table', 'Editable Table')
                )
                ->submenu(
                    Spatie\Menu\Link::to('#', '<i class="ri-pie-chart-box-line"></i><span>Charts</span><i class="ri-arrow-right-s-line iq-arrow-right"></i>')
                        ->addClass('iq-waves-effect'),
                    Menu::new()
                        ->addClass('iq-submenu')
                        // ->route('chart-morris', 'Morris Chart')
                        // ->route('chart-high', 'High Charts')
                        // ->route('chart-am', 'Am Charts')
                        // ->route('chart-apex', 'Apex Chart')
                )
                ->submenu(
                    Spatie\Menu\Link::to('#', '<i class="ri-list-check"></i><span>Icons</span><i class="ri-arrow-right-s-line iq-arrow-right"></i>')
                        ->addClass('iq-waves-effect'),
                    Menu::new()
                        ->addClass('iq-submenu')
                        // ->route('icon-dripicons', 'Dripicons')
                        // ->route('icon-fontawesome', 'Font Awesome 5')
                        // ->route('icon-lineawesome', 'Line Awesome')
                        // ->route('icon-remixicon', 'Remixicon')
                        // ->route('icon-unicons', 'Unicons')
                )
                ->add(Spatie\Menu\Html::raw('<i class="ri-separator"></i><span>Pages</span></li>')
                    ->addParentClass('iq-menu-title')
                )
                ->submenu(
                    Spatie\Menu\Link::to('#', '<i class="ri-pages-line"></i><span>Authentication</span><i class="ri-arrow-right-s-line iq-arrow-right"></i>')
                        ->addClass('iq-waves-effect'),
                    Menu::new()
                        ->addClass('iq-submenu')
                        // ->route('login', 'Login')
                        // ->route('registration', 'Register')
                        // ->route('recover-password', 'Recover Password')
                        // ->route('confirm-email', 'Confirm Mail')
                        // ->route('lock-screen', 'Lock Screen')
                )
                ->submenu(
                    Spatie\Menu\Link::to('#', '<i class="ri-map-pin-user-line"></i><span>Maps</span><i class="ri-arrow-right-s-line iq-arrow-right"></i>')
                        ->addClass('iq-waves-effect'),
                    Menu::new()
                        ->addClass('iq-submenu')
                        // ->route('google-map', 'Google Map')
                )
                ->submenu(
                    Spatie\Menu\Link::to('#', '<i class="ri-pantone-line"></i><span>Extra Pages</span><i class="ri-arrow-right-s-line iq-arrow-right"></i>')
                        ->addClass('iq-waves-effect'),
                    Menu::new()
                        ->addClass('iq-submenu')
                        // ->route('timeline', 'Timeline')
                        // ->route('invoice', 'Invoice')
                        // ->route('blank-pages', 'Blank Page')
                        // ->route('error-400', 'Error 404')
                        // ->route('error-500', 'Error 500')
                        // ->route('pricing', 'Pricing')
                        // ->route('pricing-one', 'Pricing 1')
                        // ->route('maintenance', 'Maintenance')
                        // ->route('comingsoon', 'Coming Soon')
                        // ->route('faq', 'Faq')
                )
        @endphp
        {!! $menu->setActiveFromRequest()->render() !!}
        </nav>
        <div class="p-3"></div>
    </div>
</div>
