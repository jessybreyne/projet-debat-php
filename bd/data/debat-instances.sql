-- UTILISATEUR

insert into UTILISATEUR values (1,"admin","f4f263e439cf40925e6a412387a9472a6773c2580212a4fb50d224d3a817de17",1);

-- CATEGORIE

insert into CATEGORIE values ('Informatique');
insert into CATEGORIE values ('Environnement');
insert into CATEGORIE values ('Economie');
insert into CATEGORIE values ('Société');
insert into CATEGORIE values ('Politique');
insert into CATEGORIE values ('Religion');

-- DEBAT

insert into DEBAT values (1,1,"Informatique","L'IA, un danger pour l'Homme ?");
insert into DEBAT values (2,1,"Informatique","Les cookies, inoffensifs ou danger pour la vie privée ?");

-- MESSAGE

insert into MESSAGE values (1,1,1,"Je pense que NON !",strftime('%d/%m/%Y %H:%M:%S','now','localtime'));
insert into MESSAGE values (1,2,1,"En fait, SI !",strftime('%d/%m/%Y %H:%M:%S','now','localtime'));
