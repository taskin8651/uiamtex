<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Site Settings
    Route::apiResource('site-settings', 'SiteSettingsApiController');

    // Pages
    Route::post('pages/media', 'PagesApiController@storeMedia')->name('pages.storeMedia');
    Route::apiResource('pages', 'PagesApiController');

    // Categories
    Route::post('categories/media', 'CategoriesApiController@storeMedia')->name('categories.storeMedia');
    Route::apiResource('categories', 'CategoriesApiController');

    // Products
    Route::post('products/media', 'ProductsApiController@storeMedia')->name('products.storeMedia');
    Route::apiResource('products', 'ProductsApiController');

    // Product Variants
    Route::apiResource('product-variants', 'ProductVariantsApiController');

    // Product Images
    Route::post('product-images/media', 'ProductImagesApiController@storeMedia')->name('product-images.storeMedia');
    Route::apiResource('product-images', 'ProductImagesApiController');

    // Contact Enquiries
    Route::post('contact-enquiries/media', 'ContactEnquiriesApiController@storeMedia')->name('contact-enquiries.storeMedia');
    Route::apiResource('contact-enquiries', 'ContactEnquiriesApiController');

    // Dealership Applications
    Route::post('dealership-applications/media', 'DealershipApplicationsApiController@storeMedia')->name('dealership-applications.storeMedia');
    Route::apiResource('dealership-applications', 'DealershipApplicationsApiController');

    // Amc Enquiries
    Route::post('amc-enquiries/media', 'AmcEnquiriesApiController@storeMedia')->name('amc-enquiries.storeMedia');
    Route::apiResource('amc-enquiries', 'AmcEnquiriesApiController');

    // Upgrade Requests
    Route::apiResource('upgrade-requests', 'UpgradeRequestsApiController');

    // Bulk Quote Requests
    Route::apiResource('bulk-quote-requests', 'BulkQuoteRequestsApiController');

    // Download Requests
    Route::apiResource('download-requests', 'DownloadRequestsApiController');

    // Certifications
    Route::post('certifications/media', 'CertificationsApiController@storeMedia')->name('certifications.storeMedia');
    Route::apiResource('certifications', 'CertificationsApiController');

    // Clients
    Route::post('clients/media', 'ClientsApiController@storeMedia')->name('clients.storeMedia');
    Route::apiResource('clients', 'ClientsApiController');

    // Downloads
    Route::post('downloads/media', 'DownloadsApiController@storeMedia')->name('downloads.storeMedia');
    Route::apiResource('downloads', 'DownloadsApiController');

    // Blog Categories
    Route::apiResource('blog-categories', 'BlogCategoriesApiController');

    // Blog Posts
    Route::post('blog-posts/media', 'BlogPostsApiController@storeMedia')->name('blog-posts.storeMedia');
    Route::apiResource('blog-posts', 'BlogPostsApiController');

    // Faq Categories
    Route::apiResource('faq-categories', 'FaqCategoriesApiController');

    // Faqs
    Route::post('faqs/media', 'FaqsApiController@storeMedia')->name('faqs.storeMedia');
    Route::apiResource('faqs', 'FaqsApiController');

    // End Users
    Route::apiResource('end-users', 'EndUsersApiController');

    // Orders
    Route::apiResource('orders', 'OrdersApiController');

    // Order Items
    Route::apiResource('order-items', 'OrderItemsApiController');

    // Addresses
    Route::apiResource('addresses', 'AddressesApiController');

    // Wishlists
    Route::apiResource('wishlists', 'WishlistsApiController');
});
