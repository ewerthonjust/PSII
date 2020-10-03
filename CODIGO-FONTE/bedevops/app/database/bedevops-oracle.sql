CREATE TABLE categorias( 
      id number(10)    NOT NULL , 
      categoria varchar  (20)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE ferramentas( 
      id number(10)    NOT NULL , 
      nome varchar  (50)    NOT NULL , 
      descricao varchar  (300)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE itens_relatorio( 
      id number(10)    NOT NULL , 
      pergunta_id number(10)    NOT NULL , 
      resposta char(1)    NOT NULL , 
      comentarios varchar  (200)   , 
      relatorio_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE perguntas( 
      id number(10)    NOT NULL , 
      pergunta varchar  (200)    NOT NULL , 
      descricao varchar  (300)   , 
      ferramenta_id number(10)    NOT NULL , 
      categorias_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE relatorios( 
      id number(10)    NOT NULL , 
      user_id number(10)    NOT NULL , 
      descricao varchar  (200)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group( 
      id number(10)    NOT NULL , 
      name CLOB    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group_program( 
      id number(10)    NOT NULL , 
      system_group_id number(10)    NOT NULL , 
      system_program_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_preference( 
      id varchar  (255)    NOT NULL , 
      preference CLOB    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_program( 
      id number(10)    NOT NULL , 
      name CLOB    NOT NULL , 
      controller CLOB    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_unit( 
      id number(10)    NOT NULL , 
      name CLOB    NOT NULL , 
      connection_name CLOB   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_group( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
      system_group_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_program( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
      system_program_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_users( 
      id number(10)    NOT NULL , 
      name CLOB    NOT NULL , 
      login CLOB    NOT NULL , 
      password CLOB    NOT NULL , 
      phone CLOB   , 
      email CLOB   , 
      frontpage_id number(10)   , 
      system_unit_id number(10)   , 
      active char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_unit( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
      system_unit_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

 
 ALTER TABLE categorias ADD UNIQUE (categoria);
 ALTER TABLE ferramentas ADD UNIQUE (nome);
 ALTER TABLE perguntas ADD UNIQUE (pergunta);
  
 ALTER TABLE itens_relatorio ADD CONSTRAINT fk_report_answer_item_1 FOREIGN KEY (pergunta_id) references perguntas(id); 
ALTER TABLE itens_relatorio ADD CONSTRAINT fk_report_answer_item_2 FOREIGN KEY (relatorio_id) references relatorios(id); 
ALTER TABLE perguntas ADD CONSTRAINT fk_Questions_1 FOREIGN KEY (ferramenta_id) references ferramentas(id); 
ALTER TABLE perguntas ADD CONSTRAINT fk_perguntas_2 FOREIGN KEY (categorias_id) references categorias(id); 
ALTER TABLE relatorios ADD CONSTRAINT fk_reports_1 FOREIGN KEY (user_id) references system_users(id); 
ALTER TABLE system_group_program ADD CONSTRAINT fk_system_group_program_1 FOREIGN KEY (system_program_id) references system_program(id); 
ALTER TABLE system_group_program ADD CONSTRAINT fk_system_group_program_2 FOREIGN KEY (system_group_id) references system_group(id); 
ALTER TABLE system_user_group ADD CONSTRAINT fk_system_user_group_1 FOREIGN KEY (system_group_id) references system_group(id); 
ALTER TABLE system_user_group ADD CONSTRAINT fk_system_user_group_2 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_user_program ADD CONSTRAINT fk_system_user_program_1 FOREIGN KEY (system_program_id) references system_program(id); 
ALTER TABLE system_user_program ADD CONSTRAINT fk_system_user_program_2 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_users ADD CONSTRAINT fk_system_user_2 FOREIGN KEY (frontpage_id) references system_program(id); 
ALTER TABLE system_users ADD CONSTRAINT fk_system_user_1 FOREIGN KEY (system_unit_id) references system_unit(id); 
ALTER TABLE system_user_unit ADD CONSTRAINT fk_system_user_unit_1 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_user_unit ADD CONSTRAINT fk_system_user_unit_2 FOREIGN KEY (system_unit_id) references system_unit(id); 
 CREATE SEQUENCE categorias_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER categorias_id_seq_tr 

BEFORE INSERT ON categorias FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT categorias_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE ferramentas_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER ferramentas_id_seq_tr 

BEFORE INSERT ON ferramentas FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT ferramentas_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE itens_relatorio_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER itens_relatorio_id_seq_tr 

BEFORE INSERT ON itens_relatorio FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT itens_relatorio_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE perguntas_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER perguntas_id_seq_tr 

BEFORE INSERT ON perguntas FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT perguntas_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE relatorios_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER relatorios_id_seq_tr 

BEFORE INSERT ON relatorios FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT relatorios_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
 
  
