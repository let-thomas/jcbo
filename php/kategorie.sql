CREATE or replace TABLE kategorie (
 id smallint NOT NULL AUTO_INCREMENT,
 nazev varchar(32) not null,
 rod smallint not null,
 rdo smallint not null,
 PRIMARY KEY (id),
 UNIQUE KEY u_kat (nazev)
)  ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into kategorie(nazev, rod, rdo) values
('mláďata U11', 0, 10), 
('mladší žáci U13', 11, 12),
('mladší žačky U13', 11, 12),
('starší žáci U15', 13, 14),
('starší žačky U15', 13, 14),
('dorci U18', 15, 17),
('dorky U18', 15, 17),
('junioři U23', 18, 22),
('juniorky U23', 18, 22),
('muži', 18, 99),
('ženy', 18, 99),
('veteráni', 30, 99)
;

CREATE or replace TABLE zavod_kateg (
 zavod_id int not null,
 kateg_id smallint not null,
 UNIQUE KEY u_zkat (zavod_id,kateg_id),
 CONSTRAINT fk_zk_z FOREIGN KEY (zavod_id) REFERENCES zavod( id),
 CONSTRAINT fk_zk_k FOREIGN KEY (kateg_id) REFERENCES kategorie( id)
)  ENGINE=InnoDB DEFAULT CHARSET=utf8;

alter table kategorie add column rod smallint not null,
alter table kategorie add column rdo smallint not null,
