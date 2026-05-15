<?php
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\CertificatesClientsController;
use App\Http\Controllers\Frontend\DownloadRequestController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\ServicesController;
use App\Http\Controllers\Frontend\UpgradeExtinguisherController;
use App\Http\Controllers\Frontend\DealershipController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\FaqPageController;
use App\Http\Controllers\Frontend\ProductsController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;

Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Site Settings
    Route::delete('site-settings/destroy', 'SiteSettingsController@massDestroy')->name('site-settings.massDestroy');
    Route::resource('site-settings', 'SiteSettingsController');

    // Pages
    Route::delete('pages/destroy', 'PagesController@massDestroy')->name('pages.massDestroy');
    Route::post('pages/media', 'PagesController@storeMedia')->name('pages.storeMedia');
    Route::post('pages/ckmedia', 'PagesController@storeCKEditorImages')->name('pages.storeCKEditorImages');
    Route::post('pages/parse-csv-import', 'PagesController@parseCsvImport')->name('pages.parseCsvImport');
    Route::post('pages/process-csv-import', 'PagesController@processCsvImport')->name('pages.processCsvImport');
    Route::resource('pages', 'PagesController');

    // Categories
    Route::delete('categories/destroy', 'CategoriesController@massDestroy')->name('categories.massDestroy');
    Route::post('categories/media', 'CategoriesController@storeMedia')->name('categories.storeMedia');
    Route::post('categories/ckmedia', 'CategoriesController@storeCKEditorImages')->name('categories.storeCKEditorImages');
    Route::post('categories/parse-csv-import', 'CategoriesController@parseCsvImport')->name('categories.parseCsvImport');
    Route::post('categories/process-csv-import', 'CategoriesController@processCsvImport')->name('categories.processCsvImport');
    Route::resource('categories', 'CategoriesController');

    // Products
    Route::delete('products/destroy', 'ProductsController@massDestroy')->name('products.massDestroy');
    Route::post('products/media', 'ProductsController@storeMedia')->name('products.storeMedia');
    Route::post('products/ckmedia', 'ProductsController@storeCKEditorImages')->name('products.storeCKEditorImages');
    Route::post('products/parse-csv-import', 'ProductsController@parseCsvImport')->name('products.parseCsvImport');
    Route::post('products/process-csv-import', 'ProductsController@processCsvImport')->name('products.processCsvImport');
    Route::resource('products', 'ProductsController');

    // Product Variants
    Route::delete('product-variants/destroy', 'ProductVariantsController@massDestroy')->name('product-variants.massDestroy');
    Route::post('product-variants/parse-csv-import', 'ProductVariantsController@parseCsvImport')->name('product-variants.parseCsvImport');
    Route::post('product-variants/process-csv-import', 'ProductVariantsController@processCsvImport')->name('product-variants.processCsvImport');
    Route::resource('product-variants', 'ProductVariantsController');

    // Product Images
    Route::delete('product-images/destroy', 'ProductImagesController@massDestroy')->name('product-images.massDestroy');
    Route::post('product-images/media', 'ProductImagesController@storeMedia')->name('product-images.storeMedia');
    Route::post('product-images/ckmedia', 'ProductImagesController@storeCKEditorImages')->name('product-images.storeCKEditorImages');
    Route::post('product-images/parse-csv-import', 'ProductImagesController@parseCsvImport')->name('product-images.parseCsvImport');
    Route::post('product-images/process-csv-import', 'ProductImagesController@processCsvImport')->name('product-images.processCsvImport');
    Route::resource('product-images', 'ProductImagesController');

    // Contact Enquiries
    Route::delete('contact-enquiries/destroy', 'ContactEnquiriesController@massDestroy')->name('contact-enquiries.massDestroy');
    Route::post('contact-enquiries/media', 'ContactEnquiriesController@storeMedia')->name('contact-enquiries.storeMedia');
    Route::post('contact-enquiries/ckmedia', 'ContactEnquiriesController@storeCKEditorImages')->name('contact-enquiries.storeCKEditorImages');
    Route::post('contact-enquiries/parse-csv-import', 'ContactEnquiriesController@parseCsvImport')->name('contact-enquiries.parseCsvImport');
    Route::post('contact-enquiries/process-csv-import', 'ContactEnquiriesController@processCsvImport')->name('contact-enquiries.processCsvImport');
    Route::resource('contact-enquiries', 'ContactEnquiriesController');

    // Dealership Applications
    Route::delete('dealership-applications/destroy', 'DealershipApplicationsController@massDestroy')->name('dealership-applications.massDestroy');
    Route::post('dealership-applications/media', 'DealershipApplicationsController@storeMedia')->name('dealership-applications.storeMedia');
    Route::post('dealership-applications/ckmedia', 'DealershipApplicationsController@storeCKEditorImages')->name('dealership-applications.storeCKEditorImages');
    Route::post('dealership-applications/parse-csv-import', 'DealershipApplicationsController@parseCsvImport')->name('dealership-applications.parseCsvImport');
    Route::post('dealership-applications/process-csv-import', 'DealershipApplicationsController@processCsvImport')->name('dealership-applications.processCsvImport');
    Route::resource('dealership-applications', 'DealershipApplicationsController');

    // Amc Enquiries
    Route::delete('amc-enquiries/destroy', 'AmcEnquiriesController@massDestroy')->name('amc-enquiries.massDestroy');
    Route::post('amc-enquiries/media', 'AmcEnquiriesController@storeMedia')->name('amc-enquiries.storeMedia');
    Route::post('amc-enquiries/ckmedia', 'AmcEnquiriesController@storeCKEditorImages')->name('amc-enquiries.storeCKEditorImages');
    Route::post('amc-enquiries/parse-csv-import', 'AmcEnquiriesController@parseCsvImport')->name('amc-enquiries.parseCsvImport');
    Route::post('amc-enquiries/process-csv-import', 'AmcEnquiriesController@processCsvImport')->name('amc-enquiries.processCsvImport');
    Route::resource('amc-enquiries', 'AmcEnquiriesController');

    // Upgrade Requests
    Route::delete('upgrade-requests/destroy', 'UpgradeRequestsController@massDestroy')->name('upgrade-requests.massDestroy');
    Route::post('upgrade-requests/parse-csv-import', 'UpgradeRequestsController@parseCsvImport')->name('upgrade-requests.parseCsvImport');
    Route::post('upgrade-requests/process-csv-import', 'UpgradeRequestsController@processCsvImport')->name('upgrade-requests.processCsvImport');
    Route::resource('upgrade-requests', 'UpgradeRequestsController');

    // Bulk Quote Requests
    Route::delete('bulk-quote-requests/destroy', 'BulkQuoteRequestsController@massDestroy')->name('bulk-quote-requests.massDestroy');
    Route::post('bulk-quote-requests/parse-csv-import', 'BulkQuoteRequestsController@parseCsvImport')->name('bulk-quote-requests.parseCsvImport');
    Route::post('bulk-quote-requests/process-csv-import', 'BulkQuoteRequestsController@processCsvImport')->name('bulk-quote-requests.processCsvImport');
    Route::resource('bulk-quote-requests', 'BulkQuoteRequestsController');

    // Download Requests
    Route::delete('download-requests/destroy', 'DownloadRequestsController@massDestroy')->name('download-requests.massDestroy');
    Route::post('download-requests/parse-csv-import', 'DownloadRequestsController@parseCsvImport')->name('download-requests.parseCsvImport');
    Route::post('download-requests/process-csv-import', 'DownloadRequestsController@processCsvImport')->name('download-requests.processCsvImport');
    Route::resource('download-requests', 'DownloadRequestsController');

    // Certifications
    Route::delete('certifications/destroy', 'CertificationsController@massDestroy')->name('certifications.massDestroy');
    Route::post('certifications/media', 'CertificationsController@storeMedia')->name('certifications.storeMedia');
    Route::post('certifications/ckmedia', 'CertificationsController@storeCKEditorImages')->name('certifications.storeCKEditorImages');
    Route::post('certifications/parse-csv-import', 'CertificationsController@parseCsvImport')->name('certifications.parseCsvImport');
    Route::post('certifications/process-csv-import', 'CertificationsController@processCsvImport')->name('certifications.processCsvImport');
    Route::resource('certifications', 'CertificationsController');

    // Clients
    Route::delete('clients/destroy', 'ClientsController@massDestroy')->name('clients.massDestroy');
    Route::post('clients/media', 'ClientsController@storeMedia')->name('clients.storeMedia');
    Route::post('clients/ckmedia', 'ClientsController@storeCKEditorImages')->name('clients.storeCKEditorImages');
    Route::post('clients/parse-csv-import', 'ClientsController@parseCsvImport')->name('clients.parseCsvImport');
    Route::post('clients/process-csv-import', 'ClientsController@processCsvImport')->name('clients.processCsvImport');
    Route::resource('clients', 'ClientsController');

    // Downloads
    Route::delete('downloads/destroy', 'DownloadsController@massDestroy')->name('downloads.massDestroy');
    Route::post('downloads/media', 'DownloadsController@storeMedia')->name('downloads.storeMedia');
    Route::post('downloads/ckmedia', 'DownloadsController@storeCKEditorImages')->name('downloads.storeCKEditorImages');
    Route::post('downloads/parse-csv-import', 'DownloadsController@parseCsvImport')->name('downloads.parseCsvImport');
    Route::post('downloads/process-csv-import', 'DownloadsController@processCsvImport')->name('downloads.processCsvImport');
    Route::resource('downloads', 'DownloadsController');

    // Blog Categories
    Route::delete('blog-categories/destroy', 'BlogCategoriesController@massDestroy')->name('blog-categories.massDestroy');
    Route::post('blog-categories/parse-csv-import', 'BlogCategoriesController@parseCsvImport')->name('blog-categories.parseCsvImport');
    Route::post('blog-categories/process-csv-import', 'BlogCategoriesController@processCsvImport')->name('blog-categories.processCsvImport');
    Route::resource('blog-categories', 'BlogCategoriesController');

    // Blog Posts
    Route::delete('blog-posts/destroy', 'BlogPostsController@massDestroy')->name('blog-posts.massDestroy');
    Route::post('blog-posts/media', 'BlogPostsController@storeMedia')->name('blog-posts.storeMedia');
    Route::post('blog-posts/ckmedia', 'BlogPostsController@storeCKEditorImages')->name('blog-posts.storeCKEditorImages');
    Route::post('blog-posts/parse-csv-import', 'BlogPostsController@parseCsvImport')->name('blog-posts.parseCsvImport');
    Route::post('blog-posts/process-csv-import', 'BlogPostsController@processCsvImport')->name('blog-posts.processCsvImport');
    Route::resource('blog-posts', 'BlogPostsController');

    // Faq Categories
    Route::delete('faq-categories/destroy', 'FaqCategoriesController@massDestroy')->name('faq-categories.massDestroy');
    Route::post('faq-categories/parse-csv-import', 'FaqCategoriesController@parseCsvImport')->name('faq-categories.parseCsvImport');
    Route::post('faq-categories/process-csv-import', 'FaqCategoriesController@processCsvImport')->name('faq-categories.processCsvImport');
    Route::resource('faq-categories', 'FaqCategoriesController');

    // Faqs
    Route::delete('faqs/destroy', 'FaqsController@massDestroy')->name('faqs.massDestroy');
    Route::post('faqs/media', 'FaqsController@storeMedia')->name('faqs.storeMedia');
    Route::post('faqs/ckmedia', 'FaqsController@storeCKEditorImages')->name('faqs.storeCKEditorImages');
    Route::post('faqs/parse-csv-import', 'FaqsController@parseCsvImport')->name('faqs.parseCsvImport');
    Route::post('faqs/process-csv-import', 'FaqsController@processCsvImport')->name('faqs.processCsvImport');
    Route::resource('faqs', 'FaqsController');

    // End Users
    Route::delete('end-users/destroy', 'EndUsersController@massDestroy')->name('end-users.massDestroy');
    Route::post('end-users/parse-csv-import', 'EndUsersController@parseCsvImport')->name('end-users.parseCsvImport');
    Route::post('end-users/process-csv-import', 'EndUsersController@processCsvImport')->name('end-users.processCsvImport');
    Route::resource('end-users', 'EndUsersController');

    // Orders
    Route::delete('orders/destroy', 'OrdersController@massDestroy')->name('orders.massDestroy');
    Route::post('orders/parse-csv-import', 'OrdersController@parseCsvImport')->name('orders.parseCsvImport');
    Route::post('orders/process-csv-import', 'OrdersController@processCsvImport')->name('orders.processCsvImport');
    Route::resource('orders', 'OrdersController');

    // Order Items
    Route::delete('order-items/destroy', 'OrderItemsController@massDestroy')->name('order-items.massDestroy');
    Route::post('order-items/parse-csv-import', 'OrderItemsController@parseCsvImport')->name('order-items.parseCsvImport');
    Route::post('order-items/process-csv-import', 'OrderItemsController@processCsvImport')->name('order-items.processCsvImport');
    Route::resource('order-items', 'OrderItemsController');

    // Addresses
    Route::delete('addresses/destroy', 'AddressesController@massDestroy')->name('addresses.massDestroy');
    Route::post('addresses/parse-csv-import', 'AddressesController@parseCsvImport')->name('addresses.parseCsvImport');
    Route::post('addresses/process-csv-import', 'AddressesController@processCsvImport')->name('addresses.processCsvImport');
    Route::resource('addresses', 'AddressesController');

    // Wishlists
    Route::delete('wishlists/destroy', 'WishlistsController@massDestroy')->name('wishlists.massDestroy');
    Route::post('wishlists/parse-csv-import', 'WishlistsController@parseCsvImport')->name('wishlists.parseCsvImport');
    Route::post('wishlists/process-csv-import', 'WishlistsController@processCsvImport')->name('wishlists.processCsvImport');
    Route::resource('wishlists', 'WishlistsController');

    Route::get('global-search', 'GlobalSearchController@search')->name('globalSearch');
    Route::get('messenger', 'MessengerController@index')->name('messenger.index');
    Route::get('messenger/create', 'MessengerController@createTopic')->name('messenger.createTopic');
    Route::post('messenger', 'MessengerController@storeTopic')->name('messenger.storeTopic');
    Route::get('messenger/inbox', 'MessengerController@showInbox')->name('messenger.showInbox');
    Route::get('messenger/outbox', 'MessengerController@showOutbox')->name('messenger.showOutbox');
    Route::get('messenger/{topic}', 'MessengerController@showMessages')->name('messenger.showMessages');
    Route::delete('messenger/{topic}', 'MessengerController@destroyTopic')->name('messenger.destroyTopic');
    Route::post('messenger/{topic}/reply', 'MessengerController@replyToTopic')->name('messenger.reply');
    Route::get('messenger/{topic}/reply', 'MessengerController@showReply')->name('messenger.showReply');

    // Home Hero (Homepage Slider)
    Route::delete('home-heroes/destroy', 'HomeHeroesController@massDestroy')->name('home-heroes.massDestroy');
    Route::resource('home-heroes', 'HomeHeroesController');

    // Testimonial
    Route::resource('testimonials', 'TestimonialsController');
    Route::delete('testimonials/destroy', 'TestimonialsController@massDestroy')->name('testimonials.massDestroy');
    Route::post('testimonials/media', 'TestimonialsController@storeMedia')->name('testimonials.storeMedia');
    Route::post('testimonials/ckmedia', 'TestimonialsController@storeCKEditorImages')->name('testimonials.storeCKEditorImages');
    Route::post('testimonials/parse-csv-import', 'TestimonialsController@parseCsvImport')->name('testimonials.parseCsvImport');
    Route::post('testimonials/process-csv-import', 'TestimonialsController@processCsvImport')->name('testimonials.processCsvImport');

    // Service
    Route::delete('services/destroy', 'ServicesController@massDestroy')->name('services.massDestroy');
    Route::resource('services', 'ServicesController');

    Route::delete('service-process-steps/destroy', 'ServiceProcessStepsController@massDestroy')->name('service-process-steps.massDestroy');
    Route::resource('service-process-steps', 'ServiceProcessStepsController');

   // Industries
    Route::post('industries/parse-csv-import', 'IndustriesController@parseCsvImport')
        ->name('industries.parseCsvImport');

    Route::delete('industries/destroy', 'IndustriesController@massDestroy')
        ->name('industries.massDestroy');

    Route::resource('industries', 'IndustriesController');


    // Service Features
    Route::delete('service-features/destroy', 'ServiceFeaturesController@massDestroy')->name('service-features.massDestroy');
    Route::resource('service-features', 'ServiceFeaturesController');

    // Service Enquiries
    Route::delete('service-enquiries/destroy', 'ServiceEnquiriesController@massDestroy')->name('service-enquiries.massDestroy');
    Route::resource('service-enquiries', 'ServiceEnquiriesController');

    // Work Gallery
    Route::delete('work-galleries/destroy', 'WorkGalleriesController@massDestroy')->name('work-galleries.massDestroy');
    Route::resource('work-galleries', 'WorkGalleriesController');

    // Work Gallery Images
    Route::post('work-galleries/{workGallery}/images', 'WorkGalleryImagesController@store')->name('work-galleries.images.store');
    Route::delete('work-gallery-images/{workGalleryImage}', 'WorkGalleryImagesController@destroy')->name('work-gallery-images.destroy');

});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});


/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact-enquiry', [ContactController::class, 'store'])->name('frontend.contact.store');
Route::get('/pages/{slug}', [PageController::class, 'show'])->name('frontend.pages.show');
Route::get('/certificates-clients', [CertificatesClientsController::class, 'index'])->name('frontend.certificates-clients');
Route::post('/downloads/unlock', [DownloadRequestController::class, 'unlock'])->name('frontend.downloads.unlock');
Route::get('/about', [AboutController::class, 'index'])->name('frontend.about');
Route::get('/services', [ServicesController::class, 'index'])->name('frontend.services');
Route::post('/services/enquiry', [ServicesController::class, 'storeEnquiry'])->name('frontend.services.enquiry.store');
Route::get('/upgrade-your-extinguisher', [UpgradeExtinguisherController::class, 'index'])->name('frontend.upgrade.your.extinguisher');
Route::get('/dealership', [DealershipController::class, 'index'])->name('frontend.dealership');
Route::get('/blog', [BlogController::class, 'index'])->name('frontend.blog');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('frontend.blog.show');
Route::get('/faq', [FaqPageController::class, 'index'])->name('faq');
Route::get('/products', [ProductsController::class, 'index'])->name('frontend.products.index');
Route::get('/products/category/{categorySlug}', [ProductsController::class, 'index'])->name('frontend.products.category');
Route::get('/product/{slug}', [ProductsController::class, 'show'])->name('frontend.products.show');


Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');

Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');

Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');


Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
Route::get('/checkout/success/{order_no}', function ($order_no) {
    return view('frontend.checkout_success', compact('order_no'));
})->name('checkout.success');