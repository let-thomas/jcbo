CREATE or replace TABLE zavody_typ (
 id smallint NOT NULL AUTO_INCREMENT,
 nazev varchar(32) not null,
 column vaha decimal(4,2) not null,
 poradi smallint,
 PRIMARY KEY (id),
 UNIQUE KEY u_zt (nazev)
)  ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into zavody_typ(nazev) values
('MalaCena'), 
('VelkaCena'),
('KrajskyPrebor'),
('MVC'),
('MT'),
('MCR'),
('EXL'),
('EJU'),
('GP'),
('PK'),
('PČR'),
('ME'),
('KT'),
('MK'),
('MS'),
('DL'),
('EYO'),
('PSO');

insert into zavody_typ(nazev, vaha, poradi) values ('Turnaj Pripravek', 1, 1);

alter table zavody_typ add column vaha decimal(4,2);
update zavody_typ set vaha=1;
alter table zavody_typ add column poradi smallint;
update zavody_typ set poradi=1;

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
 CONSTRAINT fk_z_zt FOREIGN KEY (type_id) REFERENCES zavody_typ(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- pozvanka
-- rozpis  in pdf
-- treneri
-- kde/kdy sraz
