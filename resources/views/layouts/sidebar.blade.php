<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-block">
                <div class="logo text-center">
                    <a href="{{ url('home') }}">
                        <img src="{{ $company_logo ?? ''}}"
                             data-custom-image="{{url('assets/images/logo/sidebar_logo.png')}}" alt="Logo" srcset="">
                    </a>
                </div>
            </div>
        </div>

        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-item">
                    <a href="{{ url('home') }}" class='sidebar-link'>
                        <i class="bi  bi-house"></i>
                        <span class="menu-item">{{ __('Dashboard') }}</span>
                    </a>
                </li>
                @canany(['category-list','category-create','category-update','category-delete','custom-field-list','custom-field-create','custom-field-update','custom-field-delete'])
                    <div class="sidebar-new-title">{{ __('Ads Listing') }}</div>
                    @canany(['category-list','category-create','category-update','category-delete'])
                        <li class="sidebar-item sidebar-submenus">
                            <a href="{{ route('category.index') }}" class='sidebar-link'>
                                <i class="bi bi-list-task"></i>
                                <span class="menu-item">{{ __('Categories') }}</span>
                            </a>
                        </li>
                    @endcanany

                    @canany(['custom-field-list','custom-field-create','custom-field-update','custom-field-delete'])
                        <li class="sidebar-item sidebar-submenus">
                            <a href="{{ route('custom-fields.index') }} " class='sidebar-link'>
                                <i class="bi bi-columns-gap"></i>
                                <span class="menu-item">{{ __('Custom Fields') }}</span>
                            </a>
                        </li>
                    @endcanany
                @endcanany

                @canany(['item-list','item-create','item-update','item-delete','tip-list','tip-create','tip-update','tip-delete'])

                    <div class="sidebar-new-title">{{ __('Items Management') }}</div>
                    @canany(['item-list','item-create','item-update','item-delete'])
                        <li class="sidebar-item">
                            <a href="{{ url('item') }}" class='sidebar-link'>
                                <i class="bi bi-ui-radios-grid"></i>
                                <span class="menu-item">{{ __('Items') }}</span>
                            </a>
                        </li>
                    @endcanany
                    @canany(['tip-list','tip-create','tip-update','tip-delete'])
                        <li class="sidebar-item">
                            <a href="{{ route('tips.index') }}" class='sidebar-link'>
                                <i class="bi bi-info-circle"></i>
                                <span class="menu-item">{{ __('Tips') }}</span>
                            </a>
                        </li>
                    @endcanany
                @endcanany


                @canany(['item-listing-package-list','item-listing-package-create','item-listing-package-update','item-listing-package-delete'])
                    <div class="sidebar-new-title">{{ __('Package Management') }}</div>
                    @canany(['item-listing-package-list','item-listing-package-create','item-listing-package-update','item-listing-package-delete','advertisement-package-list','advertisement-package-create','advertisement-package-update','advertisement-package-delete'])
                        <li class="sidebar-item sidebar-submenus">
                            <a href="{{ route('package.index') }}" class='sidebar-link'>
                                <i class="bi bi-list"></i>
                                <span class="menu-item">{{ __('Item Listing Package') }}</span>
                            </a>
                        </li>
                    @endcanany

                    @canany(['advertisement-package-list','advertisement-package-create','advertisement-package-update','advertisement-package-delete','user-package-list'])
                        <li class="sidebar-item sidebar-submenus">
                            <a href="{{ route('package.advertisement.index') }}" class='sidebar-link'>
                                <i class="bi bi-badge-ad"></i>
                                <span class="menu-item">{{ __('Advertisement Package') }}</span>
                            </a>
                        </li>
                    @endcanany

                    @can('user-package-list')
                        <li class="sidebar-item sidebar-submenus">
                            <a href="{{ route('package.users.index') }}" class='sidebar-link'>
                                <i class="bi bi-person-badge-fill"></i>
                                <span class="menu-item">{{ __('User Packages') }}</span>
                            </a>
                        </li>
                    @endcan

                    @can('payment-transactions-list')
                        <li class="sidebar-item sidebar-submenus">
                            <a href="{{ route('package.payment-transactions.index') }}" class='sidebar-link'>
                                <i class="bi bi-cash-coin"></i>
                                <span class="menu-item">{{ __('Payment Transactions') }}</span>
                            </a>
                        </li>
                    @endcan
                @endcanany

                @canany(['slider-list','slider-create','slider-update','slider-delete','feature-section-list','feature-section-create','feature-section-update','feature-section-delete'])
                    <div class="sidebar-new-title">{{ __('Home Screen Management') }}</div>
                    @canany(['slider-list','slider-create','slider-update','slider-delete'])
                        <li class="sidebar-item">
                            <a href="{{ url('slider') }}" class='sidebar-link'>
                                <i class="bi bi-sliders2"></i>
                                <span class="menu-item">{{ __('Slider') }}</span>
                            </a>
                        </li>
                    @endcanany

                    @canany(['feature-section-list','feature-section-create','feature-section-update','feature-section-delete'])
                        <li class="sidebar-item">
                            <a href="{{ route('feature-section.index') }}" class='sidebar-link'>
                                <i class="bi bi-grid-1x2"></i>
                                <span class="menu-item">{{ __('Feature Section') }}</span>
                            </a>
                        </li>
                    @endcanany
                @endcanany

                @canany(['country-list','country-create','country-update','country-delete','state-list','state-create','state-update','state-delete','city-list','city-create','city-update','city-delete'])
                    <div class="sidebar-new-title">{{ __('Place/Location Management') }}</div>
                    @canany(['country-list','country-create','country-update','country-delete'])
                        <li class="sidebar-item">
                            <a href="{{ route('countries.index') }}" class='sidebar-link'>
                                <i class="bi bi-globe"></i>
                                <span class="menu-item">{{ __('Countries') }}</span>
                            </a>
                        </li>
                    @endcanany

                    @canany(['state-list','state-create','state-update','state-delete'])
                        <li class="sidebar-item">
                            <a href="{{ route('states.index') }}" class='sidebar-link'>
                                <i class="fa fa-map-marked-alt"></i>
                                <span class="menu-item">{{ __('States') }}</span>
                            </a>
                        </li>
                    @endcanany

                    @canany(['city-list','city-create','city-update','city-delete'])
                        <li class="sidebar-item">
                            <a href="{{ route('cities.index') }}" class='sidebar-link'>
                                <i class="fa fa-map-marker-alt"></i>
                                <span class="menu-item">{{ __('Cities') }}</span>
                            </a>
                        </li>
                    @endcanany

                    @canany(['area-list','area-create','area-update','area-delete'])
                        <li class="sidebar-item">
                            <a href="{{ route('area.index') }}" class='sidebar-link'>
                                <i class="fa fa-map-marker"></i>
                                <span class="menu-item">{{ __('Areas') }}</span>
                            </a>
                        </li>
                    @endcanany
                @endcanany

                @canany(['report-reason-list','report-reason-create','report-reason-update','report-reason-delete','user-report-list','user-report-create','user-report-update','user-report-delete'])
                    <div class="sidebar-new-title">{{ __('Reports Management') }}</div>
                    @canany(['report-reason-list','report-reason-create','report-reason-update','report-reason-delete'])
                        <li class="sidebar-item">
                            <a href="{{ route('report-reasons.index') }}" class='sidebar-link'>
                                <i class="bi bi-flag"></i>
                                <span class="menu-item">{{ __('Report Reasons') }}</span>
                            </a>
                        </li>
                    @endcanany

                    @canany(['user-report-list','user-report-create','user-report-update','user-report-delete'])
                        <li class="sidebar-item">
                            <a href="{{route('report-reasons.user-reports.index')}}" class='sidebar-link'>
                                <i class="bi bi-person"></i>
                                <span class="menu-item">{{ __('User Reports') }}</span>
                            </a>
                        </li>
                    @endcanany
                @endcanany

                @canany(['custom-field-list','custom-field-create','custom-field-update','custom-field-delete','customer-list','customer-create','customer-update','customer-delete'])
                    <div class="sidebar-new-title">{{ __('Promotional Management') }}</div>
                    @canany(['custom-field-list','custom-field-create','custom-field-update','custom-field-delete'])
                        <li class="sidebar-item">
                            <a href="{{ url('notification') }}" class='sidebar-link'>
                                <i class="bi bi-bell"></i>
                                <span class="menu-item">{{ __('Send Notification') }}</span>
                            </a>
                        </li>
                    @endcanany

                    @canany(['customer-list','customer-create','customer-update','customer-delete'])
                        <div class="sidebar-new-title">{{ __('Customers') }}</div>
                        <li class="sidebar-item">
                            <a href="{{ url('customer') }}" class='sidebar-link'>
                                <i class="bi bi-people"></i>
                                <span class="menu-item">{{ __('Customers') }}</span>
                            </a>
                        </li>
                    @endcanany
                @endcanany

                @canany(['role-list','role-create','role-update','role-delete','staff-list','staff-create','staff-update','staff-delete'])
                    <div class="sidebar-new-title">{{ __('Staff Management') }}</div>
                    @canany(['role-list','role-create','role-update','role-delete'])
                        <li class="sidebar-item">
                            <a href="{{ route('roles.index') }}" class='sidebar-link'>
                                <i class="bi bi-person-bounding-box"></i>
                                <span class="menu-item">{{ __('Role') }}</span>
                            </a>
                        </li>
                    @endcanany
                    @canany(['staff-list','staff-create','staff-update','staff-delete'])
                        <li class="sidebar-item">
                            <a href="{{ route('staff.index') }}" class='sidebar-link'>
                                <i class="bi bi-gear"></i>
                                <span class="menu-item">{{ __('Staff Management') }}</span>
                            </a>
                        </li>
                    @endcanany
                @endcanany
                @canany(['blog-ist','blog-create','blog-update','blog-delete'])
                    <div class="sidebar-new-title">{{ __('Blog Management') }}</div>
                    <li class="sidebar-item">
                        <a href="{{ route('blog.index') }}" class='sidebar-link'>
                            <i class="bi bi-pencil"></i>
                            <span class="menu-item">{{ __('Blogs') }}</span>
                        </a>
                    </li>
                @endcanany

                @canany(['faq-create','faq-list','faq-update','faq-delete'])
                    <div class="sidebar-new-title">{{ __('FAQ') }}</div>
                    <li class="sidebar-item">
                        <a href="{{ route('faq.index') }}" class='sidebar-link'>
                            <i class="bi bi-question-square-fill"></i>
                            <span class="menu-item">{{ __('FAQs') }}</span>
                        </a>
                    </li>

                @endcanany


                <div class="sidebar-new-title">{{ __('Web') }}</div>
                <li class="sidebar-item">
                    <a href="{{ route('contact-us.index') }}" class='sidebar-link'>
                        <i class="bi bi-person-bounding-box"></i>
                        <span class="menu-item">{{ __('User Queries') }}</span>
                    </a>
                </li>

                @canany(['settings-update'])
                    <div class="sidebar-new-title">{{ __('System Settings') }}</div>
                    @can('settings-update')
                        <li class="sidebar-item">
                            <a href="{{ route('settings.index') }}" class='sidebar-link'>
                                <i class="bi bi-gear"></i>
                                <span class="menu-item">{{ __('Settings') }}</span>
                            </a>
                        </li>
                    @endcan
                    @if(\Illuminate\Support\Facades\Auth::user()->hasRole('Super Admin'))
                        <li class="sidebar-item">
                            <a href="{{ route('system-update.index') }}" class='sidebar-link'>
                                <i class="bi bi-laptop"></i>
                                <span class="menu-item">{{ __('System Update') }}</span>
                            </a>
                        </li>
                    @endif
                @endcanany
            </ul>
        </div>
    </div>
</div>
