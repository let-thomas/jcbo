CREATE or replace TABLE vysledky (
  id int NOT NULL AUTO_INCREMENT,
  zavodnik_id int not null,
  zavod_id int not null,
  kategorie_id smallint NOT NULL,
  vyhry smallint not null default 0,
  remizy smallint not null default 0,
  prohry smallint not null default 0,
  misto smallint,
  vaha smallint not null default 0,
  bodu smallint not null default 0,
  komentar varchar(2048),
  changed date not null,
  changedby varchar(32) not null,
 PRIMARY KEY (id),
 UNIQUE KEY u_vt (zavodnik_id, zavod_id, kategorie_id),
 CONSTRAINT fk_v_j FOREIGN KEY (zavodnik_id) REFERENCES clen( id),
 CONSTRAINT fk_v_z FOREIGN KEY (zavod_id) REFERENCES zavod( id),
 CONSTRAINT fk_v_k FOREIGN KEY (kategorie_id) REFERENCES kategorie( id)
)  ENGINE=InnoDB DEFAULT CHARSET=utf8;


#drop trigger bi_vysledky;
#drop trigger bu_vysledky;
delimiter //
CREATE TRIGGER bi_vysledky BEFORE INSERT ON vysledky
FOR EACH ROW 
BEGIN
  DECLARE bdy int;
  SELECT (new.vyhry*typ_zavodu.vaha+coalesce(bodovani.bodu,bodovani.bodu,0)) into bdy  
    from zavod  
    left join typ_zavodu on (zavod.typ_id = typ_zavodu.id)
    left join bodovani on (typ_zavodu.id = bodovani.typ_zavodu_id and bodovani.misto = new.misto )
    where (new.zavod_id=zavod.id);
  set new.changed = now();
  set new.bodu = bdy;
END; //
CREATE TRIGGER bu_vysledky BEFORE UPDATE ON vysledky
FOR EACH ROW
BEGIN
  DECLARE bdy int;
  SELECT (new.vyhry*typ_zavodu.vaha+coalesce(bodovani.bodu,bodovani.bodu,0)) into bdy  
    from zavod  
    left join typ_zavodu on (zavod.typ_id = typ_zavodu.id)
    left join bodovani on (typ_zavodu.id = bodovani.typ_zavodu_id and bodovani.misto = new.misto )
    where (new.zavod_id=zavod.id);
  set new.changed = now();
  set new.bodu = bdy;
END; //

delimiter ;


ALTER TABLE `jcbo`.`vysledky` CHANGE COLUMN `vaha` `vaha` VARCHAR(4) NOT NULL DEFAULT '0' ;