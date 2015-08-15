create table users
(
  -- TODO: auto_increment id might not be a good idea
  id int not null auto_increment,
  email varchar(50) not null,
  first_name varchar(20) null,
  last_name varchar(20) not null,
  age int not null,
  created datetime not null,
  updated datetime null,

  constraint PK_users primary key (id)
);
