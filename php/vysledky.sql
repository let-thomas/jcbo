CREATE or replace TABLE vysledky (
 zavodnik_id int not null,
 zavod_id int not null,
 kategorie_id smallint NOT NULL,
 win smallint not null default 0,
 lose smallint not null default 0,
 misto smallint,
 komentar varchar(2048),
 changed date not null,
 changedby varchar(32) not null,
 UNIQUE KEY u_vt (zavodnik_id, zavod_id, kategorie_id),
 CONSTRAINT fk_v_j FOREIGN KEY (zavodnik_id) REFERENCES judoka( id),
 CONSTRAINT fk_v_z FOREIGN KEY (zavod_id) REFERENCES zavod( id),
 CONSTRAINT fk_v_k FOREIGN KEY (kategorie_id) REFERENCES kategorie( id)
)  ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TRIGGER bi_vysledky BEFORE INSERT ON vysledky
FOR EACH ROW 
set new.changed = now();
