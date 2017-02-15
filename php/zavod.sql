CREATE or replace TABLE typ_zavodu (
 id smallint NOT NULL AUTO_INCREMENT,
 nazev varchar(32) not null,
 vaha decimal(4,2) not null default 1,
 comment varchar(100),
 typ smallint COMMENT '#1=mistrovsky, 2=nemistrovsky, 3=druzstva, 9=turnajpripravek',
 sortorder smallint default 9,
 PRIMARY KEY (id),
 UNIQUE KEY u_zt (nazev),
 check (typ in (1,2,3,9))
)  ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into typ_zavodu(nazev, comment, typ, sortorder) values
('Turnaj Pripravek', '', 9, 99),
('mistrovství sveta','',1,11),
('mistrovství evropy','',1,10),
('mistrovství ČR','',1,9),
('mistrovství kraje','???',1,8),
('EYOF', 'Evropský olympijský festival mládeže = ME?', 2,7),
('turnaj EJU','',2,6),
('Přebor PČR, kvalifikace PCR/MCR','',2,5),
('Mezinárodní turnaj (>3země)','',2,4),
('ostatní turnaje ČSJu','',2,3), 
('krajské a oblastní turnaje','přebor kraje, mezin/VC, přebor spojenych oblasti',2, 2),
('MalaCena, ostatní','',2, 1),
('Liga (EXL, 1L, ML, DL)','soutěž družstev',3,20);
#,('Extraliga','',3)
#,('Dorostenecka liga','',3)
#,('GrandPrix'), --?

#alter table typ_zavodu add check (typ in (1,2,3,9))

CREATE or replace TABLE zavod (
 id int NOT NULL AUTO_INCREMENT,
 nazev varchar(100) not null,
 kdy date not null,
 kde varchar(100) not null,
 type_id smallint not null,
 vedouci_id int,
 pozvanka varchar(1000),
 rozpis_url varchar(512),
 PRIMARY KEY (id),
 UNIQUE KEY uq_z (nazev, kdy),
 CONSTRAINT fk_z_j FOREIGN KEY (vedouci_id) REFERENCES judoka( id),
 CONSTRAINT fk_z_zt FOREIGN KEY (type_id) REFERENCES typ_zavodu(id) on update CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

alter table zavod DROP FOREIGN KEY fk_z_zt;
alter table zavod add CONSTRAINT fk_z_zt FOREIGN KEY (type_id) REFERENCES typ_zavodu(id) on update CASCADE;


CREATE or replace TABLE bodovani (
    id int NOT NULL AUTO_INCREMENT,
    typ_zavodu_id smallint NOT NULL,
    misto smallint NOT NULL default 0,
    bodu smallint NOT NULL default 0,
    PRIMARY KEY (id),
    UNIQUE KEY uq_b (typ_zavodu_id, misto),
    CONSTRAINT fk_zt_b FOREIGN KEY (typ_zavodu_id) REFERENCES typ_zavodu( id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


alter table zavod add column typ_id smallint not null default 0;
alter table zavod add CONSTRAINT fk_z_tz FOREIGN KEY (typ_id) REFERENCES typ_zavodu(id) on update CASCADE


--SELECT table.*,typ_zavodu.*  FROM `TABLE13`,typ_zavodu WHERE `TABLE13`.`COL 1`


-- pozvanka
-- rozpis  in pdf
-- treneri
-- kde/kdy sraz
