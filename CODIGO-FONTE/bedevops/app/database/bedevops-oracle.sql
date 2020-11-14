CREATE TABLE categoria( 
      id number(10)    NOT NULL , 
      categoria varchar  (20)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE ferramenta( 
      id number(10)    NOT NULL , 
      nome varchar  (50)    NOT NULL , 
      descricao varchar  (300)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE item_relatorio( 
      id number(10)    NOT NULL , 
      pergunta_id number(10)    NOT NULL , 
      resposta char(1)    NOT NULL , 
      comentario CLOB    NOT NULL , 
      relatorio_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pergunta( 
      id number(10)    NOT NULL , 
      pergunta varchar  (200)    NOT NULL , 
      descricao varchar  (300)   , 
      ferramenta_id number(10)    NOT NULL , 
      categoria_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE relatorio( 
      id number(10)    NOT NULL , 
      user_id number(10)   , 
      titulo varchar  (100)    NOT NULL , 
      descricao CLOB    NOT NULL , 
      criacao timestamp(0)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE resultado( 
      id number(10)    NOT NULL , 
      categoria_id number(10)    NOT NULL , 
      relatorio_id number(10)    NOT NULL , 
      valor binary_double    NOT NULL , 
 PRIMARY KEY (id)) ; 

 
 ALTER TABLE categoria ADD UNIQUE (categoria);
 ALTER TABLE ferramenta ADD UNIQUE (nome);
 ALTER TABLE pergunta ADD UNIQUE (pergunta);
 ALTER TABLE relatorio ADD UNIQUE (titulo);
  
 ALTER TABLE item_relatorio ADD CONSTRAINT fk_report_answer_item_1 FOREIGN KEY (pergunta_id) references pergunta(id); 
ALTER TABLE item_relatorio ADD CONSTRAINT fk_report_answer_item_2 FOREIGN KEY (relatorio_id) references relatorio(id); 
ALTER TABLE pergunta ADD CONSTRAINT fk_Questions_1 FOREIGN KEY (ferramenta_id) references ferramenta(id); 
ALTER TABLE pergunta ADD CONSTRAINT fk_perguntas_2 FOREIGN KEY (categoria_id) references categoria(id); 
ALTER TABLE resultado ADD CONSTRAINT fk_resultados_1 FOREIGN KEY (categoria_id) references categoria(id); 
ALTER TABLE resultado ADD CONSTRAINT fk_resultados_2 FOREIGN KEY (relatorio_id) references relatorio(id); 
 CREATE SEQUENCE categoria_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER categoria_id_seq_tr 

BEFORE INSERT ON categoria FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT categoria_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE ferramenta_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER ferramenta_id_seq_tr 

BEFORE INSERT ON ferramenta FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT ferramenta_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE item_relatorio_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER item_relatorio_id_seq_tr 

BEFORE INSERT ON item_relatorio FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT item_relatorio_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE pergunta_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER pergunta_id_seq_tr 

BEFORE INSERT ON pergunta FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT pergunta_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE relatorio_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER relatorio_id_seq_tr 

BEFORE INSERT ON relatorio FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT relatorio_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE resultado_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER resultado_id_seq_tr 

BEFORE INSERT ON resultado FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT resultado_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
 
  
