CREATE TABLE categorias( 
      id  SERIAL    NOT NULL  , 
      categoria varchar  (20)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE ferramentas( 
      id  SERIAL    NOT NULL  , 
      nome varchar  (50)   NOT NULL  , 
      descricao varchar  (300)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE itens_relatorio( 
      id  SERIAL    NOT NULL  , 
      pergunta_id integer   NOT NULL  , 
      resposta boolean   NOT NULL  , 
      comentario text   NOT NULL  , 
      relatorio_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE perguntas( 
      id  SERIAL    NOT NULL  , 
      pergunta varchar  (200)   NOT NULL  , 
      descricao varchar  (300)   , 
      ferramenta_id integer   NOT NULL  , 
      categorias_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE relatorios( 
      id  SERIAL    NOT NULL  , 
      user_id integer   NOT NULL  , 
      titulo varchar  (100)   NOT NULL  , 
      descricao text   NOT NULL  , 
      criacao timestamp   NOT NULL  , 
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
      id varchar  (255)   NOT NULL  , 
      preference text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

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
      phone text   , 
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

 
 ALTER TABLE categorias ADD UNIQUE (categoria);
 ALTER TABLE ferramentas ADD UNIQUE (nome);
 ALTER TABLE perguntas ADD UNIQUE (pergunta);
 ALTER TABLE relatorios ADD UNIQUE (titulo);
  
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

  
