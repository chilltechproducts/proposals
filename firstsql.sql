//created and inserted 12:03PM Monday November 12th 2018

create table user_levels (level_id int(99) not null auto_increment, level_name varchar(200), endpoints longtext, created_by int(99), primary key(level_id));

insert into user_levels (level_id, level_name) values(null, 'Administrator'), (null, 'Dealer'), (null, 'Dealer Admin'), (null, 'Dealer Office'), (null 'Salesman'), (null, 'Service Tech'), (null, 'Maintanence'), (null, 'Client');

create table users (user_id int(99) not null auto_increment, level_id int(99) not null, dealer_id int(99) not null, fullname varchar(200) not null, username varchar(200) not null, password varchar(200) not null, street_address varchar(300), street_address2 varchar(100), city varchar(200) not null, state int(99), state_province_code varchar(100), postal_code varchar(100), country_id int(99), business_phone varchar(200), service_phone varchar(200), sales_phone varchar(200), emergency_phone varchar(200), fax_phone varchar(200), email varchar(200), employer_identication_number varchar(200), webhook_url varchar(400), user_website varchar(300), user_facebook varchar(300),  primary key(user_id));


create table dealers (dealer_id int(99) not null auto_increment, dealer_name varchar(300), owner_contact_name varchar(200),  street_address varchar(300), street_address2 varchar(100), city varchar(200) not null, state int(99), state_province_code varchar(100), postal_code varchar(100), country_id int(99), business_phone varchar(200), service_phone varchar(200), sales_phone varchar(200), emergency_phone varchar(200), fax_phone varchar(200), email varchar(200), employer_identication_number varchar(200), webhook_url varchar(400), dealers_website varchar(300), dealers_facebook varchar(300), primary key(dealer_id));

create table proposals (proposal_id int(99) not null auto_increment, unique_key int(99) not null, pdf_link varchar(300), salesman_id int(99) not null, dealer_id int(99) not null, customer_id int(99) not null, primary key(proposal_id));

create table part_data (location_id int(99) not null auto_increment, location_name varchar(300) not null, qr_code longtext not null, customer_id int(99) not null, dealer_id int(99) not null, salesman_id int(99) not null, part_warranty_id int(99), labor_warranty_id int(99), last_service_date datetime, install_date datetime, floor varchar(200), service_tech_id int(99), maintanence_id int(99), latitude decimal(9, 9), longitude decimal(9, 9), primary key(location_id));  

create table labor_warranty (labor_warranty_id int(99) not null auto_increment, dealer_id int(99), labor_warranty_text longtext, created datetime, modified datetime, length_of_labor_warranty int(99), primary key(labor_warranty_id));


create table part_warranty (part_warranty_id int(99) not null auto_increment, dealer_id int(99), part_warranty_text longtext, created datetime, modified datetime, length_of_part_warranty int(99), manufacturer_id int(99) not null, sku_number varchar(200), upc_label varchar(300),  primary key(part_warranty_id));

create table parts_categories (category_id int(99) not null auto_increment, category_name varchar(200), primary key(category_id));

create table manufacturers (manufacturer_id int(99) not null auto_increment, manufacturer_name varchar(300), manufacturer_website varchar(200), manufacturer_address varchar(400), manufacturer_phone varchar(100), manufacturer_email varchar(300), primary key(manufacturer_id));




//created and inserted 12:03PM Monday November 12th 2018
//created and inserted 12:08PM Monday November 12th 2018
//created for third party user login/registration system
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `tokens` (
  `token_id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  `user_id` int(10) NOT NULL,
  `created` date NOT NULL,
  PRIMARY KEY (`token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;
//created and inserted 12:08PM Monday November 12th 2018


//created and inserted 12:28PM Monday November 12th 2018
//created for third party user login/registration system
alter table users add column first_name varchar(100);
alter table users add column last_name varchar(100);
alter table users add column role varchar(100);
alter table users add column last_login varchar(100);
alter table users add column status varchar(100);
alter table users add column expiration int(20);
alter table users modify column password text not null;

//created and inserted 12:28PM Monday November 12th 2018




//created and inserted 3:40PM  Monday November 12th 2018
insert into manufacturers (manufacturer_id, manufacturer_name) values(null, '3M Filtrete'),(null, 'Butler Ventamatic'),(null, 'Federal'),(null, 'John Guest'),(null, 'Mitsubishi'),(null, 'Sunbeam'),(null, 'AC Leak Freeze'),(null, 'Carlisle'),(null, 'Fernco'),(null, 'Jomar'),(null, 'Monarch'),(null, 'Swift Green'),(null, 'Adams'),(null, 'Carrier'),(null, 'Fernox'),(null, 'Jones Stephens'),(null, 'Mueller'),(null, 'Systems Sensor'),(null, 'ADP'),(null, 'Carrier & Bryant'),(null, 'Fieldpiece'),(null, 'Kidde'),(null, 'Nucalgon'),(null, 'Taco'),(null, 'Aerosys'),(null, 'Celdek'),(null, 'Flanders'),(null, 'King Brothers'),(null, 'NuTone'),(null, 'Tapco'),(null, 'Airia'),(null, 'Cerro Flow'),(null, 'Flex L'),(null, 'Laing'),(null, 'Packard'),(null, 'Taymor'),(null, 'Airia'),(null, 'Certainteed'),(null, 'Flushmate'),(null, 'Lambro'),(null, 'Panasonic'),(null, 'Teks'),(null, 'Allanson'),(null, 'Champion'),(null, 'Forbes'),(null, 'Legend'),(null, 'PremAire'),(null, 'Testo'),(null, 'American Air Filter'),(null, 'Cliplight'),(null, 'Fresh-Aire'),(null, 'Lennox'),(null, 'Pro 1 IAQ'),(null, 'Tex Flex'),(null, 'American Granby'),(null, 'Coleman'),(null, 'Frigidaire'),(null, 'Lennox Healthy Climate'),(null, 'PSI'),(null, 'Thermo'),(null, 'Ameristar'),(null, 'Cozy'),(null, 'Future Tools'),(null, 'Lenox'),(null, 'Rectorseal'),(null, 'Totaline'),(null, 'Amtrol'),(null, 'CPS'),(null, 'GE'),(null, 'Leonard'),(null, 'Refrigeration Technologies'),(null, 'Trane'),(null, 'Apollo'),(null, 'Crane'),(null, 'Generac'),(null, 'LG'),(null, 'Reliable'),(null, 'Trion'),(null, 'Appion'),(null, 'Cuno'),(null, 'GeneralAire'),(null, 'Lightstar'),(null, 'Reliance'),(null, 'Trion Air Bear'),(null, 'Aprilaire'),(null, 'Coleman'),(null, 'General Wire'),(null, 'Little Giant'),(null, 'Rheem'),(null, 'UEI'),(null, 'Austin Air'),(null, 'Cutler Hammer'),(null, 'Glentronics'),(null, 'Louisville Tin & Stove'),(null, 'RHS'),(null, 'Ultracool'),(null, 'B&D'),(null, 'Danco'),(null, 'Goodman'),(null, 'LSP'),(null, 'RL Deppmann'),(null, 'Uponor'),(null, 'Bacharach'),(null, 'Dearborn'),(null, 'Grohe'),(null, 'Lysol'),(null, 'Roberts Gordon'),(null, 'Us Motors'),(null, 'Baron Wire'),(null, 'Deflecto'),(null, 'Grundfos'),(null, 'Malco'),(null, 'Robertshaw'),(null, 'Vaughn'),(null, 'Beacon Morris'),(null, 'DiversiTech'),(null, 'Handley'),(null, 'Mars'),(null, 'Schaul'),(null, 'Ward'),(null, 'Beckett'),(null, 'Dormont'),(null, 'Heat Controller'),(null, 'Masco'),(null, 'Selkirk'),(null, 'Watco'),(null, 'Bell & Gossett'),(null, 'Dreier & Mallar'),(null, 'HeatLink'),(null, 'Mastercool'),(null, 'Sensible'),(null, 'Waterline'),(null, 'Bionaire'),(null, 'Dundas Fafine'),(null, 'Hilmor'),(null, 'Matco'),(null, 'Shellback'),(null, 'Weil McLain'),(null, 'Bosch'),(null, 'Durodyne'),(null, 'Holdrite'),(null, 'Maytag'),(null, 'Siemens'),(null, 'Whirlpool'),(null, 'Boyertown'),(null, 'DXV'),(null, 'Holmes'),(null, 'McGuire'),(null, 'Skuttle'),(null, 'White Rodgers'),(null, 'B P Porter'),(null, 'East Ohio Gas'),(null, 'Honeywell'),(null, 'Merrill'),(null, 'S & P'),(null, 'Williamson'),(null, 'Braeburn'),(null, 'Ecobee'),(null, 'Hydra-Zorb'),(null, 'MetalBest'),(null, 'Spears'),(null, 'Worthington'),(null, 'Bramec'),(null, 'ECR'),(null, 'HydroLevel'),(null, 'Michigan Brass'),(null, 'Spectronics'),(null, 'Yellow Jacket'),(null, 'Brinmar'),(null, 'ESP'),(null, 'ICP'),(null, 'midwest'),(null, 'Square D'),(null, 'York'),(null, 'Broan'),(null, 'Essick Air'),(null, 'In-o-vate'),(null, 'Milioco'),(null, 'Stadler Form'),(null, 'Zonex'),(null, 'Bruco'),(null, 'EWC'),(null, 'Jackson Systems'),(null, 'Mill-Rose'),(null, 'Stanwade'),(null, 'Zurn'),(null, 'Bryant'),(null, 'Fantech'),(null, 'JB'),(null, 'Milwaukee'),(null, 'Sterling');
//created and inserted 3:40PM  Monday November 12th 2018



//LEFT Office at 3;45PM after this last insert statement


//created and inserted 8:00AM Tuesday November 13th 2018
alter table part_data add column category_id int(99);
alter table part_data add column manufacturer_id int(99);
alter table part_data add column serial_number varchar(200);
alter table part_data add column floorplan_demarcation varchar(200);
//created and inserted 8:00AM Tuesday November 13th 201\1




//created and inserted 6:38PM Tuesday November 13th 2018
CREATE TABLE `zipcodes` (
  `zipcode` varchar(10) DEFAULT NULL,
  `latitude` float(10,8) DEFAULT NULL,
  `longitude` float(10,8) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  `county` varchar(128) DEFAULT NULL,
  `geonamesId` bigint(22) NOT NULL,
  `iso` varchar(5) NOT NULL,
  `state_province_name` varchar(200) DEFAULT NULL,
  `country` varchar(200) DEFAULT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1909400 DEFAULT CHARSET=latin1;
//dumped and imported zopcodes table from another project
//created and inserted 6:38PM Tuesday November 13th 2018


//created and inserted 6:38PM Wednesday November 14th 2018
alter table users add column logo varchar(300);
alter table users add column avatar varchar(300);
alter table part_warranty add column serial_number varchar(200);
//6:51PM
 create table service_dates (id int(100), service_date datetime, location_id int(99), tech_id int(99), service_performed longtext,  primary key(id));
 alter table users add column company_name varchar(300);
 alter table part_data add column description longtext;
 alter table part_data add column part_name text;
create table part_photos (id int(99) not null auto_increment, path text, serial_number varchar(200), primary key(id));
alter table part_data add column creator_id int(99) not null;
alter table part_data add column pub_status int(1) not null;


//9PM
alter table part_data add column model_number varchar(300);
//created and inserted from 6:38PM - 9PM Tuesday November 13th 2018


//Qr Code Domain mysquaretracker.com hosted on Godaddy
//Need to add clients_dealer table also add column to tables for which product is being used
//Need to add list of columns that can be selected by user_levels table
