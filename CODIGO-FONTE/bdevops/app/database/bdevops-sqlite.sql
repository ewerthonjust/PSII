PRAGMA foreign_keys=OFF; 

CREATE TABLE questions( 
      id  INTEGER    NOT NULL  , 
      question varchar  (200)   NOT NULL  , 
      descricao varchar  (300)   , 
      Ferramentas_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(Ferramentas_id) REFERENCES tools(id)) ; 

CREATE TABLE report_items( 
      id  INTEGER    NOT NULL  , 
      questions_id int   NOT NULL  , 
      reports_id int   NOT NULL  , 
      resposta text   NOT NULL  , 
      descricao varchar  (200)   , 
 PRIMARY KEY (id),
FOREIGN KEY(questions_id) REFERENCES questions(id),
FOREIGN KEY(reports_id) REFERENCES reports(id)) ; 

CREATE TABLE reports( 
      id  INTEGER    NOT NULL  , 
      user_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(user_id) REFERENCES system_users(id)) ; 

CREATE TABLE system_group( 
      id int   NOT NULL  , 
      name text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group_program( 
      id int   NOT NULL  , 
      system_group_id int   NOT NULL  , 
      system_program_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(system_program_id) REFERENCES system_program(id),
FOREIGN KEY(system_group_id) REFERENCES system_group(id)) ; 

CREATE TABLE system_preference( 
      id text   NOT NULL  , 
      preference text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_program( 
      id int   NOT NULL  , 
      name text   NOT NULL  , 
      controller text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_unit( 
      id int   NOT NULL  , 
      name text   NOT NULL  , 
      connection_name text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_group( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_group_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(system_group_id) REFERENCES system_group(id),
FOREIGN KEY(system_user_id) REFERENCES system_users(id)) ; 

CREATE TABLE system_user_program( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_program_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(system_program_id) REFERENCES system_program(id),
FOREIGN KEY(system_user_id) REFERENCES system_users(id)) ; 

CREATE TABLE system_users( 
      id int   NOT NULL  , 
      name text   NOT NULL  , 
      login text   NOT NULL  , 
      password text   NOT NULL  , 
      email text   , 
      frontpage_id int   , 
      system_unit_id int   , 
      active char  (1)   , 
      Phone varchar  (15)   , 
 PRIMARY KEY (id),
FOREIGN KEY(frontpage_id) REFERENCES system_program(id),
FOREIGN KEY(system_unit_id) REFERENCES system_unit(id)) ; 

CREATE TABLE system_user_unit( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_unit_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(system_user_id) REFERENCES system_users(id),
FOREIGN KEY(system_unit_id) REFERENCES system_unit(id)) ; 

CREATE TABLE tools( 
      id  INTEGER    NOT NULL  , 
      nome varchar  (50)   NOT NULL  , 
      descricao varchar  (300)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

 
 CREATE UNIQUE INDEX idx_questions_question ON questions(question);
 CREATE UNIQUE INDEX idx_tools_nome ON tools(nome);
 
  
