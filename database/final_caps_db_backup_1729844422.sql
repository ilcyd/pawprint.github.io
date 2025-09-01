

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appointment_id` text NOT NULL,
  `service_id` varchar(50) NOT NULL,
  `vet_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `vaccine_type` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `delete_flag` tinyint(4) NOT NULL DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO appointments VALUES("20","20241023-0001","1,2","9","2","11","2024-10-23","02:00:00","02:30:00","10","1","0","2024-10-23 15:05:10");
INSERT INTO appointments VALUES("21","20241024-0001","2","9","12","23","2024-11-01","08:00:00","08:30:00","12","1","0","2024-10-24 16:30:38");



CREATE TABLE `barangays` (
  `barangay_id` int(11) NOT NULL AUTO_INCREMENT,
  `barangay_name` text NOT NULL,
  `municipality_id` int(11) NOT NULL,
  PRIMARY KEY (`barangay_id`)
) ENGINE=InnoDB AUTO_INCREMENT=386 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO barangays VALUES("1","Alegria","1");
INSERT INTO barangays VALUES("2","Bagong Buhay","1");
INSERT INTO barangays VALUES("3","Bella","1");
INSERT INTO barangays VALUES("4","Calades","1");
INSERT INTO barangays VALUES("5","Concepcion","1");
INSERT INTO barangays VALUES("6","Dawa-dawa","1");
INSERT INTO barangays VALUES("7","Gulayon","1");
INSERT INTO barangays VALUES("8","Ilisan","1");
INSERT INTO barangays VALUES("9","Kapatagan","1");
INSERT INTO barangays VALUES("10","Kauswagan","1");
INSERT INTO barangays VALUES("11","Kawayan","1");
INSERT INTO barangays VALUES("12","La Paz","1");
INSERT INTO barangays VALUES("13","Lambuyogan","1");
INSERT INTO barangays VALUES("14","Lapirawan","1");
INSERT INTO barangays VALUES("15","Litayon","1");
INSERT INTO barangays VALUES("16","Lutiman","1");
INSERT INTO barangays VALUES("17","Milagrosa Baluno","1");
INSERT INTO barangays VALUES("18","Naga-naga","1");
INSERT INTO barangays VALUES("19","Pandan-pandan","1");
INSERT INTO barangays VALUES("20","Payongan","1");
INSERT INTO barangays VALUES("21","Poblacion","1");
INSERT INTO barangays VALUES("22","Santa Maria","1");
INSERT INTO barangays VALUES("23","Santo Niño","1");
INSERT INTO barangays VALUES("24","Talaptap","1");
INSERT INTO barangays VALUES("25","Tampalan","1");
INSERT INTO barangays VALUES("26","Tandiong Muslim","1");
INSERT INTO barangays VALUES("27","Timbang-timbang","1");
INSERT INTO barangays VALUES("28","Agutayan","2");
INSERT INTO barangays VALUES("29","Bagong Borbon","2");
INSERT INTO barangays VALUES("30","Basalem","2");
INSERT INTO barangays VALUES("31","Bawang","2");
INSERT INTO barangays VALUES("32","Bliss","2");
INSERT INTO barangays VALUES("33","Bulaan","2");
INSERT INTO barangays VALUES("34","Compostela","2");
INSERT INTO barangays VALUES("35","Danlugan","2");
INSERT INTO barangays VALUES("36","Datu Panas","2");
INSERT INTO barangays VALUES("37","Del Monte","2");
INSERT INTO barangays VALUES("38","Guintuloan","2");
INSERT INTO barangays VALUES("39","Guitom","2");
INSERT INTO barangays VALUES("40","Guminta","2");
INSERT INTO barangays VALUES("41","Labrador","2");
INSERT INTO barangays VALUES("42","Lantawan","2");
INSERT INTO barangays VALUES("43","Mabuhay","2");
INSERT INTO barangays VALUES("44","Maganay","2");
INSERT INTO barangays VALUES("45","Manlin","2");
INSERT INTO barangays VALUES("46","Muyo","2");
INSERT INTO barangays VALUES("47","Pamintayan","2");
INSERT INTO barangays VALUES("48","Pling","2");
INSERT INTO barangays VALUES("49","Poblacion","2");
INSERT INTO barangays VALUES("50","Pulog","2");
INSERT INTO barangays VALUES("51","San Jose","2");
INSERT INTO barangays VALUES("52","Talairan","2");
INSERT INTO barangays VALUES("53","Talamimi","2");
INSERT INTO barangays VALUES("54","Villacastor (Galit)","2");
INSERT INTO barangays VALUES("55","Balangao","3");
INSERT INTO barangays VALUES("56","Butong","3");
INSERT INTO barangays VALUES("57","Ditay","3");
INSERT INTO barangays VALUES("58","Gaulan","3");
INSERT INTO barangays VALUES("59","Goling","3");
INSERT INTO barangays VALUES("60","Guinoman","3");
INSERT INTO barangays VALUES("61","Kauswagan","3");
INSERT INTO barangays VALUES("62","Lindang","3");
INSERT INTO barangays VALUES("63","Lobing","3");
INSERT INTO barangays VALUES("64","Luop","3");
INSERT INTO barangays VALUES("65","Manangon","3");
INSERT INTO barangays VALUES("66","Mejo","3");
INSERT INTO barangays VALUES("67","Natan","3");
INSERT INTO barangays VALUES("68","Paradise","3");
INSERT INTO barangays VALUES("69","Pilar","3");
INSERT INTO barangays VALUES("70","Poblacion (Diplahan)","3");
INSERT INTO barangays VALUES("71","Sampoli A","3");
INSERT INTO barangays VALUES("72","Sampoli B","3");
INSERT INTO barangays VALUES("73","Santa Cruz","3");
INSERT INTO barangays VALUES("74","Songcuya","3");
INSERT INTO barangays VALUES("75","Tinongtongan","3");
INSERT INTO barangays VALUES("76","Tuno","3");
INSERT INTO barangays VALUES("77","Balugo","4");
INSERT INTO barangays VALUES("78","Bolungisan","4");
INSERT INTO barangays VALUES("79","Baluyan","4");
INSERT INTO barangays VALUES("80","Cana-an","4");
INSERT INTO barangays VALUES("81","Dumpoc","4");
INSERT INTO barangays VALUES("82","Gandiangan","4");
INSERT INTO barangays VALUES("83","Guintolan","4");
INSERT INTO barangays VALUES("84","Israel (Balian Israel)","4");
INSERT INTO barangays VALUES("85","Lower Baluran","4");
INSERT INTO barangays VALUES("86","La Victoria","4");
INSERT INTO barangays VALUES("87","Little Baguio","4");
INSERT INTO barangays VALUES("88","Lumbog","4");
INSERT INTO barangays VALUES("89","Lumpanac","4");
INSERT INTO barangays VALUES("90","Mali Little Baguio","4");
INSERT INTO barangays VALUES("91","Poblacion (Santa Fe)","4");
INSERT INTO barangays VALUES("92","Pulawan (Mountain View)","4");
INSERT INTO barangays VALUES("93","San Jose","4");
INSERT INTO barangays VALUES("94","Santa Barbara","4");
INSERT INTO barangays VALUES("95","Upper Baluran","4");
INSERT INTO barangays VALUES("96","Bacalan","5");
INSERT INTO barangays VALUES("97","Bangkerohan","5");
INSERT INTO barangays VALUES("98","Buluan","5");
INSERT INTO barangays VALUES("99","Caparan","5");
INSERT INTO barangays VALUES("100","Domandan","5");
INSERT INTO barangays VALUES("101","Don Andres","5");
INSERT INTO barangays VALUES("102","Doña Josefa","5");
INSERT INTO barangays VALUES("103","Guituan","5");
INSERT INTO barangays VALUES("104","Ipil Heights","5");
INSERT INTO barangays VALUES("105","Labe","5");
INSERT INTO barangays VALUES("106","Logan","5");
INSERT INTO barangays VALUES("107","Tirso Babiera (Lower Ipil Heights)","5");
INSERT INTO barangays VALUES("108","Lower Taway","5");
INSERT INTO barangays VALUES("109","Lumbia","5");
INSERT INTO barangays VALUES("110","Maasin","5");
INSERT INTO barangays VALUES("111","Magdaup","5");
INSERT INTO barangays VALUES("112","Makilas","5");
INSERT INTO barangays VALUES("113","Pangi","5");
INSERT INTO barangays VALUES("114","Poblacion","5");
INSERT INTO barangays VALUES("115","Sanito","5");
INSERT INTO barangays VALUES("116","Suclema","5");
INSERT INTO barangays VALUES("117","Taway","5");
INSERT INTO barangays VALUES("118","Tenan","5");
INSERT INTO barangays VALUES("119","Tiayon","5");
INSERT INTO barangays VALUES("120","Timalang","5");
INSERT INTO barangays VALUES("121","Tomitom","5");
INSERT INTO barangays VALUES("122","Upper Pangi","5");
INSERT INTO barangays VALUES("123","Veteran\'s Village","5");
INSERT INTO barangays VALUES("124","Banker","6");
INSERT INTO barangays VALUES("125","Bolo Battalion","6");
INSERT INTO barangays VALUES("126","Buayan","6");
INSERT INTO barangays VALUES("127","Cainglet","6");
INSERT INTO barangays VALUES("128","Calapan","6");
INSERT INTO barangays VALUES("129","Francisco L. Peña, Sr.","6");
INSERT INTO barangays VALUES("130","Concepcion (Balungis)","6");
INSERT INTO barangays VALUES("131","Diampak","6");
INSERT INTO barangays VALUES("132","Dipala","6");
INSERT INTO barangays VALUES("133","Gacbusan","6");
INSERT INTO barangays VALUES("134","Goodyear","6");
INSERT INTO barangays VALUES("135","Lacnapan","6");
INSERT INTO barangays VALUES("136","Little Baguio","6");
INSERT INTO barangays VALUES("137","Lumbayao","6");
INSERT INTO barangays VALUES("138","Nazareth","6");
INSERT INTO barangays VALUES("139","Palinta","6");
INSERT INTO barangays VALUES("140","Peñaranda","6");
INSERT INTO barangays VALUES("141","Poblacion","6");
INSERT INTO barangays VALUES("142","Riverside","6");
INSERT INTO barangays VALUES("143","Sanghanan","6");
INSERT INTO barangays VALUES("144","Santa Cruz","6");
INSERT INTO barangays VALUES("145","Sayao","6");
INSERT INTO barangays VALUES("146","Shiolan","6");
INSERT INTO barangays VALUES("147","Simbol","6");
INSERT INTO barangays VALUES("148","Sininan","6");
INSERT INTO barangays VALUES("149","Tamin","6");
INSERT INTO barangays VALUES("150","Tampilisan","6");
INSERT INTO barangays VALUES("151","Tigbangagan","6");
INSERT INTO barangays VALUES("152","Timuay Danda (Mangahas)","6");
INSERT INTO barangays VALUES("153","Abunda","7");
INSERT INTO barangays VALUES("154","Bagong Silang (Tumalog)","7");
INSERT INTO barangays VALUES("155","Bangkaw-bangkaw","7");
INSERT INTO barangays VALUES("156","Caliran (Turko)","7");
INSERT INTO barangays VALUES("157","Catipan","7");
INSERT INTO barangays VALUES("158","Kauswagan","7");
INSERT INTO barangays VALUES("159","Ligaya","7");
INSERT INTO barangays VALUES("160","Looc-Barlac","7");
INSERT INTO barangays VALUES("161","Malinao (Sagasa)","7");
INSERT INTO barangays VALUES("162","Pamansaan","7");
INSERT INTO barangays VALUES("163","Pinalim (San Roque)","7");
INSERT INTO barangays VALUES("164","Poblacion (Mabuhay)","7");
INSERT INTO barangays VALUES("165","Punawan","7");
INSERT INTO barangays VALUES("166","Santo Niño (Tobi-an)","7");
INSERT INTO barangays VALUES("167","Sawa","7");
INSERT INTO barangays VALUES("168","Sioton","7");
INSERT INTO barangays VALUES("169","Taguisian","7");
INSERT INTO barangays VALUES("170","Tandu-Comot (Katipunan)","7");
INSERT INTO barangays VALUES("171","Bacao","8");
INSERT INTO barangays VALUES("172","Basakbawang","8");
INSERT INTO barangays VALUES("173","Bontong","8");
INSERT INTO barangays VALUES("174","Camanga","8");
INSERT INTO barangays VALUES("175","Candiis","8");
INSERT INTO barangays VALUES("176","Catituan","8");
INSERT INTO barangays VALUES("177","Dansulao","8");
INSERT INTO barangays VALUES("178","Del Pilar","8");
INSERT INTO barangays VALUES("179","Guilawa","8");
INSERT INTO barangays VALUES("180","Kigay","8");
INSERT INTO barangays VALUES("181","La Dicha","8");
INSERT INTO barangays VALUES("182","Lipacan","8");
INSERT INTO barangays VALUES("183","Logpond","8");
INSERT INTO barangays VALUES("184","Malongon","8");
INSERT INTO barangays VALUES("185","Molom","8");
INSERT INTO barangays VALUES("186","Mabini","8");
INSERT INTO barangays VALUES("187","Overland","8");
INSERT INTO barangays VALUES("188","Palalian","8");
INSERT INTO barangays VALUES("189","Payag","8");
INSERT INTO barangays VALUES("190","Poblacion","8");
INSERT INTO barangays VALUES("191","Rebocon","8");
INSERT INTO barangays VALUES("192","Aguinaldo","9");
INSERT INTO barangays VALUES("193","Baga","9");
INSERT INTO barangays VALUES("194","Baluno","9");
INSERT INTO barangays VALUES("195","Bangkaw-bangkaw","9");
INSERT INTO barangays VALUES("196","Cabong","9");
INSERT INTO barangays VALUES("197","Crossing Santa Clara","9");
INSERT INTO barangays VALUES("198","Gubawang","9");
INSERT INTO barangays VALUES("199","Guintoloan","9");
INSERT INTO barangays VALUES("200","Kaliantana","9");
INSERT INTO barangays VALUES("201","La Paz","9");
INSERT INTO barangays VALUES("202","Lower Sulitan","9");
INSERT INTO barangays VALUES("203","Mamagon","9");
INSERT INTO barangays VALUES("204","Marsolo","9");
INSERT INTO barangays VALUES("205","Poblacion","9");
INSERT INTO barangays VALUES("206","San Isidro","9");
INSERT INTO barangays VALUES("207","Sandayong","9");
INSERT INTO barangays VALUES("208","Santa Clara","9");
INSERT INTO barangays VALUES("209","Sulo","9");
INSERT INTO barangays VALUES("210","Tambanan","9");
INSERT INTO barangays VALUES("211","Taytay Manubo","9");
INSERT INTO barangays VALUES("212","Tilubog","9");
INSERT INTO barangays VALUES("213","Tipan","9");
INSERT INTO barangays VALUES("214","Upper Sulitan","9");
INSERT INTO barangays VALUES("215","Bateria","10");
INSERT INTO barangays VALUES("216","Calais","10");
INSERT INTO barangays VALUES("217","Esperanza","10");
INSERT INTO barangays VALUES("218","Fama","10");
INSERT INTO barangays VALUES("219","Galas","10");
INSERT INTO barangays VALUES("220","Gandaan","10");
INSERT INTO barangays VALUES("221","Kahayagan","10");
INSERT INTO barangays VALUES("222","Looc Sapi","10");
INSERT INTO barangays VALUES("223","Matim","10");
INSERT INTO barangays VALUES("224","Noque","10");
INSERT INTO barangays VALUES("225","Pulo Laum","10");
INSERT INTO barangays VALUES("226","Pulo Mabao","10");
INSERT INTO barangays VALUES("227","San Isidro","10");
INSERT INTO barangays VALUES("228","San Jose","10");
INSERT INTO barangays VALUES("229","Santa Maria","10");
INSERT INTO barangays VALUES("230","Solar (Poblacion)","10");
INSERT INTO barangays VALUES("231","Tambanan","10");
INSERT INTO barangays VALUES("232","Villacorte","10");
INSERT INTO barangays VALUES("233","Villagonzalo","10");
INSERT INTO barangays VALUES("234","Balian","11");
INSERT INTO barangays VALUES("235","Balogo","11");
INSERT INTO barangays VALUES("236","Balungisan","11");
INSERT INTO barangays VALUES("237","Binangonan","11");
INSERT INTO barangays VALUES("238","Bulacan","11");
INSERT INTO barangays VALUES("239","Bulawan","11");
INSERT INTO barangays VALUES("240","Calape","11");
INSERT INTO barangays VALUES("241","Dalama","11");
INSERT INTO barangays VALUES("242","Fatima (Silal)","11");
INSERT INTO barangays VALUES("243","Guiwan","11");
INSERT INTO barangays VALUES("244","Katipunan","11");
INSERT INTO barangays VALUES("245","Kima","11");
INSERT INTO barangays VALUES("246","Kulasian","11");
INSERT INTO barangays VALUES("247","Kulisap","11");
INSERT INTO barangays VALUES("248","La Fortuna","11");
INSERT INTO barangays VALUES("249","Labatan","11");
INSERT INTO barangays VALUES("250","Mayabo (Santa Maria)","11");
INSERT INTO barangays VALUES("251","Minundas (Santo. Niño)","11");
INSERT INTO barangays VALUES("252","Mountain View (Puluan)","11");
INSERT INTO barangays VALUES("253","Nanan","11");
INSERT INTO barangays VALUES("254","Poblacion (Payao)","11");
INSERT INTO barangays VALUES("255","San Isidro","11");
INSERT INTO barangays VALUES("256","San Roque","11");
INSERT INTO barangays VALUES("257","San Vicente (Binangonan)","11");
INSERT INTO barangays VALUES("258","Silal","11");
INSERT INTO barangays VALUES("259","Sumilong","11");
INSERT INTO barangays VALUES("260","Talaptap","11");
INSERT INTO barangays VALUES("261","Upper Sumilong","11");
INSERT INTO barangays VALUES("262","Ali Alsree","12");
INSERT INTO barangays VALUES("263","Balansag","12");
INSERT INTO barangays VALUES("264","Calula","12");
INSERT INTO barangays VALUES("265","Casacon","12");
INSERT INTO barangays VALUES("266","Don Perfecto","12");
INSERT INTO barangays VALUES("267","Gango","12");
INSERT INTO barangays VALUES("268","Katipunan","12");
INSERT INTO barangays VALUES("269","Kulambugan","12");
INSERT INTO barangays VALUES("270","Mabini","12");
INSERT INTO barangays VALUES("271","Magsaysay","12");
INSERT INTO barangays VALUES("272","Malubal","12");
INSERT INTO barangays VALUES("273","New Antique","12");
INSERT INTO barangays VALUES("274","New Sagay","12");
INSERT INTO barangays VALUES("275","Palmera","12");
INSERT INTO barangays VALUES("276","Pres. Roxas","12");
INSERT INTO barangays VALUES("277","Remedios","12");
INSERT INTO barangays VALUES("278","San Antonio","12");
INSERT INTO barangays VALUES("279","San Fernandino","12");
INSERT INTO barangays VALUES("280","San Jose","12");
INSERT INTO barangays VALUES("281","Santo Rosario","12");
INSERT INTO barangays VALUES("282","Siawang","12");
INSERT INTO barangays VALUES("283","Silingan","12");
INSERT INTO barangays VALUES("284","Surabay","12");
INSERT INTO barangays VALUES("285","Taruc","12");
INSERT INTO barangays VALUES("286","Tilasan","12");
INSERT INTO barangays VALUES("287","Tupilac","12");
INSERT INTO barangays VALUES("288","Bagongsilang","13");
INSERT INTO barangays VALUES("289","Balagon","13");
INSERT INTO barangays VALUES("290","Balingasan","13");
INSERT INTO barangays VALUES("291","Balucanan","13");
INSERT INTO barangays VALUES("292","Bataan (Dacanay)","13");
INSERT INTO barangays VALUES("293","Batu","13");
INSERT INTO barangays VALUES("294","Buyogan","13");
INSERT INTO barangays VALUES("295","Camanga","13");
INSERT INTO barangays VALUES("296","Coloran","13");
INSERT INTO barangays VALUES("297","Kimos (Kima)","13");
INSERT INTO barangays VALUES("298","Labasan","13");
INSERT INTO barangays VALUES("299","Lagting","13");
INSERT INTO barangays VALUES("300","Laih","13");
INSERT INTO barangays VALUES("301","Logpond","13");
INSERT INTO barangays VALUES("302","Magsaysay","13");
INSERT INTO barangays VALUES("303","Mahayahay","13");
INSERT INTO barangays VALUES("304","Maligaya","13");
INSERT INTO barangays VALUES("305","Maniha","13");
INSERT INTO barangays VALUES("306","Minsulao","13");
INSERT INTO barangays VALUES("307","Mirangan","13");
INSERT INTO barangays VALUES("308","Monching","13");
INSERT INTO barangays VALUES("309","Paruk","13");
INSERT INTO barangays VALUES("310","Poblacion","13");
INSERT INTO barangays VALUES("311","Princesa Sumama","13");
INSERT INTO barangays VALUES("312","Salinding","13");
INSERT INTO barangays VALUES("313","San Isidro","13");
INSERT INTO barangays VALUES("314","Sibuguey","13");
INSERT INTO barangays VALUES("315","Siloh","13");
INSERT INTO barangays VALUES("316","Villagracia","13");
INSERT INTO barangays VALUES("317","Aurora","14");
INSERT INTO barangays VALUES("318","Baganipay","14");
INSERT INTO barangays VALUES("319","Bolingan","14");
INSERT INTO barangays VALUES("320","Bualan","14");
INSERT INTO barangays VALUES("321","Cawilan","14");
INSERT INTO barangays VALUES("322","Florida","14");
INSERT INTO barangays VALUES("323","Kasigpitan","14");
INSERT INTO barangays VALUES("324","Laparay","14");
INSERT INTO barangays VALUES("325","Mahayahay","14");
INSERT INTO barangays VALUES("326","Moalboal","14");
INSERT INTO barangays VALUES("327","Poblacion (Talusan)","14");
INSERT INTO barangays VALUES("328","Sagay","14");
INSERT INTO barangays VALUES("329","Samonte","14");
INSERT INTO barangays VALUES("330","Tuburan","14");
INSERT INTO barangays VALUES("331","Achasol","15");
INSERT INTO barangays VALUES("332","Azusano","15");
INSERT INTO barangays VALUES("333","Bangco","15");
INSERT INTO barangays VALUES("334","Camanga","15");
INSERT INTO barangays VALUES("335","Culasian","15");
INSERT INTO barangays VALUES("336","Dalangin","15");
INSERT INTO barangays VALUES("337","Dalangin Muslim","15");
INSERT INTO barangays VALUES("338","Dalisay","15");
INSERT INTO barangays VALUES("339","Gomotoc","15");
INSERT INTO barangays VALUES("340","Imelda (Upper Camanga)","15");
INSERT INTO barangays VALUES("341","Kipit","15");
INSERT INTO barangays VALUES("342","Kitabog","15");
INSERT INTO barangays VALUES("343","La Libertad","15");
INSERT INTO barangays VALUES("344","Longilog","15");
INSERT INTO barangays VALUES("345","Mabini","15");
INSERT INTO barangays VALUES("346","Malagandis","15");
INSERT INTO barangays VALUES("347","Mate","15");
INSERT INTO barangays VALUES("348","Moalboal","15");
INSERT INTO barangays VALUES("349","Namnama","15");
INSERT INTO barangays VALUES("350","New Canaan","15");
INSERT INTO barangays VALUES("351","Palomoc","15");
INSERT INTO barangays VALUES("352","Poblacion (Titay)","15");
INSERT INTO barangays VALUES("353","Poblacion Muslim","15");
INSERT INTO barangays VALUES("354","Pulidan","15");
INSERT INTO barangays VALUES("355","San Antonio","15");
INSERT INTO barangays VALUES("356","San Isidro","15");
INSERT INTO barangays VALUES("357","Santa Fe","15");
INSERT INTO barangays VALUES("358","Supit","15");
INSERT INTO barangays VALUES("359","Tugop","15");
INSERT INTO barangays VALUES("360","Tugop Muslim","15");
INSERT INTO barangays VALUES("361","Baluran","16");
INSERT INTO barangays VALUES("362","Batungan","16");
INSERT INTO barangays VALUES("363","Cayamcam","16");
INSERT INTO barangays VALUES("364","Datu Tumanggong","16");
INSERT INTO barangays VALUES("365","Gaycon","16");
INSERT INTO barangays VALUES("366","Langon","16");
INSERT INTO barangays VALUES("367","Libertad (Pob.)","16");
INSERT INTO barangays VALUES("368","Linguisan","16");
INSERT INTO barangays VALUES("369","Little Margos","16");
INSERT INTO barangays VALUES("370","Loboc","16");
INSERT INTO barangays VALUES("371","Looc-labuan","16");
INSERT INTO barangays VALUES("372","Lower Tungawan","16");
INSERT INTO barangays VALUES("373","Malungon","16");
INSERT INTO barangays VALUES("374","Masao","16");
INSERT INTO barangays VALUES("375","San Isidro","16");
INSERT INTO barangays VALUES("376","San Pedro","16");
INSERT INTO barangays VALUES("377","San Vicente","16");
INSERT INTO barangays VALUES("378","Santo Niño","16");
INSERT INTO barangays VALUES("379","Sisay","16");
INSERT INTO barangays VALUES("380","Taglibas","16");
INSERT INTO barangays VALUES("381","Tigbanuang","16");
INSERT INTO barangays VALUES("382","Tigbucay","16");
INSERT INTO barangays VALUES("383","Tigpalay","16");
INSERT INTO barangays VALUES("384","Timbabauan","16");
INSERT INTO barangays VALUES("385","Upper Tungawan","16");



CREATE TABLE `breeds` (
  `breed_id` int(11) NOT NULL AUTO_INCREMENT,
  `breed_name` text NOT NULL,
  `species_id` int(11) NOT NULL,
  PRIMARY KEY (`breed_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO breeds VALUES("1","Shih Tzu","1");
INSERT INTO breeds VALUES("2","Affenpinscher","1");
INSERT INTO breeds VALUES("3","Alaskan Klee Kai ","1");
INSERT INTO breeds VALUES("4","Shiba Inu ","1");
INSERT INTO breeds VALUES("5","Pomeranian ","1");
INSERT INTO breeds VALUES("6","Abyssinian","2");
INSERT INTO breeds VALUES("7","Ragdoll","2");
INSERT INTO breeds VALUES("8","Persian","2");
INSERT INTO breeds VALUES("9","Burmese","2");
INSERT INTO breeds VALUES("10","Chartreux","2");



CREATE TABLE `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO cart VALUES("13","7","1","2");
INSERT INTO cart VALUES("36","10","5","1");
INSERT INTO cart VALUES("44","2","7","14");



CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `cat_slug` text NOT NULL,
  `delete_flag` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO category VALUES("1","Cat","cat","0");
INSERT INTO category VALUES("2","Dog","dog","0");
INSERT INTO category VALUES("3","Both Cat and Dog","both cat and dog","0");



CREATE TABLE `consult_records` (
  `cr_id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `vet_id` int(11) NOT NULL,
  `weight` double NOT NULL,
  `temperature` float NOT NULL,
  `cbc` text NOT NULL,
  `chw` text NOT NULL,
  `ana` text NOT NULL,
  `bab` text NOT NULL,
  `ehr` text NOT NULL,
  `diagnosis` text NOT NULL,
  `prescription` text NOT NULL,
  `date_recorded` date NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`cr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO consult_records VALUES("15","2","11","9","2","35.8","Normal","Postive","Negative","Positive","Positive","Kennel cough","amitraz","2024-10-23");



CREATE TABLE `consultation` (
  `consult_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `vet_id` int(11) NOT NULL,
  `schedule` date DEFAULT NULL,
  `weight` double NOT NULL,
  `temperature` float NOT NULL,
  `cbc` text NOT NULL,
  `chw` text NOT NULL,
  `ana` text NOT NULL,
  `bab` text NOT NULL,
  `ehr` text NOT NULL,
  `diagnosis` text NOT NULL,
  `prescription` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `type` int(11) NOT NULL,
  `delete_flag` tinyint(4) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`consult_id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO consultation VALUES("67","1","2","11","9","2024-10-23","0","0","","","","","","","","0","10","0","2024-10-24 16:39:54","");



CREATE TABLE `details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sales_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_id` (`sales_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO details VALUES("16","43","12","2");
INSERT INTO details VALUES("17","43","16","2");
INSERT INTO details VALUES("18","44","7","1");
INSERT INTO details VALUES("19","45","10","1");



CREATE TABLE `disease_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `count` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO disease_records VALUES("1","kennel cough","3","2024-07-27 01:36:52");
INSERT INTO disease_records VALUES("2","dying","3","2024-07-27 01:36:52");
INSERT INTO disease_records VALUES("3","fe","1","2024-07-27 05:32:58");



CREATE TABLE `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` text NOT NULL,
  `email` text NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO feedback VALUES("11","Ilcyd Revantad","ilcydrevs@gmail.com","asdfadsfasdfasdfasdf");
INSERT INTO feedback VALUES("12","Ilcyd Revantad","ilcydrevs@gmail.com","asdfadsfasdfasdfasdf");



CREATE TABLE `grooming` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `schedule` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO grooming VALUES("1","8","2","11","0","2024-07-28");



CREATE TABLE `municipalities` (
  `municipality_id` int(11) NOT NULL AUTO_INCREMENT,
  `municipality_name` text NOT NULL,
  `province_id` int(11) NOT NULL,
  PRIMARY KEY (`municipality_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO municipalities VALUES("1","Alicia","1");
INSERT INTO municipalities VALUES("2","Buug","1");
INSERT INTO municipalities VALUES("3","Diplahan","1");
INSERT INTO municipalities VALUES("4","Imelda","1");
INSERT INTO municipalities VALUES("5","Ipil","1");
INSERT INTO municipalities VALUES("6","Kabasalan","1");
INSERT INTO municipalities VALUES("7","Mabuhay","1");
INSERT INTO municipalities VALUES("8","Malangas","1");
INSERT INTO municipalities VALUES("9","Naga","1");
INSERT INTO municipalities VALUES("10","Olutanga","1");
INSERT INTO municipalities VALUES("11","Payao","1");
INSERT INTO municipalities VALUES("12","Roseller Lim","1");
INSERT INTO municipalities VALUES("13","Siay","1");
INSERT INTO municipalities VALUES("14","Talusan","1");
INSERT INTO municipalities VALUES("15","Titay","1");
INSERT INTO municipalities VALUES("16","Tungawan","1");



CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `new_user_id` int(11) NOT NULL DEFAULT 0,
  `owner_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `message` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO notifications VALUES("34","10","0","0","0","Your appointment has been approved","0","2024-07-27 09:51:30");
INSERT INTO notifications VALUES("37","10","0","0","0","Your appointment has been approved","0","2024-07-27 17:39:21");
INSERT INTO notifications VALUES("41","1","12","0","0","A new user has registered","1","2024-08-19 11:37:27");
INSERT INTO notifications VALUES("42","1","13","0","0","A new user has registered","1","2024-08-19 11:44:34");
INSERT INTO notifications VALUES("51","9","0","2","0","An Appointment has been made.","1","2024-10-23 15:05:10");
INSERT INTO notifications VALUES("52","1","14","0","0","A new user has registered","1","2024-10-24 16:06:57");
INSERT INTO notifications VALUES("53","9","0","12","0","An Appointment has been made.","1","2024-10-24 16:30:38");



CREATE TABLE `pets` (
  `pet_id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `pet_name` text NOT NULL,
  `species_id` int(11) NOT NULL,
  `breed_id` int(11) NOT NULL,
  `birthdate` date NOT NULL,
  `gender` text NOT NULL,
  `vaccine_status` int(11) NOT NULL,
  `vaccine_type` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `delete_flag` tinyint(4) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`pet_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO pets VALUES("10","2","ilcyd","1","1","2017-02-07","Male","0","0","1","0","2024-04-18 23:30:16","2024-10-11 17:10:48");
INSERT INTO pets VALUES("11","2","Dylan","1","1","2014-07-25","Male","0","0","1","0","2024-04-19 09:20:31","2024-10-08 21:39:45");
INSERT INTO pets VALUES("16","2","asdf","2","6","0000-00-00","Male","0","0","0","1","2024-07-25 09:27:44","2024-07-25 09:28:15");
INSERT INTO pets VALUES("17","2","asdf","2","6","0000-00-00","Male","0","0","0","1","2024-07-25 09:28:05","2024-07-25 11:06:47");
INSERT INTO pets VALUES("18","10","Happy","1","1","0000-00-00","Male","0","0","0","0","2024-07-26 15:13:49","0000-00-00 00:00:00");
INSERT INTO pets VALUES("19","10","Sad","2","8","0000-00-00","Female","0","0","0","0","2024-07-26 21:21:59","0000-00-00 00:00:00");
INSERT INTO pets VALUES("20","10","Angry","2","7","0000-00-00","Male","0","0","0","0","2024-07-26 22:06:22","0000-00-00 00:00:00");
INSERT INTO pets VALUES("21","2","asdfasdf","1","1","2014-07-30","Male","0","0","0","0","2024-08-18 10:09:41","2024-10-11 17:09:25");
INSERT INTO pets VALUES("22","12","0","1","1","0000-00-00","Female","1","0","0","1","2024-10-24 16:12:50","2024-10-24 16:13:35");
INSERT INTO pets VALUES("23","12","kaido","1","4","2024-10-09","Male","1","0","0","0","2024-10-24 16:14:21","");



CREATE TABLE `prescription_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `count` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO prescription_records VALUES("1","axmel","2","2024-07-27 01:44:45");
INSERT INTO prescription_records VALUES("2","amitraz","2","2024-07-27 01:44:45");
INSERT INTO prescription_records VALUES("3","wef","1","2024-07-27 05:32:58");



CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` varchar(255) NOT NULL,
  `slug` text NOT NULL,
  `price` int(11) NOT NULL,
  `discount_price` int(11) DEFAULT NULL,
  `photo` text NOT NULL,
  `stock` int(11) NOT NULL,
  `expiry_date` date NOT NULL,
  `date_view` date NOT NULL,
  `counter` int(11) NOT NULL,
  `new_price` int(11) DEFAULT NULL,
  `new_stock` int(11) DEFAULT NULL,
  `new_exp_date` date DEFAULT NULL,
  `delete_flag` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `subcategory_id` (`subcategory_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO products VALUES("5","3","5","Tritozine","For the treatment of the gastrointestinal,urinary tract,respiratory and skin infections in dogs &cats controls and kennel cough","tritozine","250","","tritozine.jpg","10","2025-02-12","2024-10-16","4","","","","0");
INSERT INTO products VALUES("7","3","6","Amitraz Ketoconazole Furfect Soap","Furfect Soap Amitraz + Ketoconazole 150g for Dogs and Cats\r\n\r\nIndications:\r\nFor treatment and control of Demodectic mange and scabies, tick and flea infestation.\r\n\r\nDirections for use:\r\n-Apply SOAP liberally into pet\'s skin and coat and allow it to remain","amitraz ketoconazole furfect soap","215","194","amitraz + ketoconazole furfect soap.jpg","14","2024-10-17","2024-10-21","1","","0","","0");
INSERT INTO products VALUES("8","3","5","Metronodazole Flavet","Formulation\r\n\r\nIndications\r\n\r\n\r\nMetronidazole is an amoebicide, antiprotozoal, antibacterial, and antiparasitic medication use to treat various conditions such as inflammatory bowel disease, nonspecific diarrheal disorders, infections caused by Giardia (i","metronodazole flavet","120","108","metronodazole flavet.jpg","18","2024-11-06","2024-10-18","1","","0","0000-00-00","0");
INSERT INTO products VALUES("9","2","7","Papi Amitraz Soap Anti Mange","    DIRECTION FOR USE:\r\n    Wet the dog with lukewarm water.\r\n    Lather the soap from the head down to the tail concentrating on the most affected areas.\r\n    Bathe your dog at least thrice a week.\r\n    PRECAUTIONS:\r\n    For medium and large breeds only,","papi amitraz soap anti mange","130","0","papi amitraz soap anti mange.jpg","2","2026-08-01","2024-10-16","1","","0","0000-00-00","0");
INSERT INTO products VALUES("10","3","5","Emerplex","EMERPLEX Vitamin B Complex 12OML\r\n\r\ndosage: dogs and cats: 1ml/10kg","emerplex","225","0","emerplex.jpg","7","2026-09-01","2024-10-16","3","","0","0000-00-00","0");
INSERT INTO products VALUES("11","3","5","Emervit","EMERVIT Multivitamins + Taurine 120 ml with Free Syringe\r\n\r\nIndications:\r\n-For increased appetite during stressful conditions like vaccination, deworming, weaning, bacterial and viral infections.\r\n\r\nRecommended Dosage:\r\n- to be given daily during meals or","emervit","180","0","emervit.jpg","7","2025-07-01","2024-07-27","1","","0","0000-00-00","0");
INSERT INTO products VALUES("12","3","5","Entropet","Indication\r\nTreatment of infections in dogs and cats caused by bacteria susceptible to enrofloxacin.\r\nDosage\r\nDogs and cats: 5 mg/kg given orally once daily or as divided doses twice daily for 3-10 days. Or as prescribed by a licensed veterinarian.\r\nContr","entropet","100","0","entropet.jpg","3","2026-07-31","2024-07-26","4","","0","0000-00-00","0");
INSERT INTO products VALUES("13","3","5","Prazilex","PRAZIQUANTEL+LEVAMISOL HYDROCHLORIDE \r\nanthelmintic/antiparasitic\r\nfor dogs/kittens\r\n\r\n\r\n\r\n*dogs-administer 1 tab. 10kg weight\r\n-treat dogs in hydatid areas every 6 weeks. \r\nfor the control of tapeworms,  roundworm and hookworms","prazilex","45","0","prazilex.jpg","1","2026-07-31","2024-07-26","1","","0","0000-00-00","0");
INSERT INTO products VALUES("14","3","5","Bio-Gentadrop","BIO-GENTRADROP For Pets-Antibacterial is 💯\r\n Effective for Eye treatment infections for pets Dogs,cats goats,sheep.\r\n\r\n 👉 Gamot sa pag mumuta, panlalabo ,pamumula,pamamaga \r\n\r\n👉For Pets only.\r\n\r\n Formulation: \r\n👉 1 - 2 drops for Small animals\r\n👉 4 - 5 dro","bio-gentadrop","280","0","bio-gentadrop.jpg","1","2025-08-27","0000-00-00","0","","0","0000-00-00","0");
INSERT INTO products VALUES("15","3","5","Allercare","INDICATION:\r\n\r\nDOGS - Used primarily to treat     \r\n allergic symptons and itchy \r\n     skin like allergic dermatitis \r\n     and atopy in dogs.\r\n\r\nCATS - Used to treat \r\n      non-responsive chronic \r\n      inflammation of the nose   \r\n      and sinuses ","allercare","250","0","allercare.jpg","18","2026-07-22","0000-00-00","0","","0","0000-00-00","0");
INSERT INTO products VALUES("16","3","5","Axmel","Indications\r\n\r\n    Otitis media; Periodontitis; Pneumonia; Rhinosinusitis; Skin and soft tissue infection; Urinary tract infection.\r\n\r\nAdministration\r\n\r\n    May administer with or without food. May be taken with meals for better absorption & to reduce GI ","axmel","90","0","axmel.jpg","18","2026-11-11","2024-07-27","1","","0","0000-00-00","0");
INSERT INTO products VALUES("17","3","5","Papi Broncure","Papi Broncure is a combination of Fermented Herbs of Oregano and Sambong that help control and relieve colds, cough and other respiratory problem of Dogs, Cats and other Pets.\r\n\r\nDOSAGE AND ADMINISTRATION:\r\nTo be given twice a day for 5 to 7 days orally o","papi broncure","250","0","papi broncure.jpg","8","2025-05-06","2024-10-16","1","","0","0000-00-00","0");
INSERT INTO products VALUES("18","3","5","Papi Scour","\r\n\r\n    SAFE TO USE on dogs, cats and other small animals\r\n    Anti-Scouring\r\n    Per 60mL contains:Sulfadiazine Sodium @ 850mgTrimethroprim @ 80mgPenicillin @ 224mgSodium Chloride @ 500mgCalcium Gluconate @ 125mg\r\n    Magnesium Sulfate @ 36mgPotassium Ch","papi scour","220","0","papi scour.jpg","5","2026-07-24","0000-00-00","0","","0","0000-00-00","0");
INSERT INTO products VALUES("19","3","5","Ener-G","Ener G Probiotic Supplement 60ml\r\n\r\nIndication:\r\nFor better nutrient assimilation through effective digestion by invading the intestinal flora of probiotic beneficial microorganisms.\r\n\r\nAction:\r\nControls the multiplication of harmful bacteria in the intes","ener-g","200","0","ener-g.jpg","7","2025-06-30","0000-00-00","0","","0","0000-00-00","0");
INSERT INTO products VALUES("20","3","5","Prefolic-Cee","\r\n\r\nPREFOLIC-CEE is a complete anti-anemia supplement that prevents and treats anemia in pregnant pets.\r\n\r\nIt is specially formulated to support immune systems and enhance the body’s natural anti-anemic properties.\r\n\r\nPREFOLIC-CEE contains vitamins, miner","prefolic-cee","450","0","prefolic-cee.jpg","10","2026-07-31","0000-00-00","0","","0","0000-00-00","0");
INSERT INTO products VALUES("21","3","5","Petpyrin","\r\n\r\nPetsmed Petpyrin (Antipyretic, Analgesic, Anti-inflammatory) 60ml\r\n\r\nIt relieves painful conditions during injuries and surgical operation\r\nIt helps to subside any inflammatory conditions\r\nIt has antipyretic effect\r\n\r\nOral Usage:\r\nSmall breed dog 1-2m","petpyrin","280","0","petpyrin.jpg","8","2025-08-09","2024-07-26","3","","0","0000-00-00","0");



CREATE TABLE `provinces` (
  `province_id` int(11) NOT NULL AUTO_INCREMENT,
  `province_name` text NOT NULL,
  PRIMARY KEY (`province_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO provinces VALUES("1","Zamboanga Sibugay");



CREATE TABLE `sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `pay_id` text NOT NULL,
  `sales_date` date NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO sales VALUES("43","2","pay_jLTrrtSNRYz2Nmao8fbqy3Ur","2024-07-26");
INSERT INTO sales VALUES("44","2","pay_kuJaCwFAQsJUkVFp6QuKtvya","2024-08-18");
INSERT INTO sales VALUES("45","2","pay_6hT2zw3QbedTbNbSopygwC73","2024-10-15");



CREATE TABLE `services` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_name` text NOT NULL,
  `price` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `delete_flag` tinyint(4) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO services VALUES("1","Consultation","350","1","0","2024-04-06 00:21:43","2024-04-20 18:43:47");
INSERT INTO services VALUES("2","Vaccination","450","1","0","2024-04-06 17:08:18","2024-04-20 18:18:54");
INSERT INTO services VALUES("3","Deworming","300","1","0","2024-04-07 01:29:04","2024-04-20 18:19:41");
INSERT INTO services VALUES("4","Surgery","750","1","0","2024-04-08 20:17:34","0000-00-00 00:00:00");
INSERT INTO services VALUES("5","Boarding","500","1","0","2024-04-08 20:17:48","0000-00-00 00:00:00");
INSERT INTO services VALUES("6","Medications","450","1","0","2024-04-08 20:18:06","0000-00-00 00:00:00");
INSERT INTO services VALUES("7","Laboratory","350","1","0","2024-04-08 20:18:21","0000-00-00 00:00:00");
INSERT INTO services VALUES("8","Grooming","200","1","0","2024-04-08 20:18:37","0000-00-00 00:00:00");
INSERT INTO services VALUES("10","edfasdf","120","0","0","2024-07-27 19:10:01","2024-07-27 19:22:23");



CREATE TABLE `settings` (
  `open_time` time NOT NULL,
  `close_time` time NOT NULL,
  `crit_level` int(11) NOT NULL,
  `discount_percent` int(11) NOT NULL,
  `discount_show_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO settings VALUES("08:00:00","20:00:00","3","10","30");



CREATE TABLE `species` (
  `species_id` int(11) NOT NULL AUTO_INCREMENT,
  `species_name` text NOT NULL,
  PRIMARY KEY (`species_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO species VALUES("1","Dog");
INSERT INTO species VALUES("2","Cat");



CREATE TABLE `subcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `delete_flag` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO subcategory VALUES("1","1","Cage","1");
INSERT INTO subcategory VALUES("2","2","Cage","1");
INSERT INTO subcategory VALUES("3","1","Food","0");
INSERT INTO subcategory VALUES("4","2","Food","0");
INSERT INTO subcategory VALUES("5","3","Medicine","0");
INSERT INTO subcategory VALUES("6","3","Pet Care","0");
INSERT INTO subcategory VALUES("7","2","Dog Care","0");
INSERT INTO subcategory VALUES("8","3","Cage","0");



CREATE TABLE `transact_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `date_created` date NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




CREATE TABLE `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` text NOT NULL,
  `owner_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `date_created` date NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO transactions VALUES("1","20240817-0001","10","18","1","2024-08-17","0");
INSERT INTO transactions VALUES("2","20240818-0002","10","20","1","2024-08-18","0");
INSERT INTO transactions VALUES("3","20240818-0003","2","10","1","2024-08-18","0");
INSERT INTO transactions VALUES("4","20240818-0004","2","21","1","2024-08-18","0");
INSERT INTO transactions VALUES("5","20240819-0005","10","19","1","2024-08-19","0");
INSERT INTO transactions VALUES("6","20241011-0006","2","10","1","2024-10-11","0");



CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `type` int(11) NOT NULL,
  `firstname` text NOT NULL,
  `middlename` text NOT NULL,
  `lastname` text NOT NULL,
  `address` text NOT NULL,
  `contact` text NOT NULL,
  `valid_id_type` int(11) NOT NULL,
  `valid_id` text NOT NULL,
  `profile` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `delete_flag` int(11) NOT NULL DEFAULT 0,
  `reset_code` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `valid_id_type` (`valid_id_type`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO users VALUES("1","admin@admin.com","$2y$10$LFuG9ljEv.VilgnnsabDUO42Rr2r5uJVvqkXBMrDhsJif/2Huqg1q","2","Ilcyd","Phernan","Revantad","Purok 5, Santa Clara, Naga, Zamboanga Sibugay","09539903167","4","valid_id.jpg","profile.jpg","1","0","","2024-06-05 11:20:20","0000-00-00 00:00:00");
INSERT INTO users VALUES("2","ilcydrevs@gmail.com","$2y$10$bLQChc7.C/5A5OfNeehE/OCPcV/VY8klne2oATzpI3iT3rlaaK8yG","0","Ilcyd","Pulongbarit","Revantad","Santa Clara, Naga, Zamboanga Sibugay","09539903167","4","59a28ff0054ed30001e4ebc9_Presentation.jpg","59a28ff0054ed30001e4ebc9_Presentation.jpg","1","0","XJklSt5n8RGoCFi","2024-06-05 13:36:58","2024-08-18 10:08:56");
INSERT INTO users VALUES("4","ackyanndawana@gmail.com","$2y$10$RHeMQPntFFga61jfX1VKtO558R.7jlMB.aawN9wquMzmUnrv/q7Km","0","acky","","dawana","2, Ipil Heights, Ipil, Zamboanga Sibugay","09810668754","6","59a28ff0054ed30001e4ebc9_Presentation.jpg","isolated-of-a-clean-green-blue-planet-recycl-vector-2875502.jpg","1","0","","2024-06-06 17:27:50","2024-06-06 17:34:14");
INSERT INTO users VALUES("7","ilcydrevs2@gmail.com","$2y$10$.XD8esEFs9ugZg3rR1Bzy.tMOWc0N7zTaqKPDNvfnHjGoq7ZspSU2","0","ilcyd","qwe","qwe","Purok 5, Santa Clara, Naga, Zamboanga Sibugay","09539903167","4","59a28ff0054ed30001e4ebc9_Presentation.jpg","429661684_397565062899511_5890054117614121500_n.jpg","1","0","","2024-06-08 16:41:59","2024-06-08 16:42:26");
INSERT INTO users VALUES("8","ilcydrevs1@gmail.com","$2y$10$e94De.2.QehVxidqqI9oh.xq3qdZMEVxNXCIw1PaijR8K.D.AjcQ6","0","ading","","ading","Purok 5, Santa Clara, Naga, Zamboanga Sibugay","09539903167","4","R (1).jpg","R.jpg","1","0","","2024-06-10 08:56:16","2024-06-10 08:56:37");
INSERT INTO users VALUES("9","ipdvc2023@gmail.com","$2y$10$1KfLZCfUX/AlTmJYbfxVxeZ6lWgVHHlOrChuR8/2VffYm18mux0wu","1","Shynne","asdf","De Masa","","","1","asdf","nurse-midwife-5261766.jpg","1","0","","2024-07-23 13:32:32","2024-08-18 10:21:04");
INSERT INTO users VALUES("10","yvonnefabillar3@gmail.com","$2y$10$Ciu2KTUSFZ9tsHTlbSaZbuEFYczh0lU3H6yASzOmH9Itdx7Pkfwfy","0","Yvonne","Polinar","Fabillar","Sea Side, Poblacion (Talusan), Talusan, Zamboanga Sibugay","09352408285","3","59a28ff0054ed30001e4ebc9_Presentation.jpg","adjunct-professor.jpg","1","0","","2024-07-26 15:07:51","2024-07-26 22:27:34");
INSERT INTO users VALUES("11","rogenpahuwayan@gmail.com","$2y$10$7oU/I9BwFL/jb2bAuqRmb.iAOHoq1UIye5npPYzsh6XPEWHEQ0HaG","0","Rogen","Zamora","Pahuwayan","Star Apple, New Sagay, Roseller Lim, Zamboanga Sibugay","09516564058","11","angry-patient-man-hospital-room-lying-bed-pressing-nurse-call-button-feeling-nervous-upset-young-some-kind-56792950.webp","well-get-you-support-need-to-female-nurse-comforting-her-patient-252730454.webp","0","0","","2024-07-26 22:39:37","0000-00-00 00:00:00");
INSERT INTO users VALUES("12","jeamarianmalanog@gmail.com","$2y$10$KzyEAgrR7YEZLq5Pspjs0uqQQbYRh8YNZ3TiNIHxM78ZB3IfnEh7G","0","Jea Marian","Casuna","Malanog","12, Solar (Poblacion), Olutanga, Zamboanga Sibugay","09282879316","4","429673614_397563086233042_832431483192264704_n.jpg","429661684_397565062899511_5890054117614121500_n.jpg","1","0","","2024-08-19 11:37:27","2024-08-19 11:46:13");
INSERT INTO users VALUES("13","jeamarianmalano94@gmail.com","$2y$10$xqY/b1bVk3xto9CQ9MwDbexaS3.HtZX/I07kiBsknpVyLWp1N12mm","0","Jea Marian","Casuna","Malanog","2, San Isidro, Olutanga, Zamboanga Sibugay","09282879316","1","59a28ff0054ed30001e4ebc9_Presentation.jpg","429661684_397565062899511_5890054117614121500_n.jpg","1","0","","2024-08-19 11:44:34","2024-10-24 16:32:41");
INSERT INTO users VALUES("14","jeamarianmalanog94@gmail.com","$2y$10$o0j34KiDVR6Dn6PIXtEg9uQk6EEAuodRjpd8J/S1IQ8HgkrjAngI2","0","JEA MARIAN","CASUNA","MALANOG","12, Solar (Poblacion), Olutanga, Zamboanga Sibugay","09282879316","1","STII LOGO.jpg","STII_LOGO-removebg.png","0","0","","2024-10-24 16:06:57","");



CREATE TABLE `vaccination` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `vet_id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 1,
  `schedule` date NOT NULL,
  `next_schedule` date NOT NULL,
  `notes` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `status2` tinyint(4) NOT NULL DEFAULT 0,
  `delete_flag` tinyint(4) NOT NULL DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO vaccination VALUES("28","2","2","11","9","10","2024-10-23","0000-00-00","","0","0","0","2024-10-24 16:39:54");
INSERT INTO vaccination VALUES("29","2","12","23","9","12","2024-11-01","0000-00-00","","0","0","0","2024-10-24 16:40:01");
INSERT INTO vaccination VALUES("32","2","12","23","9","12","2024-11-01","0000-00-00","","0","0","0","2024-10-24 19:33:17");



CREATE TABLE `vaccine_records` (
  `vr_id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `vet_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `date_taken` date NOT NULL,
  `notes` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`vr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO vaccine_records VALUES("4","2","11","9","10","2024-10-23","asdfasdf","2024-10-23 22:57:51");



CREATE TABLE `vaccine_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL DEFAULT 2,
  `cat_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO vaccine_types VALUES("3","2","1","Bordetella bronchiseptica","Protects against Bordetella bronchiseptica, a bacterium that causes kennel cough in dogs.","2024-08-06 15:54:28");
INSERT INTO vaccine_types VALUES("4","2","1","Leptospirosis","Protects against Leptospirosis, a bacterial infection that can cause liver and kidney damage.","2024-08-06 15:54:28");
INSERT INTO vaccine_types VALUES("5","2","1","Lyme Disease","Protects against Lyme Disease, a tick-borne illness that can lead to joint and organ issues.","2024-08-06 15:54:28");
INSERT INTO vaccine_types VALUES("6","2","1","Canine Influenza","Protects against Canine Influenza, a flu-like illness in dogs.","2024-08-06 15:54:28");
INSERT INTO vaccine_types VALUES("7","2","2","Chlamydia","Protects against Chlamydophila felis, a bacterium that causes conjunctivitis and respiratory issues in cats.","2024-08-06 15:54:28");
INSERT INTO vaccine_types VALUES("8","2","2","Feline Leukemia Virus (FeLV)","Protects against FeLV, a virus that affects the immune system and can lead to cancer.","2024-08-06 15:54:28");
INSERT INTO vaccine_types VALUES("9","2","2","Feline Immunodeficiency Virus (FIV)","Protects against FIV, a virus that affects the immune system similar to HIV in humans.","2024-08-06 15:54:28");
INSERT INTO vaccine_types VALUES("10","2","3","Rabies","Protects against rabies, a deadly virus that can affect both animals and humans.","2024-08-06 15:54:28");
INSERT INTO vaccine_types VALUES("11","2","3","Distemper","Protects against canine distemper, a virus that affects multiple systems in dogs and can cause severe illness in cats.","2024-08-06 15:54:28");
INSERT INTO vaccine_types VALUES("12","2","3","Parvovirus","Protects against parvovirus, a highly contagious virus that causes severe gastrointestinal disease in dogs and can affect cats.","2024-08-06 15:54:28");
INSERT INTO vaccine_types VALUES("13","2","3","Adenovirus (Hepatitis)","Protects against canine adenovirus type 1, which causes infectious hepatitis in dogs and can cause respiratory issues in cats.","2024-08-06 15:54:28");
INSERT INTO vaccine_types VALUES("14","2","3","Feline Viral Rhinotracheitis (FVR)","Protects against feline herpesvirus, causing respiratory issues in cats.","2024-08-06 15:54:28");
INSERT INTO vaccine_types VALUES("15","2","3","Calicivirus","Protects against feline calicivirus, which can cause respiratory infections and oral ulcers in cats.","2024-08-06 15:54:28");
INSERT INTO vaccine_types VALUES("16","2","3","Panleukopenia","Protects against feline panleukopenia, a severe viral disease that affects the digestive and immune systems in cats.","2024-08-06 15:54:28");



CREATE TABLE `valid_id_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT 1,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO valid_id_type VALUES("1","1","Philippine Passport from Department of Foreign Affairs");
INSERT INTO valid_id_type VALUES("2","1","SSS ID or SSS UMID Card from Social Security System (SSS)");
INSERT INTO valid_id_type VALUES("3","1","GSIS ID or GSIS UMID Card Government Service Insurance System (GSIS)");
INSERT INTO valid_id_type VALUES("4","1","Driver\'s License from Land Transportation Office (LTO)");
INSERT INTO valid_id_type VALUES("5","1","PRC ID from Professional Regulatory Commission (PRC)");
INSERT INTO valid_id_type VALUES("6","1","OWWA ID Overseas Workers Welfare Administration (OWWA)");
INSERT INTO valid_id_type VALUES("7","1","IDOLE Card from Department of Labor and Employment (IDOLE)");
INSERT INTO valid_id_type VALUES("8","1","Voter\'s ID from Commission on Elections (COMELEC)");
INSERT INTO valid_id_type VALUES("9","1","Voter\'s Certification from the Officer of Election with Dry Seal");
INSERT INTO valid_id_type VALUES("10","1","Firearms License from Philippine National Police (PNP)");
INSERT INTO valid_id_type VALUES("11","1","Senior Citizen ID from Local Government Unit (LGU)");
INSERT INTO valid_id_type VALUES("12","1","Persons with Disabilities (PWD) ID from Local Government Unit (LGU)");
INSERT INTO valid_id_type VALUES("13","1","NBI Clearance from National Bureau of Investigation (NBI)");
INSERT INTO valid_id_type VALUES("14","1","Alien Certification of Registration or Immigrant Certificate of Registration");
INSERT INTO valid_id_type VALUES("15","1","PhilHealth ID (digitized PVC)");
INSERT INTO valid_id_type VALUES("16","1","Government Office and GOCC ID");
INSERT INTO valid_id_type VALUES("17","1","Integrated Bar of the Philippines ID");
INSERT INTO valid_id_type VALUES("18","1","School ID (for students) from the current School or University");
INSERT INTO valid_id_type VALUES("19","1","Current Valid ePassport (For Renewal of ePassport)");
INSERT INTO valid_id_type VALUES("20","2","TIN ID");
INSERT INTO valid_id_type VALUES("21","2","Postal ID (issued 2015 onwards)");
INSERT INTO valid_id_type VALUES("22","2","Barangay Certification");
INSERT INTO valid_id_type VALUES("23","2","Government Service Insurance System (GSIS) e-Card");
INSERT INTO valid_id_type VALUES("24","2","Seaman\'s Book");
INSERT INTO valid_id_type VALUES("25","2","Certification from the National Council for the Welfare of Disabled Persons (NCWDP)");
INSERT INTO valid_id_type VALUES("26","2","Department of Social Welfare and Development (DSWD) Certification");
INSERT INTO valid_id_type VALUES("27","2","Company IDs issued by Private Entities or Institutions registered with or supervised or regulated either by the BSP, SEC or IC");
INSERT INTO valid_id_type VALUES("28","2","Police Clearance");
INSERT INTO valid_id_type VALUES("29","2","Barangay Clearance");
INSERT INTO valid_id_type VALUES("30","2","Cedula or Community Tax Certificate");
INSERT INTO valid_id_type VALUES("31","2","Government Service Record");
INSERT INTO valid_id_type VALUES("32","2","Elementary or High School Form 137 for students");
INSERT INTO valid_id_type VALUES("33","2","Transcript of Records from University or College");
INSERT INTO valid_id_type VALUES("34","2","Land Title");
INSERT INTO valid_id_type VALUES("35","2","PSA Marriage Contract");
INSERT INTO valid_id_type VALUES("36","2","PSA Birth Certificate");

