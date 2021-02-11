drop table person cascade constraints;

drop table login_session cascade constraints;

create table person (
  id varchar2(10) primary key,
  user_name varchar2(10),
  password varchar2(10),
  first_name varchar2(30) not null, 
  last_name varchar2(30) not null, 
  is_student number(1),
  is_administrator number(1)
);

create table login_session (
  session_id varchar2(32) primary key,
  person_id varchar2(10),
  session_date date,
  foreign key (person_id) references person
);
 
insert into person values ('1', 'mscott', '123456', 'Michael', 'Scott', 1, 0);
insert into person values ('2', 'dschrute', '123456', 'Dwight', 'Schrute', 0, 1);
insert into person values ('3', 'jhalpert', '123456', 'Jim', 'Halpert', 1, 0);
insert into person values ('4', 'pbeesly', '123456', 'Pam', 'Beesly', 1, 0);
insert into person values ('5', 'rhoward', '123456', 'Ryan', 'Howard', 1, 1);
insert into person values ('6', 'shudson', '123456', 'Stanley', 'Hudson', 1, 0);
insert into person values ('7', 'kmalone', '123456', 'Kelvin', 'Malone', 0, 1);
insert into person values ('8', 'mpalmer', '123456', 'Meridith', 'Palmer', 1, 0);
insert into person values ('9', 'amartin', '123456', 'Angela', 'Martin', 1, 1);
insert into person values ('10', 'cbratton', '123456', 'Creed', 'Bratton', 1, 0);

commit;