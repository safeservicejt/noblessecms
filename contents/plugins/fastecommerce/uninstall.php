<?php


File::exists(ROOT_PATH.'includes/FastEcommerce.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/Affiliates.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/Products.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/Brands.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/Cart.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/Coupons.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/Customers.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/Discounts.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/Downloads.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/OrderProducts.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/Orders.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/Payments.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/Reviews.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/StoreLogs.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/ProductAttrs.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/ProductBrands.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/ProductDiscounts.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/ProductDownloads.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/ProductImages.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/ProductReviews.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/ProductCategories.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/ProductTags.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/EmailTemplates.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/Notifies.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/GeoZone.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/TaxRates.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/ShippingRates.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/WishList.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/AffiliatesStats.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/AffiliatesWithdraws.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/CollectionsProducts.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/AffiliatesRanks.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/NewsLetter.php',function($filePath){
	unlink($filePath);
});

File::exists(ROOT_PATH.'includes/Vouchers.php',function($filePath){
	unlink($filePath);
});

Database::dropTable('coupons');

Database::dropTable('brands');

Database::dropTable('customers');

Database::dropTable('discounts');

Database::dropTable('downloads');

Database::dropTable('orders');

Database::dropTable('order_products');

Database::dropTable('payment_methods');

Database::dropTable('products');

Database::dropTable('product_attrs');

Database::dropTable('product_brands');

Database::dropTable('product_categories');

Database::dropTable('product_discounts');

Database::dropTable('product_downloads');

Database::dropTable('product_images');

Database::dropTable('product_reviews');

Database::dropTable('product_tags');

Database::dropTable('reviews');

Database::dropTable('store_log');

Database::dropTable('user_withdraws');

Database::dropTable('shippingrates');

Database::dropTable('wishlist');

Database::dropTable('affiliate_stats');

Database::dropTable('affiliate_withdraws');

Database::dropTable('collections_products');

Database::dropTable('affiliate_ranks');

Database::dropTable('newsletters');

Database::dropTable('vouchers');

Database::dropField('categories','orders');

Database::dropField('categories','products');

Dir::remove(ROOT_PATH.'contents/fastecommerce');