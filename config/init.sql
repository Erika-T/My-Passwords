create database MyPasswords;

grant all on MyPasswords.* to dbuser@localhost identified by '13dm090h';

use MyPasswords

create table users (
  id int not null auto_increment primary key,
  email varchar(255) unique,
  password varchar(255),
  created datetime,
  modified datetime
);

desc users;