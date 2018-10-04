
-- DROP

drop table MESSAGE;
drop table DEBAT;
drop table CATEGORIE;
drop table UTILISATEUR;

-- TABLES

create table UTILISATEUR(
  idUser NUMBER GENERATED ALWAYS AS IDENTITY primary key,
  pseudo VarChar2(15) unique,
  mdpHash VarChar2(50),
  estAdmin smallint -- 0 : non admin, 1 : est admin
);

create table CATEGORIE(
  nomCateg VarChar2(15) UNIQUE
);

create table DEBAT(
  idDebat NUMBER GENERATED ALWAYS AS IDENTITY primary key,
  idUser number,
  nomCateg VarChar2(15) UNIQUE,
  titre Varchar2(100),
  foreign key (idUser) references UTILISATEUR(idUser),
  foreign key (nomCateg) references CATEGORIE(nomCateg)
);

create table MESSAGE(
  idDebat number,
  numMess number,
  idUser number,
  contenu VarChar2(4000),
  foreign key (idUser) references UTILISATEUR(idUser),
  foreign key (idDebat) references DEBAT(idDebat),
  primary key (idDebat,numMess)
);

create table SUIVRE(
  idDebat number,
  idUser number,
  foreign key (idDebat) references DEBAT(idDebat),
  foreign key (idUser) references UTILISATEUR(idUser),
  primary key (idDebat,idUser)
);
