-- MariaDB dump 10.19  Distrib 10.11.3-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: kooranet
-- ------------------------------------------------------
-- Server version	10.11.3-MariaDB-1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `translations`
--

DROP TABLE IF EXISTS `translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `translations` (
  `key` varchar(50) NOT NULL,
  `value` varchar(255) NOT NULL,
  `original` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `translations`
--

LOCK TABLES `translations` WRITE;
/*!40000 ALTER TABLE `translations` DISABLE KEYS */;
INSERT INTO `translations` VALUES
('l2','دوري أبطال أوروبا','UEFA Champions League','2023-06-11 14:19:35','2023-06-11 14:19:35'),
('l3','الدوري الأوروبي','UEFA Europa League','2023-08-31 12:41:55','2023-08-31 12:41:55'),
('v7','ملعب 19 ماي، عنابة','Stade du 19 Mai 1956, Annaba','2023-09-07 15:24:33','2023-09-07 15:26:57'),
('l12','دوري أبطال أفريقيا','CAF Champions League','2023-06-12 08:25:47','2023-06-12 08:25:47'),
('28','تونس','Tunisia','2023-09-07 15:24:33','2023-09-07 15:24:33'),
('33','مانشستر يونايتد','Manchester United','2023-07-18 12:23:09','2023-07-18 12:23:09'),
('34','نيوكاسل','Newcastle','2023-08-27 13:56:19','2023-08-27 13:56:19'),
('36','فولهام','Fulham','2023-07-18 12:23:10','2023-07-18 12:23:10'),
('l39','الدوري الانجليزي الممتاز','Premier League','2023-07-18 12:23:10','2023-07-18 12:24:36'),
('40','ليفربول','Liverpool','2023-08-27 13:56:19','2023-08-27 13:56:19'),
('42','أرسنال','Arsenal','2023-08-12 13:36:56','2023-09-03 14:54:28'),
('l48','كأس الرابطة','League Cup','2023-08-30 15:57:38','2023-08-30 15:57:38'),
('49','تشيلسي','Chelsea','2023-08-30 15:57:36','2023-08-30 15:57:36'),
('50','مانشستر سيتي','Manchester City','2023-06-11 14:19:33','2023-06-11 14:19:33'),
('l61','الدوري الفرنسي 1','Ligue 1','2023-08-12 13:36:58','2023-08-12 13:36:58'),
('62','شيفيلد يونايتد','Sheffield Utd','2023-08-27 13:56:19','2023-08-27 13:56:19'),
('65','نوتنغهام فورست','Nottingham Forest','2023-08-12 13:36:57','2023-08-12 13:36:57'),
('66','أستون فيلا','Aston Villa','2023-09-03 13:27:32','2023-09-03 13:27:32'),
('80','ليون','Lyon','2023-09-03 13:27:33','2023-09-03 13:27:33'),
('81','مرسيليا','Marseille','2023-09-01 04:08:24','2023-09-01 04:08:24'),
('83','نانت','Nantes','2023-09-01 04:08:23','2023-09-01 04:08:23'),
('85','باريس سان جيرمان','Paris Saint Germain','2023-08-12 13:36:56','2023-08-12 13:36:56'),
('97','لوريان','Lorient','2023-08-12 13:36:57','2023-08-12 13:36:57'),
('116','لانس','Lens','2023-08-26 21:06:42','2023-08-26 21:07:02'),
('l135','الدوري الإيطالي','Serie A','2023-06-12 08:25:47','2023-06-12 08:25:47'),
('l140','الدوري الإسباني','La Liga','2023-08-12 13:36:58','2023-08-12 13:36:58'),
('194','اياكس','Ajax','2023-08-31 12:41:54','2023-08-31 12:41:54'),
('197','بي إس في أيندهوفن','PSV Eindhoven','2023-08-30 14:32:22','2023-08-30 14:32:22'),
('l202','الرابطة التونسية المحترفة الاولى','Ligue 1','2023-06-11 14:19:27','2023-06-11 14:23:09'),
('257','رينجرز','Rangers','2023-08-30 14:32:23','2023-08-30 14:32:23'),
('l307','الدوري السعودي للمحترفين','Pro League','2023-08-29 12:19:31','2023-08-29 12:24:02'),
('487','لاتسيو','Lazio','2023-09-02 14:05:02','2023-09-02 14:05:02'),
('489','ميلان','AC Milan','2023-09-01 04:08:24','2023-09-01 04:08:24'),
('490','كالياري','Cagliari','2023-08-28 18:16:42','2023-08-28 18:16:42'),
('492','نابولي','Napoli','2023-09-02 14:05:01','2023-09-02 14:05:01'),
('v494','ستاد الامارات ، لندن','Emirates Stadium, London','2023-08-12 13:36:58','2023-08-26 21:08:09'),
('496','يوفنتوس','Juventus','2023-08-27 13:56:20','2023-08-27 13:56:20'),
('497','روما','AS Roma','2023-09-01 04:08:23','2023-09-01 04:08:23'),
('500','بولونيا','Bologna','2023-08-27 13:56:21','2023-08-27 13:56:21'),
('504','فيرونا','Verona','2023-06-12 08:25:47','2023-06-12 09:09:14'),
('505','إنتر ميلان','Inter','2023-06-11 14:19:34','2023-06-11 14:21:42'),
('511','إمبولي','Empoli','2023-09-03 13:27:33','2023-09-03 13:27:33'),
('515','سبيتسيا','Spezia','2023-06-12 08:25:46','2023-06-12 08:25:46'),
('v519','ستامفورد بريدج، لندن','Stamford Bridge, London','2023-08-30 15:57:38','2023-08-30 16:12:03'),
('529','برشلونة','Barcelona','2023-08-27 13:56:19','2023-08-27 13:56:19'),
('530','أتلتيكو مدريد','Atletico Madrid','2023-08-28 18:16:43','2023-08-28 18:16:43'),
('531','أتلتيك بيلباو','Athletic Club','2023-08-12 13:36:57','2023-08-26 21:08:31'),
('532','فالنسيا','Valencia','2023-09-02 14:05:01','2023-09-02 14:05:01'),
('533','فياريال','Villarreal','2023-08-27 13:56:19','2023-08-27 13:56:19'),
('536','إشبيلية','Sevilla','2023-09-03 13:27:32','2023-09-03 13:27:32'),
('541','ريال مدريد','Real Madrid','2023-08-12 13:36:57','2023-08-12 13:36:57'),
('542','ألافيس','Alaves','2023-09-02 14:05:00','2023-09-02 14:05:00'),
('546','خيتافي','Getafe','2023-09-02 14:04:59','2023-09-02 14:04:59'),
('v550','أنفيلد، ليفربول','Anfield, Liverpool','2023-09-03 13:27:33','2023-09-03 13:29:03'),
('v555','ملعب الاتحاد، مانشستر','Etihad Stadium, Manchester','2023-09-02 14:04:59','2023-09-02 14:09:08'),
('v556','الترافورد','Old Trafford, Manchester','2023-07-18 12:23:11','2023-07-18 12:25:05'),
('v562','سانت جيمس بارك، نيوكاسل','St. James\' Park, Newcastle upon Tyne','2023-08-27 13:56:20','2023-08-27 20:48:05'),
('566','لودوغوريتس','Ludogorets','2023-08-31 12:41:54','2023-08-31 12:41:54'),
('v581','الممتاز','Bramall Lane, Sheffield','2023-08-27 13:56:19','2023-08-27 13:56:19'),
('v662','ملعب بوجوار، نانت','Stade de la Beaujoire - Louis Fonteneau, Nantes','2023-09-01 04:08:24','2023-09-01 12:41:58'),
('v666','ملعب قروباما','Groupama Stadium, Décines-Charpieu','2023-09-03 13:27:33','2023-09-03 13:32:06'),
('v671','ملعب الأمراء، باريس','Parc des Princes, Paris','2023-08-12 13:36:58','2023-08-26 21:07:46'),
('724','قادس','Cadiz','2023-09-01 04:08:22','2023-09-01 04:08:22'),
('727','أوساسونا','Osasuna','2023-09-03 13:27:34','2023-09-03 13:27:34'),
('728','رايو فاليكانو','Rayo Vallecano','2023-08-28 18:16:42','2023-08-28 18:16:42'),
('l768','كأس العرب للأندية الأبطال','Arab Club Champions Cup','2023-08-12 13:36:58','2023-08-12 13:36:58'),
('776','جمهورية أيرلندا','Rep. Of Ireland','2023-09-07 15:24:32','2023-09-07 15:24:32'),
('909','أليانز، تورينو','Allianz Stadium, Torino','2023-08-27 13:56:21','2023-08-28 21:09:36'),
('v910','الملعب الاولمبي، روما','Stadio Olimpico, Roma','2023-09-01 04:08:24','2023-09-01 12:41:04'),
('l960','بطولة أمم أوروبا - التصفيات','Euro Championship - Qualification','2023-09-07 15:24:33','2023-09-07 15:24:33'),
('968','الوداد الرياضي','Wydad AC','2023-06-12 08:25:46','2023-06-12 09:57:36'),
('980','الترجي الرياضي','ES Tunis','2023-06-11 14:19:31','2023-06-11 14:22:25'),
('981','النادي البنزرتي','CA Bizertin','2023-08-27 13:56:20','2023-09-01 12:47:57'),
('983','النادي الصفاقسي','CS Sfaxien','2023-06-12 08:25:47','2023-06-12 08:25:47'),
('984','نجم المتلوي','ES Metlaoui','2023-09-02 14:05:00','2023-09-02 14:06:47'),
('986','اتحاد بن قردان','US Ben Guerdane','2023-06-12 08:25:46','2023-06-12 08:25:46'),
('988','النادي الإفريقي','Club Africain','2023-06-11 14:19:25','2023-06-11 14:19:25'),
('990','النجم الساحلي','ES Sahel','2023-06-11 14:19:30','2023-06-11 14:22:39'),
('991','الملعب التونسي','Stade Tunisien','2023-08-30 13:11:10','2023-08-30 13:11:10'),
('992','الاتحاد المنستيري','US Monastirienne','2023-06-11 14:19:26','2023-06-11 14:23:36'),
('l1028','كأس الأمم الأفريقية - التصفيات','Martyrs of February Stadium, Benghazi','2023-09-06 04:12:56','2023-09-06 04:12:56'),
('v1117','يوهان كرويف، أمستردام','Johan Cruijff Arena, Amsterdam','2023-08-31 12:41:55','2023-09-01 01:39:07'),
('1118','هولندا','Netherlands','2023-09-07 15:24:32','2023-09-07 15:24:32'),
('v1143','ملعب فيليبس، أيندهوفن','Philips Stadion, Eindhoven','2023-08-30 14:32:23','2023-08-30 15:21:06'),
('1190','اتحاد تطاوين','US Tataouine','2023-06-12 08:25:47','2023-06-12 09:09:05'),
('1333','ويمبلدون','AFC Wimbledon','2023-08-30 15:57:37','2023-08-30 16:15:55'),
('v1367','المدينة الرياضية، المجمعة','Al Majma\'ah Sports City Stadium, Al Majma\'ah','2023-09-01 04:08:23','2023-09-01 12:42:49'),
('v1374','استاد جامعة الملك سعود، الرياض','Al Awal Park at King Saud University, Riyadh','2023-08-29 12:19:32','2023-08-29 12:22:42'),
('v1377','ملعب الملك عبدالله، بريدة','King Abdullah Sport City Stadium, Buraidah','2023-09-02 14:05:01','2023-09-02 14:10:10'),
('v1456','سانتياغو برنابيو، مدريد','Estadio Santiago Bernabéu, Madrid','2023-09-02 14:05:00','2023-09-02 14:06:29'),
('v1460','سان مامس، بيلباو','San Mamés Barria, Bilbao','2023-08-12 13:36:59','2023-08-26 21:09:01'),
('v1470','ملعب مينديزوروزا','Estadio de Mendizorroza, Vitoria-Gasteiz','2023-09-02 14:05:01','2023-09-02 14:08:16'),
('v1486','ملعب ال سادار','Estadio El Sadar, Iruñea','2023-09-03 13:27:34','2023-09-03 13:30:33'),
('v1488','ملعب فاييكاس، مدريد','Estadio de Vallecas, Madrid','2023-08-28 18:16:44','2023-08-28 21:07:11'),
('1489','تنزانيا','Tanzania','2023-09-07 15:24:33','2023-09-07 15:24:33'),
('v1498','الدوري الإسباني','Estadio de la Cerámica, Villarreal','2023-08-27 13:56:20','2023-08-27 13:56:20'),
('1520','بوتسوانا','Botswana','2023-09-07 15:24:33','2023-09-07 15:24:33'),
('1521','غينيا الاستوائية','Equatorial Guinea','2023-09-06 04:12:55','2023-09-06 04:12:55'),
('1526','ليبيا','Libya','2023-09-06 04:12:55','2023-09-06 04:12:55'),
('1532','الجزائر','Algeria','2023-09-07 15:24:32','2023-09-07 15:24:32'),
('v1566','ملعب 15أكتوبر، بنزرت','Stade du 15 Octobre, Banzart','2023-08-27 13:56:21','2023-08-28 21:09:04'),
('v1567','الطيب المهيري، صفاقس','Stade Taïeb Mhiri, Safāqis','2023-09-02 14:04:59','2023-09-02 14:08:50'),
('v1568','الملعب الأولمبي، سوسة','Stade Olympique de Sousse, Sūsah','2023-07-03 15:42:17','2023-07-03 15:43:54'),
('v1571','ملعب مصطفى بن جنات، المنستير','Stade Mustapha Ben Jannet, Monastir','2023-07-03 15:42:17','2023-07-03 15:43:32'),
('1577','الأهلي','Al Ahly','2023-06-12 08:25:47','2023-06-12 08:25:47'),
('v1891','ملعب نجيب الخطاب، تطاوين','Stade Néjib Khattab, Tataouine','2023-07-03 15:42:17','2023-07-03 15:43:11'),
('v2904','كأس العرب للأندية الأبطال','King Fahd Sport City Stadium, Ta\'if','2023-08-12 13:36:58','2023-08-12 13:36:58'),
('2929','الأهلي جدة','Al-Ahli Jeddah','2023-08-29 12:19:31','2023-08-29 12:19:31'),
('2932','نادي الهلال السعودي','Al-Hilal Saudi FC','2023-08-12 13:36:56','2023-08-12 13:36:56'),
('2935','الرائد','Al-Raed','2023-09-01 04:08:23','2023-09-01 04:08:23'),
('2938','نادي الاتحاد','Al-Ittihad FC','2023-09-01 04:08:22','2023-09-01 04:08:22'),
('2939','النصر','Al-Nassr','2023-08-12 13:36:57','2023-08-12 13:36:57'),
('2940','الشباب','Al Shabab','2023-08-29 12:19:31','2023-08-29 12:19:31'),
('2942','الطائي','Al Taee','2023-08-29 12:19:31','2023-08-29 12:19:31'),
('2944','الفيحاء','Al-Fayha','2023-09-01 04:08:22','2023-09-01 04:08:22'),
('2945','الحزم','Al-Hazm','2023-09-02 14:05:00','2023-09-02 14:05:00'),
('v7277','ملعب 7 نوفمبر، قفصة','Stade du 7 Novembre, Gafsa','2023-09-03 13:27:32','2023-09-03 18:19:50'),
('v7299','الدوري الفرنسي 1','Stade Abdelaziz Chtioui, La Marsa','2023-08-27 13:56:20','2023-08-27 13:56:20'),
('10368','المرسى','AS Marsa','2023-08-27 13:56:19','2023-08-27 13:56:19'),
('10604','قوافل قفصة','EGS Gafsa','2023-08-26 21:06:42','2023-08-26 21:07:13'),
('10625','أولمبيك باجة','Olympique Béja','2023-06-12 08:25:46','2023-06-12 08:25:46'),
('v11904','ارماندو مارادونا، نابولي','Stadio Diego Armando Maradona, Napoli','2023-09-02 14:05:02','2023-09-02 14:05:47'),
('v11915','نويفو ميرانديلا، قادش','Estadio Nuevo Mirandilla, Cádiz','2023-09-01 04:08:23','2023-09-01 12:46:44'),
('v12275','يونيبول دوموس، كالياري','Unipol Domus, Cagliari','2023-08-28 18:16:43','2023-08-28 21:08:44'),
('v19217','سيفيتاس ميتروبوليتانو، مدريد','Estádio Cívitas Metropolitano, Madrid','2023-09-03 13:27:33','2023-09-03 13:30:59'),
('v19755','ملعب حمادي العقربي، رادس','Stade Olympique Hammadi Agrebi, Radès','2023-07-03 15:42:18','2023-07-03 15:44:11'),
('v19932','استاد الأمير عبد الله الفيصل، جدة','Prince Abdullah al-Faisal Stadium, Jeddah','2023-08-29 12:19:32','2023-08-29 12:21:19'),
('v20109','كارلو كاستيلاني','Stadio Carlo Castellani – Computer Gross Arena, Empoli','2023-09-03 13:27:33','2023-09-03 13:31:50'),
('v40226','ملعب هادي النيفر، باردو','Stade Hédi-Enneifer, Le Bardo','2023-08-30 13:27:38','2023-08-30 13:28:54');
/*!40000 ALTER TABLE `translations` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-09-08  5:00:56
