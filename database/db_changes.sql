ALTER TABLE `accounts`
ADD COLUMN `ref_name`  varchar(100) NULL AFTER `updated_at`,
ADD COLUMN `ref_id`  bigint(20) NULL AFTER `ref_name`;

ALTER TABLE `banks`
ADD COLUMN `account_id`  bigint(20) NULL AFTER `updated_at`;

ALTER TABLE `accounts`
ADD COLUMN `status`  tinyint(2) NULL DEFAULT 1 AFTER `ref_id`;

ALTER TABLE `customers`
ADD COLUMN `account_id`  bigint(20) NULL AFTER `tax_percentage`;

ALTER TABLE `customers`
MODIFY COLUMN `status`  tinyint(2) NULL DEFAULT 1 AFTER `tax_number`;

ALTER TABLE `bikes`
ADD COLUMN `status`  tinyint(2) NULL DEFAULT 1 AFTER `policy_no`;

ALTER TABLE `sims`
MODIFY COLUMN `status`  tinyint(2) NULL DEFAULT 1 AFTER `fleet_supervisor`;

ALTER TABLE `sims`
MODIFY COLUMN `assign_to`  bigint(20) UNSIGNED NULL AFTER `company`;

ALTER TABLE `bikes`
MODIFY COLUMN `company`  int(11) NULL AFTER `engine`;

ALTER TABLE `leasing_companies`
MODIFY COLUMN `status`  tinyint(2) NULL DEFAULT 1 AFTER `detail`;

ALTER TABLE `garages`
MODIFY COLUMN `status`  tinyint(2) NULL DEFAULT 1 AFTER `detail`;

--------------------

--24-01-2025---
ALTER TABLE `riders`
ADD COLUMN `account_id`  int(11) NULL AFTER `rider_id`;

ALTER TABLE `transactions`
CHANGE COLUMN `entry_id` `trans_code`  bigint(20) NOT NULL AFTER `id`;

DROP TABLE IF EXISTS `vouchers`;
CREATE TABLE `vouchers` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `trans_date` date DEFAULT NULL,
  `trans_code` bigint(20) DEFAULT NULL,
  `posting_date` date DEFAULT NULL,
  `billing_month` date DEFAULT NULL,
  `payment_to` bigint(20) DEFAULT NULL,
  `payment_from` bigint(20) DEFAULT NULL,
  `payment_type` tinyint(2) DEFAULT NULL,
  `voucher_type` tinyint(2) DEFAULT 1,
  `reason` varchar(255) DEFAULT NULL,
  `amount` decimal(30,2) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `ref_id` bigint(20) DEFAULT NULL,
  `rider_id` bigint(20) DEFAULT NULL,
  `vendor_id` bigint(20) DEFAULT NULL,
  `status` tinyint(2) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `invoice_voucher_type` tinyint(2) DEFAULT NULL,
  `Created_By` int(11) DEFAULT NULL,
  `toll_gate` varchar(50) DEFAULT NULL,
  `trip_date` datetime DEFAULT NULL,
  `direction` varchar(255) DEFAULT NULL,
  `lease_company` bigint(20) DEFAULT NULL,
  `Updated_By` int(11) DEFAULT NULL,
  `attach_file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

---------------

ALTER TABLE `accounts`
MODIFY COLUMN `account_code`  varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL AFTER `id`;

-----------------------

ALTER TABLE `accounts`
ADD COLUMN `notes`  varchar(500) NULL AFTER `status`;

ALTER TABLE `leasing_companies`
ADD COLUMN `account_id`  bigint(20) NULL AFTER `updated_at`;
-------------

ALTER TABLE `vouchers`
MODIFY COLUMN `voucher_type`  varchar(20) NULL DEFAULT '1' AFTER `payment_type`;
--------------

INSERT INTO `permissions` (`parent_id`, `name`, `guard_name`) VALUES ('102', 'voucher_document', 'web');
------------

ALTER TABLE `transactions`
ADD COLUMN `trans_date`  date NULL AFTER `id`;
---------------

ALTER TABLE `rider_invoices`
CHANGE COLUMN `RID` `rider_id`  bigint(20) UNSIGNED NOT NULL AFTER `inv_date`,
CHANGE COLUMN `VID` `vendor_id`  bigint(20) UNSIGNED NOT NULL AFTER `rider_id`;
--------------

ALTER TABLE `items`
ADD COLUMN `status`  tinyint(2) NULL DEFAULT 1 AFTER `vat`;
------------

ALTER TABLE `items`
ADD COLUMN `code`  varchar(50) NULL AFTER `status`,
ADD COLUMN `barcode`  varchar(50) NULL AFTER `code`;
------------

ALTER TABLE `rider_invoices`
MODIFY COLUMN `vendor_id`  bigint(20) UNSIGNED NULL AFTER `rider_id`;
---------------

ALTER TABLE `bikes`
ADD COLUMN `contract_number`  varchar(50) NULL AFTER `status`;
-------------

ALTER TABLE `riders`
ADD COLUMN `shift`  varchar(100) NULL AFTER `policy_no`,
ADD COLUMN `attendance`  varchar(50) NULL AFTER `shift`;
-------
ALTER TABLE `rider_activities`
ADD COLUMN `delivery_rating`  decimal(2,1) NULL DEFAULT NULL AFTER `updated_at`;

ALTER TABLE `rider_activities`
MODIFY COLUMN `payout_type`  varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' AFTER `d_rider_id`;
--------------

ALTER TABLE `rider_activities`
MODIFY COLUMN `delivery_rating`  decimal(4,1) NULL DEFAULT NULL AFTER `updated_at`;
-----------------------

DROP TABLE IF EXISTS `rider_emails`;
CREATE TABLE `rider_emails` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `rider_id` bigint(20) DEFAULT NULL,
  `mail_to` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `status` varchar(20) DEFAULT 'sent',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--------------

ALTER TABLE `files`
ADD COLUMN `name`  varchar(255) NULL AFTER `file_type`;

-------------
ALTER TABLE `riders`
ADD COLUMN `vat`  tinyint(2) NULL DEFAULT 2 AFTER `attendance`;

ALTER TABLE `rider_invoices`
ADD COLUMN `vat`  decimal(10,2) NULL DEFAULT 0 AFTER `notes`;

------------
ALTER TABLE `riders`
ADD COLUMN `attendance_date`  date NULL AFTER `vat`;

---------

ALTER TABLE `accounts`
ADD COLUMN `ref_name`  varchar(100) NULL AFTER `updated_at`,
ADD COLUMN `ref_id`  bigint(20) NULL AFTER `ref_name`;

ALTER TABLE `banks`
ADD COLUMN `account_id`  bigint(20) NULL AFTER `updated_at`;

ALTER TABLE `accounts`
ADD COLUMN `status`  tinyint(2) NULL DEFAULT 1 AFTER `ref_id`;

ALTER TABLE `customers`
ADD COLUMN `account_id`  bigint(20) NULL AFTER `tax_percentage`;

ALTER TABLE `customers`
MODIFY COLUMN `status`  tinyint(2) NULL DEFAULT 1 AFTER `tax_number`;

ALTER TABLE `bikes`
ADD COLUMN `status`  tinyint(2) NULL DEFAULT 1 AFTER `policy_no`;

ALTER TABLE `sims`
MODIFY COLUMN `status`  tinyint(2) NULL DEFAULT 1 AFTER `fleet_supervisor`;

ALTER TABLE `sims`
MODIFY COLUMN `assign_to`  bigint(20) UNSIGNED NULL AFTER `company`;

ALTER TABLE `bikes`
MODIFY COLUMN `company`  int(11) NULL AFTER `engine`;

ALTER TABLE `leasing_companies`
MODIFY COLUMN `status`  tinyint(2) NULL DEFAULT 1 AFTER `detail`;

ALTER TABLE `garages`
MODIFY COLUMN `status`  tinyint(2) NULL DEFAULT 1 AFTER `detail`;

--------------------

--24-01-2025---
ALTER TABLE `riders`
ADD COLUMN `account_id`  int(11) NULL AFTER `rider_id`;

ALTER TABLE `transactions`
CHANGE COLUMN `entry_id` `trans_code`  bigint(20) NOT NULL AFTER `id`;

DROP TABLE IF EXISTS `vouchers`;
CREATE TABLE `vouchers` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `trans_date` date DEFAULT NULL,
  `trans_code` bigint(20) DEFAULT NULL,
  `posting_date` date DEFAULT NULL,
  `billing_month` date DEFAULT NULL,
  `payment_to` bigint(20) DEFAULT NULL,
  `payment_from` bigint(20) DEFAULT NULL,
  `payment_type` tinyint(2) DEFAULT NULL,
  `voucher_type` tinyint(2) DEFAULT 1,
  `reason` varchar(255) DEFAULT NULL,
  `amount` decimal(30,2) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `ref_id` bigint(20) DEFAULT NULL,
  `rider_id` bigint(20) DEFAULT NULL,
  `vendor_id` bigint(20) DEFAULT NULL,
  `status` tinyint(2) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `invoice_voucher_type` tinyint(2) DEFAULT NULL,
  `Created_By` int(11) DEFAULT NULL,
  `toll_gate` varchar(50) DEFAULT NULL,
  `trip_date` datetime DEFAULT NULL,
  `direction` varchar(255) DEFAULT NULL,
  `lease_company` bigint(20) DEFAULT NULL,
  `Updated_By` int(11) DEFAULT NULL,
  `attach_file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

---------------

ALTER TABLE `accounts`
MODIFY COLUMN `account_code`  varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL AFTER `id`;

-----------------------

ALTER TABLE `accounts`
ADD COLUMN `notes`  varchar(500) NULL AFTER `status`;

ALTER TABLE `leasing_companies`
ADD COLUMN `account_id`  bigint(20) NULL AFTER `updated_at`;
-------------

ALTER TABLE `vouchers`
MODIFY COLUMN `voucher_type`  varchar(20) NULL DEFAULT '1' AFTER `payment_type`;
--------------

INSERT INTO `permissions` (`parent_id`, `name`, `guard_name`) VALUES ('102', 'voucher_document', 'web');
------------

ALTER TABLE `transactions`
ADD COLUMN `trans_date`  date NULL AFTER `id`;
---------------

ALTER TABLE `rider_invoices`
CHANGE COLUMN `RID` `rider_id`  bigint(20) UNSIGNED NOT NULL AFTER `inv_date`,
CHANGE COLUMN `VID` `vendor_id`  bigint(20) UNSIGNED NOT NULL AFTER `rider_id`;
--------------

ALTER TABLE `items`
ADD COLUMN `status`  tinyint(2) NULL DEFAULT 1 AFTER `vat`;
------------

ALTER TABLE `items`
ADD COLUMN `code`  varchar(50) NULL AFTER `status`,
ADD COLUMN `barcode`  varchar(50) NULL AFTER `code`;
------------

ALTER TABLE `rider_invoices`
MODIFY COLUMN `vendor_id`  bigint(20) UNSIGNED NULL AFTER `rider_id`;
---------------

ALTER TABLE `bikes`
ADD COLUMN `contract_number`  varchar(50) NULL AFTER `status`;
-------------

ALTER TABLE `riders`
ADD COLUMN `shift`  varchar(100) NULL AFTER `policy_no`,
ADD COLUMN `attendance`  varchar(50) NULL AFTER `shift`;
-------
ALTER TABLE `rider_activities`
ADD COLUMN `delivery_rating`  decimal(2,1) NULL DEFAULT NULL AFTER `updated_at`;

ALTER TABLE `rider_activities`
MODIFY COLUMN `payout_type`  varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' AFTER `d_rider_id`;

-------

CREATE TABLE `suppliers` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `account_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-------

CREATE TABLE `invoice_items` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `item_id` bigint(20) DEFAULT NULL,
  `item_des` varchar(255) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `inv_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-------

CREATE TABLE `supplier_invoice_items` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `item_id` bigint(20) DEFAULT NULL,
  `item_des` varchar(255) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `inv_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


























