SET sql_mode = '';

DROP SCHEMA IF EXISTS trgovina;

CREATE SCHEMA IF NOT EXISTS trgovina; 

DROP TABLE IF EXISTS trgovina.vloge;
	
CREATE TABLE IF NOT EXISTS trgovina.vloge (
  idvloge VARCHAR(1),
  naziv VARCHAR(255) NOT NULL,
	status TINYINT NOT NULL DEFAULT 0,
  datspr timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'datum in ura zadnje spremembe  zapisa',
	idspr INT COMMENT 'id uporabnika, ki je naredil spremembo zapisa',
	 PRIMARY KEY (idvloge)
)  ENGINE=InnoDB  DEFAULT CHARSET=utf8;	

INSERT INTO `trgovina`.`vloge` (`idvloge`, `naziv`) VALUES ('A', 'Administrator');
INSERT INTO `trgovina`.`vloge` (`idvloge`, `naziv`) VALUES ('P', 'Prodajalec');
INSERT INTO `trgovina`.`vloge` (`idvloge`, `naziv`) VALUES ('S', 'Stranka');
INSERT INTO `trgovina`.`vloge` (`idvloge`, `naziv`) VALUES ('X', 'Anonimni odjemalec');

DROP TABLE IF EXISTS trgovina.uporabniki;

CREATE TABLE IF NOT EXISTS trgovina.uporabniki (
  iduporabnika INT AUTO_INCREMENT  COMMENT 'id uporabnika',
  idvloge VARCHAR(1) COMMENT 'id vloge (sifrant v tabeli vloge) administrator, prodajalec, stranka, anonimni odjemalec',
	idcert VARCHAR(50)   COMMENT 'id certifikata',
	email VARCHAR(254)   COMMENT 'email/uporabnisko ime',
	indmailpotrjen TINYINT COMMENT '0 - ne, 1 -da optimizacija, da vodimo stanje, da ni potrebno iskati po tabeli uporabniki_potrditve',
	geslo VARCHAR(255)   COMMENT 'geslo',
	sol VARCHAR(255)   COMMENT 'sol za geslo',
	piskotek VARCHAR(300)   COMMENT 'oznaka piskoteka/seje za anonimnega uporabnika ali uporabnika, ki se se ni prijavil',
	ime VARCHAR(50)   COMMENT 'ime',
	priimek VARCHAR(50)   COMMENT 'priimek',
	ulica VARCHAR(50)   COMMENT 'ulica in hisna stevilka',
	posta VARCHAR(20)   COMMENT 'stevilka oziroma oznaka poste',
	kraj VARCHAR(50)   COMMENT 'kraj',
	drzava VARCHAR(50)   COMMENT 'naziv države - sicer iddrzava in sifrant drzav',
	datprijave timestamp DEFAULT 0 COMMENT 'datum zadnje prijave uporabnika v aplikacijo',
	status TINYINT NOT NULL DEFAULT 0 COMMENT '0 - veljaven zapis, 9 - neveljaven zapis',
	datspr timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'datum in ura zadnje spremembe  zapisa',
	idspr INT COMMENT 'id uporabnika, ki je naredil spremembo zapisa',
	 PRIMARY KEY (iduporabnika)
)  ENGINE=InnoDB  DEFAULT CHARSET=utf8;	 

ALTER table trgovina.uporabniki
ADD FOREIGN KEY uporabniki_vloge_fk(idvloge)
REFERENCES trgovina.vloge(idvloge)
ON DELETE RESTRICT
ON UPDATE CASCADE; 

CREATE INDEX uporabniki_ix_idcert ON trgovina.uporabniki(idcert);

CREATE INDEX uporabniki_ix_email ON trgovina.uporabniki(email);

CREATE INDEX uporabniki_ix_piskotek ON trgovina.uporabniki(piskotek);

DROP TABLE IF EXISTS trgovina.uporabniki_arh;

CREATE TABLE IF NOT EXISTS trgovina.uporabniki_arh (
  arh_akcija VARCHAR(8),
  arh_revizija INT(6) NOT NULL AUTO_INCREMENT ,
  arh_datum DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  iduporabnika INT COMMENT 'id uporabnika',
  idvloge VARCHAR(1) COMMENT 'id vloge (sirant v tabeli vloge) administrator, prodajalec, stranka, anonimni odjemalec',
	idcert VARCHAR(50)   COMMENT 'id certifikata',
	email VARCHAR(254)   COMMENT 'email/uporabnisko ime',
	indmailpotrjen TINYINT COMMENT '0 - ne, 1 -da optimizacija, da vodimo stanje, da ni potrebno iskati po tabeli uporabniki_potrditve',
	geslo VARCHAR(255)   COMMENT 'geslo',
  sol VARCHAR(255)   COMMENT 'sol za geslo',
	piskotek VARCHAR(300)   COMMENT 'oznaka piskoteka/seje za anonimnega uporabnika ali uporabnika, ki se se ni prijavil',
	ime VARCHAR(50)   COMMENT 'ime',
	priimek VARCHAR(50)   COMMENT 'priimek',
	ulica VARCHAR(50)   COMMENT 'ulica in hisna stevilka',
	posta VARCHAR(20)   COMMENT 'stevilka oziroma oznaka poste',
	kraj VARCHAR(50)   COMMENT 'kraj',
	drzava VARCHAR(50)   COMMENT 'naziv države - sicer iddrzava in sifrant drzav',
	datprijave timestamp DEFAULT 0 COMMENT 'datum zadnje prijave uporabnika v aplikacijo',
	status TINYINT COMMENT '0 - veljaven zapis, 9 - neveljaven zapis',
	datspr timestamp COMMENT 'datum in ura zadnje spremembe  zapisa',
	idspr INT COMMENT 'id uporabnika, ki je naredil spremembo zapisa',
	 PRIMARY KEY (iduporabnika, arh_revizija)
)  ENGINE=MyISAM  DEFAULT CHARSET=utf8;	

ALTER table trgovina.uporabniki_arh
ADD FOREIGN KEY uporabniki_arh_fk(iduporabnika)
REFERENCES trgovina.uporabniki(iduporabnika)
ON DELETE RESTRICT
ON UPDATE CASCADE; 

DROP TRIGGER IF EXISTS trgovina.uporabniki__ai;
DROP TRIGGER IF EXISTS trgovina.uporabniki__au;
DROP TRIGGER IF EXISTS trgovina.uporabniki__bd;

CREATE TRIGGER trgovina.uporabniki__ai AFTER INSERT ON trgovina.uporabniki FOR EACH ROW
    INSERT INTO trgovina.uporabniki_arh SELECT 'insert', NULL, NOW(), d.* 
    FROM trgovina.uporabniki AS d WHERE d.iduporabnika = NEW.iduporabnika;

CREATE TRIGGER trgovina.uporabniki__au AFTER UPDATE ON trgovina.uporabniki FOR EACH ROW
    INSERT INTO trgovina.uporabniki_arh SELECT 'update', NULL, NOW(), d.*
    FROM trgovina.uporabniki AS d WHERE d.iduporabnika = NEW.iduporabnika;

CREATE TRIGGER trgovina.uporabniki__bd BEFORE DELETE ON trgovina.uporabniki FOR EACH ROW
    INSERT INTO trgovina.uporabniki_arh SELECT 'delete', NULL, NOW(), d.* 
    FROM trgovina.uporabniki AS d WHERE d.iduporabnika = OLD.iduporabnika;   
   
DROP TABLE IF EXISTS trgovina.uporabniki_potrditve;

CREATE TABLE IF NOT EXISTS trgovina.uporabniki_potrditve (
  idpotrditve INT AUTO_INCREMENT  COMMENT 'id uporabnika',
	iduporabnika INT COMMENT 'id uporabnika',
	datposiljanja timestamp DEFAULT 0 COMMENT 'datum posiljanja maila',
	datpotrditve timestamp DEFAULT 0 COMMENT 'datum potrditve uporabnika',
	status TINYINT NOT NULL DEFAULT 0 COMMENT '0 - veljaven zapis, 9 - neveljaven zapis',
	datspr timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'datum in ura zadnje spremembe  zapisa',
	idspr INT COMMENT 'id uporabnika, ki je naredil spremembo zapisa',
  PRIMARY KEY (idpotrditve)
)  ENGINE=InnoDB  DEFAULT CHARSET=utf8;	 

CREATE INDEX uporabniki_potrditve_ix_iduporabnika ON trgovina.uporabniki_potrditve(iduporabnika);

ALTER table trgovina.uporabniki_potrditve
ADD FOREIGN KEY uporabniki_potrditve_fk(iduporabnika)
REFERENCES trgovina.uporabniki(iduporabnika)
ON DELETE RESTRICT
ON UPDATE CASCADE; 

INSERT INTO `trgovina`.`uporabniki` (`idvloge`, `email`, `geslo`, `ime`, `priimek`, `ulica`, `posta`, `kraj`, `drzava`) VALUES ('A', 'robert@gmail.com', 'robert', 'Robert', 'Študent', 'Travniška 9', '1433', 'Radeče', 'Slovenija');
INSERT INTO `trgovina`.`uporabniki` (`idvloge`, `email`, `geslo`, `ime`, `priimek`, `ulica`, `posta`, `kraj`, `drzava`) VALUES ('P', 'uros@gmail.com', 'uros', 'Uros', 'Študent', 'Vilharjeva 23', '3000', 'Celje', 'Slovenija');
INSERT INTO `trgovina`.`uporabniki` (`idvloge`, `email`, `geslo`, `ime`, `priimek`, `ulica`, `posta`, `kraj`, `drzava`) VALUES ('S', 'stranka@gmail.com', 'stranka', 'Stranka', 'Resna', 'Pikasta 23', '1000', 'Ljubljana', 'Slovenija');
INSERT INTO `trgovina`.`uporabniki` (`idvloge`, `piskotek`, `ime`, `priimek`, `ulica`, `posta`, `kraj`, `drzava`) VALUES ('X', 'idpiskotka', 'Filip', 'Anonimni', 'Kriva 45', '4000', 'Kranj', 'Slovenija');

DROP TABLE IF EXISTS trgovina.artikli;

CREATE TABLE IF NOT EXISTS trgovina.artikli (
  idartikla INT AUTO_INCREMENT  COMMENT 'id artikla',
  naziv VARCHAR(100) COMMENT 'naziv ',
  opis VARCHAR(2000) COMMENT 'daljsi opis ',
  cena decimal(20,2) COMMENT 'cena v EUR',
	st_ocen INT DEFAULT 0 COMMENT 'stevilo oddanih ocen za artikel - optimizacija, da ni potrebno sproti sestevati po prometni tabeli',
	povprecna_ocena DECIMAL(5,2) DEFAULT 0 COMMENT 'povprečna ocena - optimizacija, da ni potrebno sproti racunati. Nova ocena=(povprecna_ocena*st_ocen+nova_ocena)/(st_ocen+1); st_ocen=st_ocen+1',
	status TINYINT NOT NULL DEFAULT 0 COMMENT '0 - veljaven zapis, 9 - neveljaven zapis',
	datspr timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'datum in ura zadnje spremembe  zapisa',
	idspr INT COMMENT 'id uporabnika, ki je naredil spremembo zapisa',
	 PRIMARY KEY (idartikla)
)  ENGINE=InnoDB  DEFAULT CHARSET=utf8;	

DROP TABLE IF EXISTS trgovina.artikli_arh;

CREATE TABLE IF NOT EXISTS trgovina.artikli_arh (
  arh_akcija VARCHAR(8),
  arh_revizija INT(6) NOT NULL AUTO_INCREMENT ,
  arh_datum DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	idartikla INT COMMENT 'id artikla',
  naziv VARCHAR(100) COMMENT 'naziv ',
  opis VARCHAR(2000) COMMENT 'daljsi opis ',
  cena decimal(20,2) COMMENT 'cena v EUR',
	st_ocen INT DEFAULT 0 COMMENT 'stevilo oddanih ocen za artikel - optimizacija, da ni potrebno sproti sestevati po prometni tabeli',
	povprecna_ocena DECIMAL(5,2)  COMMENT 'povprečna ocena - optimizacija, da ni potrebno sproti racunati. Nova ocena=(povprecna_ocena*st_ocen+nova_ocena)/(st_ocen+1); st_ocen=st_ocen+1',
	status TINYINT COMMENT '0 - veljaven zapis, 9 - neveljaven zapis',
	datspr timestamp DEFAULT 0 COMMENT 'datum in ura zadnje spremembe  zapisa',
	idspr INT COMMENT 'id uporabnika, ki je naredil spremembo zapisa',	
 PRIMARY KEY (idartikla, arh_revizija)
)  ENGINE=MyISAM  DEFAULT CHARSET=utf8;	

ALTER table trgovina.artikli_arh
ADD FOREIGN KEY artikli_arh_fk(idartikla)
REFERENCES trgovina.artikli(idartikla)
ON DELETE RESTRICT
ON UPDATE CASCADE; 

DROP TRIGGER IF EXISTS trgovina.artikli__ai;
DROP TRIGGER IF EXISTS trgovina.artikli__au;
DROP TRIGGER IF EXISTS trgovina.artikli__bd;

CREATE TRIGGER trgovina.artikli__ai AFTER INSERT ON trgovina.artikli FOR EACH ROW
    INSERT INTO trgovina.artikli_arh SELECT 'insert', NULL, NOW(), d.* 
    FROM trgovina.artikli AS d WHERE d.idartikla = NEW.idartikla;

CREATE TRIGGER trgovina.artikli__au AFTER UPDATE ON trgovina.artikli FOR EACH ROW
    INSERT INTO trgovina.artikli_arh SELECT 'update', NULL, NOW(), d.*
     FROM trgovina.artikli AS d WHERE d.idartikla = NEW.idartikla;

CREATE TRIGGER trgovina.artikli__bd BEFORE DELETE ON trgovina.artikli FOR EACH ROW
    INSERT INTO trgovina.artikli_arh SELECT 'delete', NULL, NOW(), d.* 
    FROM trgovina.artikli AS d WHERE d.idartikla = OLD.idartikla;  	

DROP TABLE IF EXISTS trgovina.artikli_slike;

CREATE TABLE IF NOT EXISTS trgovina.artikli_slike (
  idslike INT AUTO_INCREMENT  COMMENT 'id slike',
	idartikla INT COMMENT 'id artikla ( za artikel lahko imamo več slik)',
  naziv VARCHAR(100) COMMENT 'naziv',
  link VARCHAR(500) COMMENT 'http link do slike',
	status TINYINT NOT NULL DEFAULT 0 COMMENT '0 - veljaven zapis, 9 - neveljaven zapis',
	datspr timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'datum in ura zadnje spremembe  zapisa',
	idspr INT COMMENT 'id uporabnika, ki je naredil spremembo zapisa',
	 PRIMARY KEY (idslike)
)  ENGINE=InnoDB  DEFAULT CHARSET=utf8;	

ALTER table trgovina.artikli_slike
ADD FOREIGN KEY artikli_slike_fk(idartikla)
REFERENCES trgovina.artikli(idartikla)
ON DELETE RESTRICT
ON UPDATE CASCADE; 

CREATE INDEX artikli_slike_ix_idslike ON trgovina.artikli_slike(idslike);

DROP TABLE IF EXISTS trgovina.narocila_faza;

CREATE TABLE IF NOT EXISTS trgovina.narocila_faza (
  faza VARCHAR(1)  COMMENT 'faza',
	naziv VARCHAR(100) COMMENT 'naziv',
	status TINYINT NOT NULL DEFAULT 0 COMMENT '0 - veljaven zapis, 9 - neveljaven zapis',
	datspr timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'datum in ura zadnje spremembe  zapisa',
	idspr INT COMMENT 'id uporabnika, ki je naredil spremembo zapisa',
  PRIMARY KEY (faza)
)  ENGINE=InnoDB  DEFAULT CHARSET=utf8;	

INSERT INTO `trgovina`.`narocila_faza` (`faza`, `naziv`) VALUES ('K', 'Košarica0');
INSERT INTO `trgovina`.`narocila_faza` (`faza`, `naziv`) VALUES ('N', 'Naročilo');
INSERT INTO `trgovina`.`narocila_faza` (`faza`, `naziv`) VALUES ('P', 'Poslano naročilo');
INSERT INTO `trgovina`.`narocila_faza` (`faza`, `naziv`) VALUES ('S', 'Stornirano naročilo');

DROP TABLE IF EXISTS trgovina.narocila;

CREATE TABLE IF NOT EXISTS trgovina.narocila (
  idnarocila INT AUTO_INCREMENT  COMMENT 'id narocila',
	iduporabnika INT COMMENT 'id uporabnika',
	datzac_kosarice timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'datum in ura začetka kosarice,',
	datnarocila timestamp COMMENT 'datum in ura oddaje narocila s strani uporabnika',
	datposiljanja timestamp COMMENT 'datum in ura posiljanja narocila',
	faza VARCHAR(1)  COMMENT 'K - kosarica, N - narocilo, P - poslano narocilo, S - stornirano narocilo',
	status TINYINT NOT NULL DEFAULT 0 COMMENT '0 - veljaven zapis, 9 - neveljaven zapis',
	datspr timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'datum in ura zadnje spremembe  zapisa',
	idspr INT COMMENT 'id uporabnika, ki je naredil spremembo zapisa',
  PRIMARY KEY (idnarocila)
)  ENGINE=InnoDB  DEFAULT CHARSET=utf8;	

ALTER table trgovina.narocila
ADD FOREIGN KEY narocila_fk(iduporabnika)
REFERENCES trgovina.uporabniki(iduporabnika)
ON DELETE RESTRICT
ON UPDATE CASCADE; 

ALTER table trgovina.narocila
ADD FOREIGN KEY narocila_faza_fk(faza)
REFERENCES trgovina.narocila_faza(faza)
ON DELETE RESTRICT
ON UPDATE CASCADE; 

CREATE INDEX narocila_ix_iduporabnika ON trgovina.narocila(iduporabnika, datzac_kosarice);

DROP TABLE IF EXISTS trgovina.narocila_arh;

CREATE TABLE IF NOT EXISTS trgovina.narocila_arh (
  arh_akcija VARCHAR(8),
  arh_revizija INT(6) NOT NULL AUTO_INCREMENT ,
  arh_datum DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  idnarocila INT COMMENT 'id narocila',
	iduporabnika INT COMMENT 'id uporabnika',
	datzac_kosarice timestamp COMMENT 'datum in ura začetka kosarice,',
	datnarocila timestamp COMMENT 'datum in ura oddaje narocila s strani uporabnika',
	datposiljanja timestamp COMMENT 'datum in ura posiljanja narocila',
	faza VARCHAR(1)  COMMENT 'K - kosarica, N - narocilo, P - poslano narocilo, S - stornirano narocilo',
	status TINYINT COMMENT '0 - veljaven zapis, 9 - neveljaven zapis',
	datspr timestamp COMMENT 'datum in ura zadnje spremembe  zapisa',
	idspr INT COMMENT 'id uporabnika, ki je naredil spremembo zapisa',
  PRIMARY KEY (idnarocila, arh_revizija)
)  ENGINE=MyISAM  DEFAULT CHARSET=utf8;		

ALTER table trgovina.narocila_arh
ADD FOREIGN KEY narocila_arh_fk(idnarocila)
REFERENCES trgovina.narocila(idnarocila)
ON DELETE RESTRICT
ON UPDATE CASCADE; 

CREATE INDEX narocila_arh_idnarocila ON trgovina.narocila(idnarocila);

DROP TRIGGER IF EXISTS trgovina.narocila__ai;
DROP TRIGGER IF EXISTS trgovina.narocila__au;
DROP TRIGGER IF EXISTS trgovina.narocila__bd;

CREATE TRIGGER trgovina.narocila__ai AFTER INSERT ON trgovina.narocila FOR EACH ROW
    INSERT INTO trgovina.narocila_arh SELECT 'insert', NULL, NOW(), d.* 
    FROM trgovina.narocila AS d WHERE d.idnarocila = NEW.idnarocila;

CREATE TRIGGER trgovina.narocila__au AFTER UPDATE ON trgovina.narocila FOR EACH ROW
    INSERT INTO trgovina.narocila_arh SELECT 'update', NULL, NOW(), d.*
     FROM trgovina.narocila AS d WHERE d.idnarocila = NEW.idnarocila;

CREATE TRIGGER trgovina.narocila__bd BEFORE DELETE ON trgovina.narocila FOR EACH ROW
    INSERT INTO trgovina.narocila_arh SELECT 'delete', NULL, NOW(), d.* 
    FROM trgovina.narocila AS d WHERE d.idnarocila = OLD.idnarocila;  	

DROP TABLE IF EXISTS trgovina.narocila_artikli;

CREATE TABLE IF NOT EXISTS trgovina.narocila_artikli (
  idnarocila_artikli INT AUTO_INCREMENT  COMMENT 'id ',
	idnarocila INT COMMENT 'id narocila',
	idartikla INT COMMENT 'id artikla',
	kolicina INT COMMENT 'kolicina artiklov',
	status TINYINT NOT NULL DEFAULT 0 COMMENT '0 - veljaven zapis, 9 - neveljaven zapis',
	datspr timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'datum in ura zadnje spremembe  zapisa',
	idspr INT COMMENT 'id uporabnika, ki je naredil spremembo zapisa',
  PRIMARY KEY (idnarocila_artikli)
)  ENGINE=InnoDB  DEFAULT CHARSET=utf8;	

ALTER table trgovina.narocila_artikli
ADD FOREIGN KEY narocila_artikli_nar_fk(idnarocila)
REFERENCES trgovina.narocila(idnarocila)
ON DELETE RESTRICT
ON UPDATE CASCADE; 

ALTER table trgovina.narocila_artikli
ADD FOREIGN KEY narocila_artikli__art_fk(idartikla)
REFERENCES trgovina.artikli(idartikla)
ON DELETE RESTRICT
ON UPDATE CASCADE; 

CREATE INDEX narocila_artikli_idnarocila ON trgovina.narocila_artikli(idnarocila);

CREATE INDEX narocila_artikli_idartikla ON trgovina.narocila_artikli(idartikla);


DROP TABLE IF EXISTS trgovina.artikli_ocene;

CREATE TABLE IF NOT EXISTS trgovina.artikli_ocene (
  idocene  INT AUTO_INCREMENT  COMMENT 'id ocene',
  idartikla INT COMMENT 'id artikla',
	iduporabnika INT COMMENT 'id uporabnika',
	ocena DECIMAL(5,2) DEFAULT 0 COMMENT 'povprečna ocena - optimizacija, da ni potrebno sproti racunati. Nova ocena=(povprecna_ocena*st_ocen+nova_ocena)/(st_ocen+1); st_ocen=st_ocen+1',
	status TINYINT NOT NULL DEFAULT 0 COMMENT '0 - veljaven zapis, 9 - neveljaven zapis',
	datspr timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'datum in ura zadnje spremembe  zapisa',
	idspr INT COMMENT 'id uporabnika, ki je naredil spremembo zapisa',
	 PRIMARY KEY (idocene)
)  ENGINE=InnoDB  DEFAULT CHARSET=utf8;	



