CREATE TABLE questions( 
      id  SERIAL    NOT NULL  , 
      question varchar  (200)   NOT NULL  , 
      descricao varchar  (300)   , 
      Ferramentas_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE report_items( 
      id  SERIAL    NOT NULL  , 
      questions_id integer   NOT NULL  , 
      reports_id integer   NOT NULL  , 
      resposta boolean   NOT NULL  , 
      descricao varchar  (200)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE reports( 
      id  SERIAL    NOT NULL  , 
      user_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group( 
      id integer   NOT NULL  , 
      name text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group_program( 
      id integer   NOT NULL  , 
      system_group_id integer   NOT NULL  , 
      system_program_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_preference( 
      id text   NOT NULL  , 
      preference text   NOT NULL  ) ; 

CREATE TABLE system_program( 
      id integer   NOT NULL  , 
      name text   NOT NULL  , 
      controller text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_unit( 
      id integer   NOT NULL  , 
      name text   NOT NULL  , 
      connection_name text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_group( 
      id integer   NOT NULL  , 
      system_user_id integer   NOT NULL  , 
      system_group_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_program( 
      id integer   NOT NULL  , 
      system_user_id integer   NOT NULL  , 
      system_program_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_users( 
      id integer   NOT NULL  , 
      name text   NOT NULL  , 
      login text   NOT NULL  , 
      password text   NOT NULL  , 
      email text   , 
      frontpage_id integer   , 
      system_unit_id integer   , 
      active char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_unit( 
      id integer   NOT NULL  , 
      system_user_id integer   NOT NULL  , 
      system_unit_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tools( 
      id  SERIAL    NOT NULL  , 
      nome varchar  (50)   NOT NULL  , 
      descricao varchar  (300)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

 
  
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

  
