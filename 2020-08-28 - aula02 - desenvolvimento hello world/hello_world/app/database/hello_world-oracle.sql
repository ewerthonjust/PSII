CREATE TABLE tbl_cidade( 
      id number(10)    NOT NULL , 
      nome varchar  (50)    NOT NULL , 
      estado number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tbl_estado( 
      id number(10)    NOT NULL , 
      nome number(10)  (50)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tbl_usuario( 
      id number(10)    NOT NULL , 
      nome varchar  (50)    NOT NULL , 
      sobrenome varchar  (20)    NOT NULL , 
      empresa varchar  (50)    NOT NULL , 
      cidade number(10)    NOT NULL , 
      telefone varchar  (20)   , 
      email varchar  (100)   , 
 PRIMARY KEY (id)) ; 

 
  
 ALTER TABLE tbl_cidade ADD CONSTRAINT fk_tbl_cidade_1 FOREIGN KEY (estado) references tbl_estado(id); 
ALTER TABLE tbl_usuario ADD CONSTRAINT fk_tbl_usuario_1 FOREIGN KEY (cidade) references tbl_cidade(id); 
 CREATE SEQUENCE tbl_cidade_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tbl_cidade_id_seq_tr 

BEFORE INSERT ON tbl_cidade FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT tbl_cidade_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tbl_estado_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tbl_estado_id_seq_tr 

BEFORE INSERT ON tbl_estado FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT tbl_estado_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tbl_usuario_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tbl_usuario_id_seq_tr 

BEFORE INSERT ON tbl_usuario FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT tbl_usuario_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
 
  
