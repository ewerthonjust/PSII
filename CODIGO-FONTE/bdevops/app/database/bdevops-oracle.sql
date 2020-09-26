CREATE TABLE questions( 
      id number(10)    NOT NULL , 
      question varchar  (200)    NOT NULL , 
      descricao varchar  (300)   , 
      Ferramentas_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE report_items( 
      id number(10)    NOT NULL , 
      questions_id number(10)    NOT NULL , 
      reports_id number(10)    NOT NULL , 
      resposta char(1)    NOT NULL , 
      descricao varchar  (200)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE reports( 
      id number(10)    NOT NULL , 
      user_id number(10)    NOT NULL , 
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
      id CLOB    NOT NULL , 
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
      email CLOB   , 
      frontpage_id number(10)   , 
      system_unit_id number(10)   , 
      active char  (1)   , 
      Phone varchar  (15)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_unit( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
      system_unit_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tools( 
      id number(10)    NOT NULL , 
      nome varchar  (50)    NOT NULL , 
      descricao varchar  (300)    NOT NULL , 
 PRIMARY KEY (id)) ; 

 
 ALTER TABLE questions ADD UNIQUE (question);
 ALTER TABLE tools ADD UNIQUE (nome);
  
 ALTER TABLE questions ADD CONSTRAINT fk_Questions_1 FOREIGN KEY (Ferramentas_id) references tools(id); 
ALTER TABLE report_items ADD CONSTRAINT fk_report_answer_item_1 FOREIGN KEY (questions_id) references questions(id); 
ALTER TABLE report_items ADD CONSTRAINT fk_report_answer_item_2 FOREIGN KEY (reports_id) references reports(id); 
ALTER TABLE reports ADD CONSTRAINT fk_reports_1 FOREIGN KEY (user_id) references system_users(id); 
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
 CREATE SEQUENCE questions_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER questions_id_seq_tr 

BEFORE INSERT ON questions FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT questions_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE report_items_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER report_items_id_seq_tr 

BEFORE INSERT ON report_items FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT report_items_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE reports_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER reports_id_seq_tr 

BEFORE INSERT ON reports FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT reports_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tools_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tools_id_seq_tr 

BEFORE INSERT ON tools FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT tools_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
 
  
