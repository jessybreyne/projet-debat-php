
-- DROP

drop table SUIVRE;
drop table MESSAGE;
drop table DEBAT;
drop table CATEGORIE;
drop table UTILISATEUR;

-- TABLES

create table UTILISATEUR(
  idUser int primary key,
  pseudo varchar(15) unique,
  mdpHash varchar(50),
  estAdmin smallint -- 0 : non admin, 1 : est admin
);

create table CATEGORIE(
  nomCateg varchar(15) primary key
);

create table DEBAT(
  idDebat int primary key,
  idCreateur int,
  nomCateg varchar(15) UNIQUE,
  titre varchar(100) UNIQUE,
  constraint FKCreaDeb foreign key (idCreateur) references UTILISATEUR(idUser),
  constraint FKCategDeb foreign key (nomCateg) references CATEGORIE(nomCateg)
);

create table MESSAGE(
  idDebat int,
  numMess int,
  idAuteur int,
  contenu varchar(4000),
  datePub time,
  constraint FKAutMes foreign key (idAuteur) references UTILISATEUR(idUser),
  constraint FKDebMes foreign key (idDebat) references DEBAT(idDebat),
  constraint KeyMes primary key (idDebat,numMess)
);

create table SUIVRE(
  idDebat int,
  idUser int,
  constraint FKDebSuiv foreign key (idDebat) references DEBAT(idDebat),
  constraint FKUseSuiv foreign key (idUser) references UTILISATEUR(idUser),
  constraint FKSuivre primary key (idDebat,idUser)
);
