-- UTILISATEUR

insert into UTILISATEUR (pseudo,mdpHash,estAdmin) values ('Test1','abcdef',0);
insert into UTILISATEUR (pseudo,mdpHash,estAdmin) values ('Test2','idfhih',1);



-- CATEGORIE

insert into CATEGORIE values ('Informatique');
insert into CATEGORIE values ('Environnement');


-- DEBAT

insert into DEBAT (idUser,nomCateg,titre) values (1,1,'IA, un danger ?');
insert into DEBAT (idUser,nomCateg,titre) values (2,2,'Nucléaire ou pas ?');
