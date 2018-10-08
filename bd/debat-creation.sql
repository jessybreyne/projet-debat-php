
-- DROP

drop table SUIVRE;
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
  nomCateg VarChar2(15) primary key
);

create table DEBAT(
  idDebat NUMBER GENERATED ALWAYS AS IDENTITY primary key,
  idCreateur number,
  nomCateg VarChar2(15) UNIQUE,
  titre Varchar2(100) UNIQUE,
  foreign key (idCreateur) references UTILISATEUR(idUser),
  foreign key (nomCateg) references CATEGORIE(nomCateg)
);

create table MESSAGE(
  idDebat number,
  numMess number,
  idAuteur number,
  contenu VarChar2(4000),
  datePub date,
  foreign key (idAuteur) references UTILISATEUR(idUser),
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
