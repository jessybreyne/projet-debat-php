
-- DROP

drop table MESSAGE;
drop table DEBAT;
drop table CATEGORIE;
drop table UTILISATEUR;

-- TABLES

create table UTILISATEUR(
  idUser number(3) auto_increment not null,
  pseudo VarChar2(15),
  mdpHash VarChar2(50),
  estAdmin boolean,
  constraint Kuser primary key (idUser)
);

create table CATEGORIE(
  idCateg number(3) auto_increment primary key,
  nomCateg VarChar2(15)
);

create table DEBAT(
  idDebat number(4) auto_increment primary key,
  idCreateur number(4),
  idCateg number(3),
  titre Varchar(100)
  constraint FKuser foreign key idCreateur references UTILISATEUR(idUser),
  constraint FKcateg foreign key idCateg references CATEGORIE(idCateg)
);

create table MESSAGE(
  idDebat number(4),
  numMess number(4),
  idAuteur number(4),
  contenu VarChar2(5000),
  constraint FKuser foreign key idAuteur references UTILISATEUR(idUser),
  constraint FKdebat foreign key idDebat references DEBAT(idDebat),
  constraint Kmessage primary key (idDebat,numMess)
);
