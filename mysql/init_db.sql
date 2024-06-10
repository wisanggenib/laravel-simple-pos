-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 03, 2024 at 08:59 AM
-- Server version: 10.5.24-MariaDB-cll-lve
-- PHP Version: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wisn5791_laravel_pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` char(36) NOT NULL,
  `area_name` varchar(255) NOT NULL,
  `area_budget` varchar(255) NOT NULL,
  `area_location` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`id`, `area_name`, `area_budget`, `area_location`, `created_at`, `updated_at`) VALUES
('9be35b86-48c7-4302-87d0-1396d8232f52', 'Yogyakarta', '1000000', 'Yogyakarta', '2024-04-24 18:19:14', '2024-04-24 18:19:14'),
('9c269384-6f1b-49b4-a44b-cfc86888073b', 'HO', '1000000', 'Kalibata', '2024-05-28 04:16:16', '2024-05-28 04:16:16');

-- --------------------------------------------------------

--
-- Table structure for table `carousels`
--

CREATE TABLE `carousels` (
  `id` char(36) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------

--
-- Table structure for table `cut_offs`
--

CREATE TABLE `cut_offs` (
  `id` char(36) NOT NULL,
  `id_area` char(36) NOT NULL,
  `startDate` datetime DEFAULT NULL,
  `endDate` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cut_offs`
--

INSERT INTO `cut_offs` (`id`, `id_area`, `startDate`, `endDate`, `created_at`, `updated_at`) VALUES
('9c2694b4-4c3d-42af-9776-fbe05ffb43f0', '9c269384-6f1b-49b4-a44b-cfc86888073b', '2024-05-25 00:00:00', '2024-05-28 00:00:00', '2024-05-28 04:19:35', '2024-05-28 04:19:35');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2024_03_25_010428_create_areas_table', 1),
(2, '2024_03_25_013740_create_sessions_table', 1),
(3, '2024_03_25_065011_create_users_table', 1),
(4, '2024_03_25_133753_create_product_categories_table', 1),
(5, '2024_04_02_073948_create_cut_offs_table', 1),
(6, '2024_04_02_121502_create_products_table', 1),
(7, '2024_04_13_234854_create_orders_table', 1),
(8, '2024_04_13_235721_create_order_details_table', 1),
(9, '2024_06_04_004438_create_carousels_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` char(36) NOT NULL,
  `id_user` char(36) NOT NULL,
  `status` enum('order','proses','kirim','selesai','tolak') NOT NULL,
  `bukti_po` varchar(255) DEFAULT NULL,
  `tgl_proses` varchar(255) DEFAULT NULL,
  `resi` varchar(255) DEFAULT NULL,
  `tgl_kirim` varchar(255) DEFAULT NULL,
  `bukti_terima` varchar(255) DEFAULT NULL,
  `tgl_diterima` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` char(36) NOT NULL,
  `id_order` char(36) NOT NULL,
  `id_product` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `bukti` varchar(255) NOT NULL,
  `status` enum('proses','terima','reject','ulang') NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` char(36) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_stock` varchar(255) NOT NULL,
  `product_type` enum('satuan','kilo','liter','botol','can','mililiter','lusin','pack','pcs','pouch','pasang') NOT NULL,
  `product_price` bigint(255) NOT NULL,
  `id_category` char(36) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `is_vendor` varchar(255) NOT NULL,
  `vendor_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `product_stock`, `product_type`, `product_price`, `id_category`, `product_description`, `thumbnail`, `is_vendor`, `vendor_name`, `created_at`, `updated_at`) VALUES
('9c0f7ca0-672c-4787-9127-663d08c64ce0', 'kifa powder', '144', 'pcs', 13000, '9c0f78ef-3acc-4331-be27-178a7bd5e17b', 'bubuk pembersih/powder cleaning, Berat: 650gr', '20240516114813.jpg', 'false', '-', '2024-05-16 16:48:13', '2024-05-16 19:46:45'),
('9c0f7cfc-bcff-4390-804d-ce579e602fd2', 'Topas', '42', 'pcs', 15000, '9c0f7769-fee9-417c-8da8-b3a6d5751c75', 'detergen pembersih pakaian ukuran 1kg', '20240516114913.jpg', 'false', '-', '2024-05-16 16:49:13', '2024-05-16 19:46:52'),
('9c0f7d68-4b55-4a8b-b4d6-2040dcc29e3d', 'Rinso 770gr', '5', 'pcs', 0, '9c0f7769-fee9-417c-8da8-b3a6d5751c75', 'detergen pembersih pakaian ukuran 770gr', '20240516115024.jpg', 'false', '-', '2024-05-16 16:50:24', '2024-05-16 19:47:02'),
('9c0f7dd1-7d7c-4270-b69f-b45b218d0522', 'Kain Microfiber Biru', '111', 'pcs', 11000, '9c0f7796-d910-49d3-9536-f4de55fd4007', 'Lap Microfiber, materias:  80% Polyester + 20% Polyamide, ukuran: 35x35cm, warna : biru', '20240516115133.jpg', 'false', '-', '2024-05-16 16:51:33', '2024-05-16 19:47:09'),
('9c0f7e1c-0d21-4ad6-adef-2c2ddbadda27', 'Kain Microfiber Merah', '52', 'pcs', 11000, '9c0f7796-d910-49d3-9536-f4de55fd4007', 'Lap Microfiber, materias:  80% Polyester + 20% Polyamide, ukuran: 35x35cm, warna : merah', '20240516115222.jpg', 'false', '-', '2024-05-16 16:52:22', '2024-05-16 19:47:17'),
('9c0f7ea1-5815-4e56-943a-fdbd77cfb321', 'Refill Nylon Broom', '18', 'pcs', 18000, '9c0f6b6a-b7e7-4b58-b5d7-d02c91870d99', 'Ukuran : 38x19cm\r\nDiameter lubang 2.5 cm', '20240516115349.jpg', 'false', '-', '2024-05-16 16:53:49', '2024-06-02 04:23:46'),
('9c0fbfc2-80db-40f1-a378-b639baca2969', 'Sunlight 1 liter', '7', 'pouch', 25000, '9c0f76e2-14b5-400c-9fa3-9e05738923d6', 'sabun cair ukuran 1 liter', '20240517025556.jpg', 'false', '-', '2024-05-16 19:55:56', '2024-06-02 04:23:58'),
('9c0fc03a-62cb-40b0-8ab0-b23c02d9fb88', 'Plas Chamois', '77', 'pcs', 18000, '9c0f6b6a-b7e7-4b58-b5d7-d02c91870d99', 'material: Polyvinyl Alcohol Sponge, Polyester berat: 0,2gr dimensions: 64cmx43cmx0,2kg', '20240517025714.jpg', 'false', '-', '2024-05-16 19:57:14', '2024-06-02 04:24:12'),
('9c0fc125-d019-4721-b853-a065d241350e', 'Sarung Tangan Karet Orange dan Kuning', '17', 'pcs', 12000, '9c0f6b6a-b7e7-4b58-b5d7-d02c91870d99', 'material: latex, ukuran: m (panjang 32cm, 20.4cm) & L(panjang 32cm, Lebar 22cm), warna: orange dan kuning', '20240517025949.jpg', 'false', '-', '2024-05-16 19:59:49', '2024-06-02 04:24:23'),
('9c0fc1a9-f71a-4a31-a498-68b6d413ad77', 'Reffil Glade Vanilla Wood', '4', 'can', 27500, '9c0f7948-02c9-4505-9a6c-43e4d71d710e', 'Refill Elegant Vanilla & Oudwood 146gr', '20240517030115.jpg', 'false', '-', '2024-05-16 20:01:15', '2024-05-16 20:01:15'),
('9c0fc1f4-0a94-42d0-ae3c-36443dfea13d', 'Reffil Glade Lavender', '2', 'can', 27500, '9c0f7948-02c9-4505-9a6c-43e4d71d710e', 'Refill Elegant lavender 146gr', '20240517030204.jpg', 'false', '-', '2024-05-16 20:02:04', '2024-05-16 20:02:04'),
('9c0fc547-b084-4680-a540-2a2be97b4051', 'Top Ron', '14', 'liter', 29000, '9c0f76e2-14b5-400c-9fa3-9e05738923d6', 'TOPRON CLEAN POWER Pembersih Keramik dan Porcelain 1 Liter', '20240517031122.jpg', 'false', '-', '2024-05-16 20:11:22', '2024-05-16 20:11:22'),
('9c0fc5aa-a900-4eee-b79c-f0c912a8028e', 'Kamper bola isi 5', '17', 'pack', 20000, '9c0f79eb-d0dc-4da4-a736-09f1e023f53c', 'Toilet ball isi 5, bahan: Paradichlorobenze (PDBC)', '20240517031227.jpg', 'false', '-', '2024-05-16 20:12:27', '2024-05-16 20:12:27'),
('9c0fc60a-c186-418c-836c-614601bf2037', 'Scrapper', '31', 'pcs', 18000, '9c0f6c46-d271-4f2c-92bc-430d909dc8ba', 'Tinggi samping 23 cm lebar bagian atas 20 cm. Lebar scraper samping 4 cm. Lebar scraper atas 2.5 cm.', '20240517031330.jpg', 'false', '-', '2024-05-16 20:13:30', '2024-05-16 20:13:30'),
('9c0fcb40-6d3a-4f83-927c-44662f4cab04', 'kuas 1 inch', '36', 'pcs', 8000, '9c0f6c46-d271-4f2c-92bc-430d909dc8ba', 'Harga Untuk 1 Pcs Kuas Cat Tembok 1 Kotak isi 12 Pcs / 1 lusin, Merk : Eterna, Type : 633, Ukuran : 1 inch / 3cm (Lebar Bulu Kuas), Material : Kayu, & Bulu Asli', '20240517032804.jpg', 'false', '-', '2024-05-16 20:28:04', '2024-05-16 20:28:04'),
('9c0fcb9c-23e7-4865-8176-6a5e6eb416c2', 'Kuas 2 inch', '6', 'pcs', 8000, '9c0f6c46-d271-4f2c-92bc-430d909dc8ba', 'SKU: REI-70145-4098, 2\"/7CM gagangnya terbat dari kayu', '20240517032904.jpg', 'false', '-', '2024-05-16 20:29:04', '2024-05-16 20:29:04'),
('9c0fcbd9-3d46-4db6-96ba-e49bfd1f8010', 'Bucket 15 liter', '8', 'pcs', 15000, '9c0f6b6a-b7e7-4b58-b5d7-d02c91870d99', '019LS101, Merek: Lion Star, 1kg, Biru dan Pink, 31cm', '20240517032944.jpg', 'false', '-', '2024-05-16 20:29:44', '2024-06-02 04:25:23'),
('9c0fccaa-9faf-4da3-ac3b-aca07aeaaaf2', 'Sunlight Jeruk Nipis 650 ml', '2', 'pcs', 25000, '9c0f76e2-14b5-400c-9fa3-9e05738923d6', 'sabun cair ukuran 650 ml', '20240517033201.jpg', 'false', '-', '2024-05-16 20:32:01', '2024-05-16 20:32:01'),
('9c0fcd32-9a42-471b-9cce-d46051d90d64', 'Kain Refill Lobby Duster 60cm Cotton Putih', '2', 'pcs', 26000, '9c0f6b6a-b7e7-4b58-b5d7-d02c91870d99', '005NM802, 60cm, Multicolor, 60x20x2cm', '20240517033330.jpg', 'false', '-', '2024-05-16 20:33:30', '2024-06-02 04:25:42'),
('9c0fce54-b1fd-4a01-bb2b-ee87fbb4d3a3', 'Mini dustpant set', '60', 'pcs', 25000, '9c0f6b6a-b7e7-4b58-b5d7-d02c91870d99', '017DRG101, Merek: Dragon, Multicolor, 18x3x21cm', '20240517033640.jpg', 'false', '-', '2024-05-16 20:36:40', '2024-06-02 04:25:55'),
('9c0fcee6-1be0-44f5-9ba3-e8c51fe7755d', 'Sabun colek 350gr', '3', 'pcs', 13000, '9c0f7805-9c30-4f9b-bdf4-f051605d7358', 'Sabun Colek 350gr', '20240517033816.jpg', 'false', '-', '2024-05-16 20:38:16', '2024-05-16 20:38:16'),
('9c0fd0b9-7c66-4f1f-b723-a9d0c2c54016', 'Handsoap johnson(lemon)', '1', 'pcs', 185000, '9c0f76e2-14b5-400c-9fa3-9e05738923d6', 'Befresh Johnson Aroma Lemon kemasan Galon isi 4 liter', '20240517034322.jpg', 'false', '-', '2024-05-16 20:43:22', '2024-05-16 20:43:22'),
('9c0fd1a9-3e85-4586-98a3-9f55a8915201', 'Sikat Tangan Nilon Gagang Kayu tipe 414', '3', 'pcs', 5000, '9c0f6b6a-b7e7-4b58-b5d7-d02c91870d99', '018ETRN127, Eterna, Krem', '20240517034559.jpg', 'false', '-', '2024-05-16 20:45:59', '2024-05-16 20:45:59'),
('9c0fd20f-4c7d-4428-8409-94067581382b', 'Sarung tangan kain bintik', '100', 'pasang', 5000, '9c0f6b6a-b7e7-4b58-b5d7-d02c91870d99', 'sarung tangan bintik karet bagian depan,Jenis PUPergelangan Tangan Karet, Sertifikasi ISO 9001:2008 ; SNI ISO 9001:2015', '20240517034706.jpg', 'false', '-', '2024-05-16 20:47:06', '2024-05-16 20:47:06'),
('9c0fd27f-5e8f-49a2-84d9-ecd0325a5ea3', 'Sarung tangan comet', '90', 'pasang', 15000, '9c0f6b6a-b7e7-4b58-b5d7-d02c91870d99', 'Sarung Tangan Anti Potong/Cut Resistant Glove Comet', '20240517034820.jpg', 'false', '-', '2024-05-16 20:48:20', '2024-06-02 04:26:29'),
('9c0fd31f-86ed-444b-bb0b-1de7916c8743', 'sarung tangan plastik', '21', 'pack', 0, '9c0f6b6a-b7e7-4b58-b5d7-d02c91870d99', 'sarung tangan plastik isi 100pcs', '20240517035004.jpg', 'false', '-', '2024-05-16 20:50:05', '2024-05-16 20:50:05'),
('9c0fd360-5048-485f-b798-0308c086ce5a', 'Super Pell', '7', 'pcs', 15000, '9c0f7906-d7a0-498c-aeec-15db01ff81f3', 'pembersih lantai aroma apel ukuran 800ml', '20240517035047.jpg', 'false', '-', '2024-05-16 20:50:47', '2024-05-16 20:50:47'),
('9c100a5a-9508-4fa2-9078-0153dbc48940', 'Cleaning Cloth ( Merah, Kuning, Hijau)', '37', 'pcs', 65000, '9c0f6b6a-b7e7-4b58-b5d7-d02c91870d99', 'Klenco, 40x40cm, Multicolor', '20240517062431.jpg', 'false', '-', '2024-05-16 23:24:31', '2024-06-02 04:26:54'),
('9c100a8c-7065-42cc-b4ab-1b057cbf6692', 'Hand Brush', '2', 'pcs', 8500, '9c0f6b6a-b7e7-4b58-b5d7-d02c91870d99', 'Merek: Dragon, Pink dan Oranye, 41x21.2x11.4cm', '20240517062503.jpg', 'false', '-', '2024-05-16 23:25:03', '2024-05-16 23:25:03'),
('9c100abe-8b73-42db-82b9-7078c018e318', 'Gayung', '24', 'pcs', 25000, '9c0f7987-ca6e-4e36-9314-cc77d40bb291', 'Gayung Mandi LION STAR Spesifikasi : Diameter 14 cm x tinggi 13 cm, Kapasitas 1,5 lt, Berat Asli 150gram', '20240517062536.jpg', 'false', '-', '2024-05-16 23:25:36', '2024-06-02 04:27:11'),
('9c100bb9-eacf-432e-a6eb-4d3ddd12fea8', 'Sikat Tangkai Nylon 833 \"NGT\"', '4', 'pcs', 48000, '9c0f6b6a-b7e7-4b58-b5d7-d02c91870d99', '\"SKU -\r\n Merek: Nagata\"', '20240517062821.jpg', 'false', '-', '2024-05-16 23:28:21', '2024-05-16 23:28:21'),
('9c100cf0-2e01-4bfa-92b8-f775e4f6d8d8', 'Jas Hujan', '6', 'pcs', 60000, '9c0f741d-831b-440a-89cd-c75bacda3d3f', 'Spec Model Ponco material Plastik PE campuran HD, bahan lebih tebal di banding jas hujan produk china, ukuran nya all size dan lengan panjang, warna random : merah hijau biru, leher ada tali specification : tinggi 100 cm, lebar 80 cm', '20240517063144.jpg', 'false', '-', '2024-05-16 23:31:44', '2024-05-16 23:31:44'),
('9c100d4f-8a91-4769-91f7-b966d3642bf5', 'Wet Mop Refill Biru', '25', 'pcs', 18000, '9c0f6b6a-b7e7-4b58-b5d7-d02c91870d99', '004NM1702, Biru, 35x4x16cm', '20240517063247.jpg', 'false', '-', '2024-05-16 23:32:47', '2024-06-02 04:27:36'),
('9c100dc0-7412-4064-9ec9-13437c98ff81', 'Wet Mop Refill Merah', '30', 'pcs', 18000, '9c0f6b6a-b7e7-4b58-b5d7-d02c91870d99', '004NM1802, Standart, Warna: Merah, 35x4x16cm', '20240517063401.jpg', 'false', '-', '2024-05-16 23:34:01', '2024-05-16 23:34:01'),
('9c100df3-3bed-4986-aa4d-bbdf24c93efe', 'stella air fresher', '10', 'pcs', 10000, '9c0f7948-02c9-4505-9a6c-43e4d71d710e', 'stella airfresher neto: 73gr, aroma orange', '20240517063434.jpg', 'false', '-', '2024-05-16 23:34:34', '2024-05-16 23:34:34'),
('9c100e3f-8959-4aa5-8ef9-8a84eccf62bf', 'Kamper urinoir ( isi 6 bowl)', '0', 'pcs', 20000, '9c0f7948-02c9-4505-9a6c-43e4d71d710e', 'merek : swallow, isi 6', '20240517063524.jpg', 'false', '-', '2024-05-16 23:35:24', '2024-05-16 23:35:24'),
('9c100e73-e5e0-413f-91d9-c93528a5b087', 'PAC', '23', 'pcs', 15000, '9c0f7a71-7203-41a2-808a-2e8da3983c58', 'Poly Aluminium Chloride, ukuran 500gr', '20240517063558.jpg', 'false', '-', '2024-05-16 23:35:58', '2024-05-16 23:35:58'),
('9c100ea7-732f-49f2-a527-ab7f7a4b5587', 'Soda Ash', '6', 'pcs', 20000, '9c0f7a71-7203-41a2-808a-2e8da3983c58', 'Soda Ash/Sodium carbonate adalah bubuk putih yang tidak berbau, menyerap kelembaban dari udara, memiliki rasa basa, dan membentuk larutan air alkali kuat. Ukuran 500 gr', '20240517063632.jpg', 'false', '-', '2024-05-16 23:36:32', '2024-05-16 23:36:32'),
('9c100eda-b4c3-4246-b798-abe03366f5c4', 'Urinoir Screen', '20', 'pcs', 40000, '9c0f79eb-d0dc-4da4-a736-09f1e023f53c', '\"Material : EVA\r\nBerat : 100g/pcs\r\nUkuran : 17cm x 17cm x 1cm\r\nDurasi pemakaian : 1pcs/ 30-50 hari (subjek terhadap pemakaian)\"', '20240517063706.jpg', 'false', '-', '2024-05-16 23:37:06', '2024-05-16 23:37:06'),
('9c100f28-2c02-47f8-87bf-a0000b76def0', 'Air Freshener spray merk stella ukuran 200 ml', '4', 'pcs', 35000, '9c0f7948-02c9-4505-9a6c-43e4d71d710e', '-', '20240517063756.jpg', 'false', '-', '2024-05-16 23:37:57', '2024-05-16 23:37:57'),
('9c100f9c-e9cc-4d2e-8835-13142cfcfd51', 'TAF 500ml', '11', 'botol', 25000, '9c0f7805-9c30-4f9b-bdf4-f051605d7358', 'Netto: 500 ml, Membersihkan dan mengkilapkan segala jenis permukaan', '20240517063913.jpg', 'false', '-', '2024-05-16 23:39:13', '2024-05-16 23:39:13'),
('9c101015-4dbe-4776-bb86-a69bf9229171', 'Kain Majun', '102', 'pcs', 20000, '9c0f6b6a-b7e7-4b58-b5d7-d02c91870d99', '\"Lapa kain majun ktun serap air\r\n1 kg isi 7-10 lembar, Bahan katun, Ukuran -/+ 20x20 cm, Serap air dan minyak\"', '20240517064032.jpg', 'false', '-', '2024-05-16 23:40:32', '2024-05-16 23:40:32'),
('9c101085-7fea-48ec-8cd6-2187fa9d197e', 'Masker medis', '18', 'pack', 15000, '9c0f741d-831b-440a-89cd-c75bacda3d3f', 'isi -/+ 50pcs, 3 ply, earloop, high quality material', '20240517064145.jpg', 'false', '-', '2024-05-16 23:41:45', '2024-05-16 23:41:45'),
('9c1010e3-6925-4642-8716-a4a054e53724', 'Thiner', '13', 'can', 35000, '9c0f7746-410e-49da-8d98-0cc964d79b9b', 'Thinner Impala berfungsi sebagai pengencer cat besi dan Kayu / Cat Synthetic. 500 liter (isi bersih 480 liter/kaleng)', '20240517064247.jpg', 'false', '-', '2024-05-16 23:42:47', '2024-05-16 23:42:47'),
('9c101142-baff-4172-a2f4-41dd6f6cc586', 'Propan clear/ coting @1 Ltr', '13', 'can', 110000, '9c0f7746-410e-49da-8d98-0cc964d79b9b', 'PROPAN S-KOTE / Pelindung Dinding Batu Alam, S-KOTE SC – 52 SB Clear Gloss uk. 0.9L', '20240517064349.jpg', 'false', '-', '2024-05-16 23:43:49', '2024-05-16 23:43:49'),
('9c10117a-9b65-4cfd-b0cf-9235d309c842', 'Pembasmi serangga/BAYGON', '1', 'can', 37500, '9c0f7849-5428-4afb-8f79-ce4593d958c6', 'baygon anti nyamuk dan serangga ukuran 600ml', '20240517064426.jpg', 'false', '-', '2024-05-16 23:44:26', '2024-05-16 23:44:26'),
('9c1011b9-e9fe-42a9-9eb2-09514cb9229b', 'Interior clotch ( micro fiber )', '13', 'pcs', 15000, '9c0f6b6a-b7e7-4b58-b5d7-d02c91870d99', '003DVS1642,  Merek: Diversey, 40x40, Hijau, 40x40x40cm', '20240517064508.jpg', 'false', '-', '2024-05-16 23:45:08', '2024-05-16 23:45:08'),
('9c1014fc-55a1-4b8f-a49e-a2278fa2c374', 'Spray Bottle 500ml', '35', 'pcs', 20000, '9c0f6b6a-b7e7-4b58-b5d7-d02c91870d99', 'Merek: Dragon, Warna: Merah, 61x39.3x30cm', '20240517065414.jpg', 'false', '-', '2024-05-16 23:54:14', '2024-05-16 23:54:14'),
('9c101557-fdcf-4980-a1d3-32757e761f31', 'tinta canon black', '4', 'pcs', 15000, '9c0f735a-541c-47c1-9627-3f1055f05a41', 'Tinta Dye INKU For canon @ 80ml, CMYK Warna : Black', '20240517065514.jpg', 'false', '-', '2024-05-16 23:55:14', '2024-05-16 23:55:14'),
('9c101584-8832-4618-bba9-0ff7eab08275', 'tinta canon cyan', '1', 'pcs', 15000, '9c0f735a-541c-47c1-9627-3f1055f05a41', 'Tinta Dye INKU For canon @ 80ml, CMYK Warna : cyan', '20240517065544.jpg', 'false', '-', '2024-05-16 23:55:44', '2024-05-16 23:55:44'),
('9c1015ae-b8f7-4bb9-9a5d-ae6b352f44f7', 'tinta canon magenta', '2', 'pcs', 15000, '9c0f735a-541c-47c1-9627-3f1055f05a41', 'Tinta Dye INKU For canon @ 80ml, CMYK Warna : magenta', '20240517065611.jpg', 'false', '-', '2024-05-16 23:56:11', '2024-05-16 23:56:11'),
('9c1015da-b07f-4351-b361-cb8877f7c0ea', 'tinta canon yellow', '2', 'pcs', 15000, '9c0f735a-541c-47c1-9627-3f1055f05a41', 'Tinta Dye INKU For canon @ 80ml, CMYK Warna : yellow', '20240517065640.jpg', 'false', '-', '2024-05-16 23:56:40', '2024-05-16 23:56:40'),
('9c10160c-3015-425e-aa25-74da70644519', 'spon busa cuci piring kunng busa 2 sisi', '146', 'pcs', 0, '9c0f6b6a-b7e7-4b58-b5d7-d02c91870d99', '-', '20240517065713.jpg', 'false', '-', '2024-05-16 23:57:13', '2024-05-16 23:57:13'),
('9c101653-57f2-4395-8cf0-ecd7760fb2de', 'rinso 5 L', '5', 'pouch', 150000, '9c0f7769-fee9-417c-8da8-b3a6d5751c75', '-', '20240517065759.jpg', 'false', '-', '2024-05-16 23:57:59', '2024-05-16 23:57:59'),
('9c101695-ebe8-4ffc-8dc0-0c7b7ee3c79a', 'Wipol 1.5 L', '1', 'pouch', 33000, '9c0f7906-d7a0-498c-aeec-15db01ff81f3', '-', '20240517065843.jpg', 'false', '-', '2024-05-16 23:58:43', '2024-06-02 04:29:47'),
('9c1016db-79eb-4b18-867f-16f199d21ac4', 'MMA/Hi Gloss', '7', 'can', 0, '9c0f7906-d7a0-498c-aeec-15db01ff81f3', 'hi GLOSS Pengkilap lantai di gunakan untuk mengkilapkan teraso,ubin,lantai vinyl,kayu dan keramik, ukuran 500gr', '20240517065928.jpg', 'false', '-', '2024-05-16 23:59:28', '2024-05-16 23:59:28'),
('9c101713-6930-47d9-a488-f77c4a5eadd3', 'Bebek in tank', '15', 'pcs', 15000, '9c0f78ef-3acc-4331-be27-178a7bd5e17b', 'Anti bakteri closet', '20240517070005.jpg', 'false', '-', '2024-05-17 00:00:05', '2024-05-17 00:00:05'),
('9c10175e-a6b2-478d-8844-43290f76c627', 'Tapas Hijau', '0', 'lusin', 17500, '9c0f6b6a-b7e7-4b58-b5d7-d02c91870d99', 'Alat pembersih', '20240517070054.jpg', 'false', '-', '2024-05-17 00:00:54', '2024-05-17 00:00:54');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` char(36) NOT NULL,
  `images` varchar(255) NOT NULL,
  `product_category_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `images`, `product_category_name`, `created_at`, `updated_at`) VALUES
('9c0f6b6a-b7e7-4b58-b5d7-d02c91870d99', '20240516110005.jpg', 'Alat Kebersihan', '2024-05-16 16:00:05', '2024-05-16 16:00:05'),
('9c0f6c46-d271-4f2c-92bc-430d909dc8ba', '20240516110230.jpg', 'Alat Perkakas', '2024-05-16 16:02:30', '2024-05-16 16:02:30'),
('9c0f735a-541c-47c1-9627-3f1055f05a41', '20240516112217.jpg', 'ATK', '2024-05-16 16:22:17', '2024-05-16 16:22:17'),
('9c0f741d-831b-440a-89cd-c75bacda3d3f', '20240516112425.jpg', 'Atribut', '2024-05-16 16:24:25', '2024-05-16 16:24:25'),
('9c0f76e2-14b5-400c-9fa3-9e05738923d6', '20240516113209.jpg', 'Cairan Pembersih', '2024-05-16 16:32:09', '2024-05-16 16:32:09'),
('9c0f7746-410e-49da-8d98-0cc964d79b9b', '20240516113315.jpg', 'Cat', '2024-05-16 16:33:15', '2024-05-16 16:33:15'),
('9c0f7769-fee9-417c-8da8-b3a6d5751c75', '20240516113338.jpg', 'Datergen', '2024-05-16 16:33:38', '2024-05-16 16:33:38'),
('9c0f7796-d910-49d3-9536-f4de55fd4007', '20240516113408.jpg', 'Kain', '2024-05-16 16:34:08', '2024-05-16 16:34:08'),
('9c0f7805-9c30-4f9b-bdf4-f051605d7358', '20240516113520.jpg', 'Krim Pembersih', '2024-05-16 16:35:20', '2024-05-16 16:35:20'),
('9c0f7849-5428-4afb-8f79-ce4593d958c6', '20240516113605.jpg', 'Obat Kimia', '2024-05-16 16:36:05', '2024-05-16 16:36:05'),
('9c0f78ef-3acc-4331-be27-178a7bd5e17b', '20240516113753.jpg', 'Pembersih Kamar Mandi', '2024-05-16 16:37:53', '2024-05-16 16:37:53'),
('9c0f7906-d7a0-498c-aeec-15db01ff81f3', '20240516113809.jpg', 'Pembersih Lantai', '2024-05-16 16:38:09', '2024-05-16 16:38:09'),
('9c0f7948-02c9-4505-9a6c-43e4d71d710e', '20240516113852.jpg', 'Pengharum Ruangan', '2024-05-16 16:38:52', '2024-05-16 16:38:52'),
('9c0f7987-ca6e-4e36-9314-cc77d40bb291', '20240516113933.jpg', 'Peralatan Rumah Tangga', '2024-05-16 16:39:33', '2024-05-16 16:39:33'),
('9c0f79eb-d0dc-4da4-a736-09f1e023f53c', '20240516114039.jpg', 'Pewangi Toilet', '2024-05-16 16:40:39', '2024-05-16 16:40:39'),
('9c0f7a1c-7107-4ac0-abfa-7eb632020ab2', '20240516114111.jpg', 'Sabun Cair', '2024-05-16 16:41:11', '2024-05-16 16:41:11'),
('9c0f7a71-7203-41a2-808a-2e8da3983c58', '20240516114206.jpg', 'Water Treatment', '2024-05-16 16:42:06', '2024-05-16 16:42:06');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` char(36) NOT NULL,
  `id_area` char(36) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `role` enum('superadmin','admin','member') NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `id_area`, `email`, `username`, `fullname`, `role`, `password`, `created_at`, `updated_at`) VALUES
('9be35b9f-319f-48a7-900d-7bb5ce198bea', '9be35b86-48c7-4302-87d0-1396d8232f52', 'admin@gmail.com', 'admin', 'admin', 'admin', '$2y$12$Npa6WGwaMtwGCyD4u5FmeuieUTYL9qZeR1ucfjcQ6qGUVofLvSzDi', '2024-04-24 18:19:30', '2024-04-24 18:19:30'),
('9be35be7-ecd8-4d96-950c-f7c9222af25b', '9be35b86-48c7-4302-87d0-1396d8232f52', 'user@gmail.com', 'user', 'user', 'member', '$2y$12$41qluDv7Ye4yS/Gwio6zJeQ15AHloc2EPgRtIGapVZoC7kfx9KZ1e', '2024-04-24 18:20:18', '2024-04-24 18:20:18'),
('9c26941c-03c9-4773-a00e-28b75d453876', '9c269384-6f1b-49b4-a44b-cfc86888073b', 'andri.aran77@gmail.com', 'Andri', 'Andri', 'member', '$2y$12$hVqUB5x3lN9ltzRIyimP.O7L75ig9wCRyVdoysgXUpfgpvL6tYIY6', '2024-05-28 04:17:55', '2024-05-28 04:17:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `areas_area_name_unique` (`area_name`);

--
-- Indexes for table `carousesl`
--
ALTER TABLE `carousels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cut_offs`
--
ALTER TABLE `cut_offs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cut_offs_id_area_foreign` (`id_area`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_id_user_foreign` (`id_user`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_id_order_foreign` (`id_order`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_id_category_foreign` (`id_category`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_fullname_unique` (`fullname`),
  ADD KEY `users_id_area_foreign` (`id_area`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cut_offs`
--
ALTER TABLE `cut_offs`
  ADD CONSTRAINT `cut_offs_id_area_foreign` FOREIGN KEY (`id_area`) REFERENCES `areas` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_id_order_foreign` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_id_category_foreign` FOREIGN KEY (`id_category`) REFERENCES `product_categories` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_id_area_foreign` FOREIGN KEY (`id_area`) REFERENCES `areas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
