create table ldb_persons (person_id integer not null auto_increment unique, name varchar(100) not null character set utf8, graduation varchar(20) character set utf8);
create table ldb_groups (group_id integer not null auto_increment unique, year varchar(20) character set utf8 not null, name varchar(100) character set utf8 not null);
create table ldb_attendances (person_id integer, group_id integer, image varchar(200), image_small varchar(200), index person_ind (person_id), index group_ind (group_id), foreign key (person_id) references ldb_persons(person_id), foreign key (group_id) references ldb_groups(group_id));

insert into ldb_persons (name) values ('Портянкин'), ('Буренёв'), ('Семёнов');
insert into ldb_groups (year, name) values ('2012', '11 класс'), ('2013', '11 класс');
insert into ldb_attendances (person_id, group_id) values (1,2), (2,2), (3,2), (4,1), (5,1);

select name from ldb_persons where person_id in (select person_id from ldb_attendances where group_id in (select group_id from ldb_groups where year='2012'));
