<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none amtex-sidebar-brand">
        <a class="c-sidebar-brand-full h4 amtex-brand-link" href="{{ route('admin.home') }}">
            <img src="{{ asset('img/logo.png') }}" class="amtex-brand-logo" alt="{{ trans('panel.site_title') }}">
            <span class="amtex-brand-title">{{ trans('panel.site_title') }}</span>
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li>
            <select class="searchable-field form-control">

            </select>
        </li>

        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt"></i>
                {{ trans('global.dashboard') }}
            </a>
        </li>

        {{-- =================== USER MANAGEMENT =================== --}}
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/users*") ? "c-show" : "" }} {{ request()->is("admin/audit-logs*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon"></i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon"></i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan

                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon"></i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan

                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon"></i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan

                    @can('audit_log_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.audit-logs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/audit-logs*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-file-alt c-sidebar-nav-icon"></i>
                                {{ trans('cruds.auditLog.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        {{-- =================== CATALOGUE =================== --}}
        @can('catalogue_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/categories*") ? "c-show" : "" }} {{ request()->is("admin/products*") ? "c-show" : "" }} {{ request()->is("admin/product-variants*") ? "c-show" : "" }} {{ request()->is("admin/product-images*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fab fa-accusoft c-sidebar-nav-icon"></i>
                    {{ trans('cruds.catalogue.title') }}
                </a>

                <ul class="c-sidebar-nav-dropdown-items">
                    @can('category_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/categories*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-angle-double-right c-sidebar-nav-icon"></i>
                                {{ trans('cruds.category.title') }}
                            </a>
                        </li>
                    @endcan

                    @can('product_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.products.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/products*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-angle-double-right c-sidebar-nav-icon"></i>
                                {{ trans('cruds.product.title') }}
                            </a>
                        </li>
                    @endcan

                    @can('product_variant_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.product-variants.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/product-variants*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-angle-double-right c-sidebar-nav-icon"></i>
                                {{ trans('cruds.productVariant.title') }}
                            </a>
                        </li>
                    @endcan

                    @can('product_image_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.product-images.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/product-images*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-angle-double-right c-sidebar-nav-icon"></i>
                                {{ trans('cruds.productImage.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        {{-- =================== SERVICES (NEW DROPDOWN) =================== --}}
        @can('service_access')
            <li class="c-sidebar-nav-dropdown
                {{ request()->is('admin/services*') ? 'c-show' : '' }}
                {{ request()->is('admin/service-process-steps*') ? 'c-show' : '' }}
                {{ request()->is('admin/service-features*') ? 'c-show' : '' }}
                {{ request()->is('admin/industries*') ? 'c-show' : '' }}
                {{ request()->is('admin/service-enquiries*') ? 'c-show' : '' }}
            ">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-tools c-sidebar-nav-icon"></i>
                    Services
                </a>

                <ul class="c-sidebar-nav-dropdown-items">

                    {{-- Services --}}
                    @can('service_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.services.index') }}"
                               class="c-sidebar-nav-link {{ request()->is('admin/services*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-angle-double-right c-sidebar-nav-icon"></i>
                                Services
                            </a>
                        </li>
                    @endcan

                    {{-- Service Process Steps --}}
                    @can('service_process_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.service-process-steps.index') }}"
                               class="c-sidebar-nav-link {{ request()->is('admin/service-process-steps*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-angle-double-right c-sidebar-nav-icon"></i>
                                Service Process
                            </a>
                        </li>
                    @endcan

                    {{-- Service Features --}}
                    @can('service_feature_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.service-features.index') }}"
                               class="c-sidebar-nav-link {{ request()->is('admin/service-features*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-angle-double-right c-sidebar-nav-icon"></i>
                                Service Features
                            </a>
                        </li>
                    @endcan

                    {{-- Industries --}}
                    @can('industry_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.industries.index') }}"
                               class="c-sidebar-nav-link {{ request()->is('admin/industries*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-angle-double-right c-sidebar-nav-icon"></i>
                                Industries
                            </a>
                        </li>
                    @endcan

                    {{-- Service Enquiries --}}
                    @can('service_enquiry_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.service-enquiries.index') }}"
                               class="c-sidebar-nav-link {{ request()->is('admin/service-enquiries*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-angle-double-right c-sidebar-nav-icon"></i>
                                Service Enquiries
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>
        @endcan

        {{-- =================== LEADS FORM =================== --}}
        @can('leads_form_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/contact-enquiries*") ? "c-show" : "" }} {{ request()->is("admin/dealership-applications*") ? "c-show" : "" }} {{ request()->is("admin/amc-enquiries*") ? "c-show" : "" }} {{ request()->is("admin/upgrade-requests*") ? "c-show" : "" }} {{ request()->is("admin/bulk-quote-requests*") ? "c-show" : "" }} {{ request()->is("admin/download-requests*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw far fa-comment c-sidebar-nav-icon"></i>
                    {{ trans('cruds.leadsForm.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('contact_enquiry_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.contact-enquiries.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/contact-enquiries*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-angle-double-right c-sidebar-nav-icon"></i>
                                {{ trans('cruds.contactEnquiry.title') }}
                            </a>
                        </li>
                    @endcan

                    @can('dealership_application_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.dealership-applications.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/dealership-applications*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-angle-double-right c-sidebar-nav-icon"></i>
                                {{ trans('cruds.dealershipApplication.title') }}
                            </a>
                        </li>
                    @endcan

                    @can('amc_enquiry_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.amc-enquiries.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/amc-enquiries*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-angle-double-right c-sidebar-nav-icon"></i>
                                {{ trans('cruds.amcEnquiry.title') }}
                            </a>
                        </li>
                    @endcan

                    @can('upgrade_request_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.upgrade-requests.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/upgrade-requests*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-angle-double-right c-sidebar-nav-icon"></i>
                                {{ trans('cruds.upgradeRequest.title') }}
                            </a>
                        </li>
                    @endcan

                    @can('bulk_quote_request_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.bulk-quote-requests.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/bulk-quote-requests*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-angle-double-right c-sidebar-nav-icon"></i>
                                {{ trans('cruds.bulkQuoteRequest.title') }}
                            </a>
                        </li>
                    @endcan

                    @can('download_request_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.download-requests.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/download-requests*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-angle-double-right c-sidebar-nav-icon"></i>
                                {{ trans('cruds.downloadRequest.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        {{-- =================== TRUST & MARKETING =================== --}}
        @can('trust_marketing_access')
            <li class="c-sidebar-nav-dropdown
                {{ request()->is('admin/certifications*') ? 'c-show' : '' }}
                {{ request()->is('admin/clients*') ? 'c-show' : '' }}
                {{ request()->is('admin/downloads*') ? 'c-show' : '' }}
                {{ request()->is('admin/testimonials*') ? 'c-show' : '' }}
            ">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-truck-loading c-sidebar-nav-icon"></i>
                    {{ trans('cruds.trustMarketing.title') }}
                </a>

                <ul class="c-sidebar-nav-dropdown-items">

                    @can('certification_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.certifications.index') }}"
                               class="c-sidebar-nav-link {{ request()->is('admin/certifications*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-angle-double-right c-sidebar-nav-icon"></i>
                                {{ trans('cruds.certification.title') }}
                            </a>
                        </li>
                    @endcan

                    @can('client_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.clients.index') }}"
                               class="c-sidebar-nav-link {{ request()->is('admin/clients*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-angle-double-right c-sidebar-nav-icon"></i>
                                {{ trans('cruds.client.title') }}
                            </a>
                        </li>
                    @endcan

                    @can('download_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.downloads.index') }}"
                               class="c-sidebar-nav-link {{ request()->is('admin/downloads*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-angle-double-right c-sidebar-nav-icon"></i>
                                {{ trans('cruds.download.title') }}
                            </a>
                        </li>
                    @endcan

                    @can('testimonial_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.testimonials.index') }}"
                               class="c-sidebar-nav-link {{ request()->is('admin/testimonials*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-angle-double-right c-sidebar-nav-icon"></i>
                                Testimonials
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>
        @endcan

        {{-- =================== BLOG & FAQ =================== --}}
        @can('blog_faq_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/blog-categories*") ? "c-show" : "" }} {{ request()->is("admin/blog-posts*") ? "c-show" : "" }} {{ request()->is("admin/faq-categories*") ? "c-show" : "" }} {{ request()->is("admin/faqs*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fab fa-blogger-b c-sidebar-nav-icon"></i>
                    {{ trans('cruds.blogFaq.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('blog_category_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.blog-categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/blog-categories*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-angle-double-right c-sidebar-nav-icon"></i>
                                {{ trans('cruds.blogCategory.title') }}
                            </a>
                        </li>
                    @endcan

                    @can('blog_post_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.blog-posts.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/blog-posts*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-angle-double-right c-sidebar-nav-icon"></i>
                                {{ trans('cruds.blogPost.title') }}
                            </a>
                        </li>
                    @endcan

                    @can('faq_category_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.faq-categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/faq-categories*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-angle-double-right c-sidebar-nav-icon"></i>
                                {{ trans('cruds.faqCategory.title') }}
                            </a>
                        </li>
                    @endcan

                    @can('faq_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.faqs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/faqs*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-angle-double-right c-sidebar-nav-icon"></i>
                                {{ trans('cruds.faq.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        {{-- =================== CUSTOMERS & COMMERCE =================== --}}
        @can('customers_commerce_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/end-users*") ? "c-show" : "" }} {{ request()->is("admin/orders*") ? "c-show" : "" }} {{ request()->is("admin/order-items*") ? "c-show" : "" }} {{ request()->is("admin/addresses*") ? "c-show" : "" }} {{ request()->is("admin/wishlists*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cubes c-sidebar-nav-icon"></i>
                    {{ trans('cruds.customersCommerce.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('end_user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.end-users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/end-users*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-angle-double-right c-sidebar-nav-icon"></i>
                                {{ trans('cruds.endUser.title') }}
                            </a>
                        </li>
                    @endcan

                    @can('order_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.orders.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/orders*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-angle-double-right c-sidebar-nav-icon"></i>
                                {{ trans('cruds.order.title') }}
                            </a>
                        </li>
                    @endcan

                    @can('order_item_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.order-items.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/order-items*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-angle-double-right c-sidebar-nav-icon"></i>
                                {{ trans('cruds.orderItem.title') }}
                            </a>
                        </li>
                    @endcan

                    @can('address_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.addresses.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/addresses*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-angle-double-right c-sidebar-nav-icon"></i>
                                {{ trans('cruds.address.title') }}
                            </a>
                        </li>
                    @endcan

                    @can('wishlist_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.wishlists.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/wishlists*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-angle-double-right c-sidebar-nav-icon"></i>
                                {{ trans('cruds.wishlist.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        {{-- =================== Gallery =================== --}}
        @can('work_gallery_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route('admin.work-galleries.index') }}"
                class="c-sidebar-nav-link {{ request()->is('admin/work-galleries*') ? 'c-active' : '' }}">
                    <i class="fa-fw fas fa-images c-sidebar-nav-icon"></i>
                    Work Gallery
                </a>
            </li>
        @endcan

        {{-- =================== PAGES =================== --}}
        @can('page_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.pages.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/pages*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-file-alt c-sidebar-nav-icon"></i>
                    {{ trans('cruds.page.title') }}
                </a>
            </li>
        @endcan

        {{-- =================== SITE SETTINGS =================== --}}
        @can('site_setting_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.site-settings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/site-settings*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon"></i>
                    {{ trans('cruds.siteSetting.title') }}
                </a>
            </li>
        @endcan

        {{-- =================== MESSENGER =================== --}}
        @php($unread = \App\Models\QaTopic::unreadCount())
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.messenger.index") }}" class="{{ request()->is("admin/messenger*") ? "c-active" : "" }} c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fa-fw fa fa-envelope"></i>
                <span>{{ trans('global.messages') }}</span>
                @if($unread > 0)
                    <strong>( {{ $unread }} )</strong>
                @endif
            </a>
        </li>

        {{-- =================== CHANGE PASSWORD =================== --}}
        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key c-sidebar-nav-icon"></i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endcan
        @endif

        {{-- =================== LOGOUT =================== --}}
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt"></i>
                {{ trans('global.logout') }}
            </a>
        </li>

    </ul>

</div>
