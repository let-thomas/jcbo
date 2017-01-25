CREATE or replace TABLE kategorie (
 id smallint NOT NULL AUTO_INCREMENT,
 nazev varchar(32) not null,
 PRIMARY KEY (id),
 UNIQUE KEY u_kat (nazev)
)  ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into kategorie(nazev) values
('mláďata U11'), 
('mladší žáci U13'),
('mladší žačky U13'),
('starší žáci U15'),
('starší žačky U15'),
('dorci U18'),
('dorky U18'),
('junioři U23'),
('juniorky U23'),
('muži'),
('ženy'),
('veteráni')
;

CREATE or replace TABLE zavod_kateg (
 zavod_id int not null,
 kateg_id smallint not null,
 UNIQUE KEY u_zkat (zavod_id,kateg_id)
 CONSTRAINT fk_zk_z FOREIGN KEY (zavod_id) REFERENCES zavod( id),
 CONSTRAINT fk_zk_k FOREIGN KEY (kateg_id) REFERENCES kategorie( id),
)  ENGINE=InnoDB DEFAULT CHARSET=utf8;

