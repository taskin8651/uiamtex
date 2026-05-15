<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 18,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 19,
                'title' => 'site_setting_create',
            ],
            [
                'id'    => 20,
                'title' => 'site_setting_edit',
            ],
            [
                'id'    => 21,
                'title' => 'site_setting_show',
            ],
            [
                'id'    => 22,
                'title' => 'site_setting_delete',
            ],
            [
                'id'    => 23,
                'title' => 'site_setting_access',
            ],
            [
                'id'    => 24,
                'title' => 'page_create',
            ],
            [
                'id'    => 25,
                'title' => 'page_edit',
            ],
            [
                'id'    => 26,
                'title' => 'page_show',
            ],
            [
                'id'    => 27,
                'title' => 'page_delete',
            ],
            [
                'id'    => 28,
                'title' => 'page_access',
            ],
            [
                'id'    => 29,
                'title' => 'catalogue_access',
            ],
            [
                'id'    => 30,
                'title' => 'category_create',
            ],
            [
                'id'    => 31,
                'title' => 'category_edit',
            ],
            [
                'id'    => 32,
                'title' => 'category_show',
            ],
            [
                'id'    => 33,
                'title' => 'category_delete',
            ],
            [
                'id'    => 34,
                'title' => 'category_access',
            ],
            [
                'id'    => 35,
                'title' => 'product_create',
            ],
            [
                'id'    => 36,
                'title' => 'product_edit',
            ],
            [
                'id'    => 37,
                'title' => 'product_show',
            ],
            [
                'id'    => 38,
                'title' => 'product_delete',
            ],
            [
                'id'    => 39,
                'title' => 'product_access',
            ],
            [
                'id'    => 40,
                'title' => 'product_variant_create',
            ],
            [
                'id'    => 41,
                'title' => 'product_variant_edit',
            ],
            [
                'id'    => 42,
                'title' => 'product_variant_show',
            ],
            [
                'id'    => 43,
                'title' => 'product_variant_delete',
            ],
            [
                'id'    => 44,
                'title' => 'product_variant_access',
            ],
            [
                'id'    => 45,
                'title' => 'product_image_create',
            ],
            [
                'id'    => 46,
                'title' => 'product_image_edit',
            ],
            [
                'id'    => 47,
                'title' => 'product_image_show',
            ],
            [
                'id'    => 48,
                'title' => 'product_image_delete',
            ],
            [
                'id'    => 49,
                'title' => 'product_image_access',
            ],
            [
                'id'    => 50,
                'title' => 'leads_form_access',
            ],
            [
                'id'    => 51,
                'title' => 'contact_enquiry_create',
            ],
            [
                'id'    => 52,
                'title' => 'contact_enquiry_edit',
            ],
            [
                'id'    => 53,
                'title' => 'contact_enquiry_show',
            ],
            [
                'id'    => 54,
                'title' => 'contact_enquiry_delete',
            ],
            [
                'id'    => 55,
                'title' => 'contact_enquiry_access',
            ],
            [
                'id'    => 56,
                'title' => 'dealership_application_create',
            ],
            [
                'id'    => 57,
                'title' => 'dealership_application_edit',
            ],
            [
                'id'    => 58,
                'title' => 'dealership_application_show',
            ],
            [
                'id'    => 59,
                'title' => 'dealership_application_delete',
            ],
            [
                'id'    => 60,
                'title' => 'dealership_application_access',
            ],
            [
                'id'    => 61,
                'title' => 'amc_enquiry_create',
            ],
            [
                'id'    => 62,
                'title' => 'amc_enquiry_edit',
            ],
            [
                'id'    => 63,
                'title' => 'amc_enquiry_show',
            ],
            [
                'id'    => 64,
                'title' => 'amc_enquiry_delete',
            ],
            [
                'id'    => 65,
                'title' => 'amc_enquiry_access',
            ],
            [
                'id'    => 66,
                'title' => 'upgrade_request_create',
            ],
            [
                'id'    => 67,
                'title' => 'upgrade_request_edit',
            ],
            [
                'id'    => 68,
                'title' => 'upgrade_request_show',
            ],
            [
                'id'    => 69,
                'title' => 'upgrade_request_delete',
            ],
            [
                'id'    => 70,
                'title' => 'upgrade_request_access',
            ],
            [
                'id'    => 71,
                'title' => 'bulk_quote_request_create',
            ],
            [
                'id'    => 72,
                'title' => 'bulk_quote_request_edit',
            ],
            [
                'id'    => 73,
                'title' => 'bulk_quote_request_show',
            ],
            [
                'id'    => 74,
                'title' => 'bulk_quote_request_delete',
            ],
            [
                'id'    => 75,
                'title' => 'bulk_quote_request_access',
            ],
            [
                'id'    => 76,
                'title' => 'download_request_create',
            ],
            [
                'id'    => 77,
                'title' => 'download_request_edit',
            ],
            [
                'id'    => 78,
                'title' => 'download_request_show',
            ],
            [
                'id'    => 79,
                'title' => 'download_request_delete',
            ],
            [
                'id'    => 80,
                'title' => 'download_request_access',
            ],
            [
                'id'    => 81,
                'title' => 'trust_marketing_access',
            ],
            [
                'id'    => 82,
                'title' => 'certification_create',
            ],
            [
                'id'    => 83,
                'title' => 'certification_edit',
            ],
            [
                'id'    => 84,
                'title' => 'certification_show',
            ],
            [
                'id'    => 85,
                'title' => 'certification_delete',
            ],
            [
                'id'    => 86,
                'title' => 'certification_access',
            ],
            [
                'id'    => 87,
                'title' => 'client_create',
            ],
            [
                'id'    => 88,
                'title' => 'client_edit',
            ],
            [
                'id'    => 89,
                'title' => 'client_show',
            ],
            [
                'id'    => 90,
                'title' => 'client_delete',
            ],
            [
                'id'    => 91,
                'title' => 'client_access',
            ],
            [
                'id'    => 92,
                'title' => 'download_create',
            ],
            [
                'id'    => 93,
                'title' => 'download_edit',
            ],
            [
                'id'    => 94,
                'title' => 'download_show',
            ],
            [
                'id'    => 95,
                'title' => 'download_delete',
            ],
            [
                'id'    => 96,
                'title' => 'download_access',
            ],
            [
                'id'    => 97,
                'title' => 'blog_faq_access',
            ],
            [
                'id'    => 98,
                'title' => 'blog_category_create',
            ],
            [
                'id'    => 99,
                'title' => 'blog_category_edit',
            ],
            [
                'id'    => 100,
                'title' => 'blog_category_show',
            ],
            [
                'id'    => 101,
                'title' => 'blog_category_delete',
            ],
            [
                'id'    => 102,
                'title' => 'blog_category_access',
            ],
            [
                'id'    => 103,
                'title' => 'blog_post_create',
            ],
            [
                'id'    => 104,
                'title' => 'blog_post_edit',
            ],
            [
                'id'    => 105,
                'title' => 'blog_post_show',
            ],
            [
                'id'    => 106,
                'title' => 'blog_post_delete',
            ],
            [
                'id'    => 107,
                'title' => 'blog_post_access',
            ],
            [
                'id'    => 108,
                'title' => 'faq_category_create',
            ],
            [
                'id'    => 109,
                'title' => 'faq_category_edit',
            ],
            [
                'id'    => 110,
                'title' => 'faq_category_show',
            ],
            [
                'id'    => 111,
                'title' => 'faq_category_delete',
            ],
            [
                'id'    => 112,
                'title' => 'faq_category_access',
            ],
            [
                'id'    => 113,
                'title' => 'faq_create',
            ],
            [
                'id'    => 114,
                'title' => 'faq_edit',
            ],
            [
                'id'    => 115,
                'title' => 'faq_show',
            ],
            [
                'id'    => 116,
                'title' => 'faq_delete',
            ],
            [
                'id'    => 117,
                'title' => 'faq_access',
            ],
            [
                'id'    => 118,
                'title' => 'customers_commerce_access',
            ],
            [
                'id'    => 119,
                'title' => 'end_user_create',
            ],
            [
                'id'    => 120,
                'title' => 'end_user_edit',
            ],
            [
                'id'    => 121,
                'title' => 'end_user_show',
            ],
            [
                'id'    => 122,
                'title' => 'end_user_delete',
            ],
            [
                'id'    => 123,
                'title' => 'end_user_access',
            ],
            [
                'id'    => 124,
                'title' => 'order_create',
            ],
            [
                'id'    => 125,
                'title' => 'order_edit',
            ],
            [
                'id'    => 126,
                'title' => 'order_show',
            ],
            [
                'id'    => 127,
                'title' => 'order_delete',
            ],
            [
                'id'    => 128,
                'title' => 'order_access',
            ],
            [
                'id'    => 129,
                'title' => 'order_item_create',
            ],
            [
                'id'    => 130,
                'title' => 'order_item_edit',
            ],
            [
                'id'    => 131,
                'title' => 'order_item_show',
            ],
            [
                'id'    => 132,
                'title' => 'order_item_delete',
            ],
            [
                'id'    => 133,
                'title' => 'order_item_access',
            ],
            [
                'id'    => 134,
                'title' => 'address_create',
            ],
            [
                'id'    => 135,
                'title' => 'address_edit',
            ],
            [
                'id'    => 136,
                'title' => 'address_show',
            ],
            [
                'id'    => 137,
                'title' => 'address_delete',
            ],
            [
                'id'    => 138,
                'title' => 'address_access',
            ],
            [
                'id'    => 139,
                'title' => 'wishlist_create',
            ],
            [
                'id'    => 140,
                'title' => 'wishlist_edit',
            ],
            [
                'id'    => 141,
                'title' => 'wishlist_show',
            ],
            [
                'id'    => 142,
                'title' => 'wishlist_delete',
            ],
            [
                'id'    => 143,
                'title' => 'wishlist_access',
            ],
            [
                'id'    => 144,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
