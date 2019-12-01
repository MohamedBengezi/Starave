create table clubs(ID int(10) unsigned not null primary key auto_increment, NAME varchar(25) not null unique, RATING int(11) not null, LATITUDE decimal(19,14), LONGITUDE decimal(15,10), DESCRIPTION varchar(140), IMAGE varchar(60));
create table reviews(CLUB_ID int(10) unsigned not null,ID int(10) unsigned not null primary key auto_increment, NAME varchar(25) not null, RATING int(11) not null, DESCRIPTION varchar(140));
create table user(ID int(10) unsigned not null primary key auto_increment, USERNAME varchar(25) not null unique, EMAIL varchar(60) not null unique, PASS varchar(255), AGE int(11), GENDER varchar(10));
