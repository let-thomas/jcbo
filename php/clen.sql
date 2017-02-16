# mysqldump -u jcbo -p jcbo clen > clen_tfr.sql

CREATE TABLE IF NOT EXISTS clen (
  id int NOT NULL AUTO_INCREMENT,
  ev_cislo int NOT NULL,
  jmeno varchar(32) NOT NULL,
  prijmeni varchar(32) NOT NULL,
  narozen date DEFAULT NULL,
  status smallint not null DEFAULT 9,
  trener_id int not null,
  stredisko varchar(20),
  csju_id int(11) DEFAULT NULL,
  csju_status char(1) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=696 DEFAULT CHARSET=utf8;

alter table clen add column zena smallint default 0;

delete from clen;

insert into clen (id, ev_cislo, jmeno, prijmeni, narozen, status, trener_id, stredisko) 
select id, ed_cislo, jmeno, prijmeni, narozen, status, trener_id, stredisko from seznam;

CREATE TABLE IF NOT EXISTS status (
    id smallint NOT NULL,
    popis varchar(50) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=696 DEFAULT CHARSET=utf8;

alter table clen add CONSTRAINT fk_cs FOREIGN KEY (status) REFERENCES status( id);
alter table clen add CONSTRAINT fk_c_c FOREIGN KEY (trener_id) REFERENCES clen(id);
