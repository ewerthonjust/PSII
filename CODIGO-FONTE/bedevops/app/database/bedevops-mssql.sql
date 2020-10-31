CREATE TABLE categoria( 
      id  INT IDENTITY    NOT NULL  , 
      categoria varchar  (20)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE ferramenta( 
      id  INT IDENTITY    NOT NULL  , 
      nome varchar  (50)   NOT NULL  , 
      descricao varchar  (300)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE item_relatorio( 
      id  INT IDENTITY    NOT NULL  , 
      pergunta_id int   NOT NULL  , 
      resposta bit   NOT NULL  , 
      comentario nvarchar(max)   NOT NULL  , 
      relatorio_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pergunta( 
      id  INT IDENTITY    NOT NULL  , 
      pergunta varchar  (200)   NOT NULL  , 
      descricao varchar  (300)   , 
      ferramenta_id int   NOT NULL  , 
      categoria_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE relatorio( 
      id  INT IDENTITY    NOT NULL  , 
      user_id int   NOT NULL  , 
      titulo varchar  (100)   NOT NULL  , 
      descricao nvarchar(max)   NOT NULL  , 
      criacao datetime2   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE resultado( 
      id  INT IDENTITY    NOT NULL  , 
      categoria_id int   NOT NULL  , 
      relatorio_id int   NOT NULL  , 
      valor float   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group( 
      id int   NOT NULL  , 
      name nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group_program( 
      id int   NOT NULL  , 
      system_group_id int   NOT NULL  , 
      system_program_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_preference( 
      id varchar  (255)   NOT NULL  , 
      preference nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_program( 
      id int   NOT NULL  , 
      name nvarchar(max)   NOT NULL  , 
      controller nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_unit( 
      id int   NOT NULL  , 
      name nvarchar(max)   NOT NULL  , 
      connection_name nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_group( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_group_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_program( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_program_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_users( 
      id int   NOT NULL  , 
      name nvarchar(max)   NOT NULL  , 
      login nvarchar(max)   NOT NULL  , 
      password nvarchar(max)   NOT NULL  , 
      phone nvarchar(max)   , 
      email nvarchar(max)   , 
      frontpage_id int   , 
      system_unit_id int   , 
      active char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_unit( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_unit_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

 
 ALTER TABLE categoria ADD UNIQUE (categoria);
 ALTER TABLE ferramenta ADD UNIQUE (nome);
 ALTER TABLE pergunta ADD UNIQUE (pergunta);
 ALTER TABLE relatorio ADD UNIQUE (titulo);
  
 ALTER TABLE item_relatorio ADD CONSTRAINT fk_report_answer_item_1 FOREIGN KEY (pergunta_id) references pergunta(id); 
ALTER TABLE item_relatorio ADD CONSTRAINT fk_report_answer_item_2 FOREIGN KEY (relatorio_id) references relatorio(id); 
ALTER TABLE pergunta ADD CONSTRAINT fk_Questions_1 FOREIGN KEY (ferramenta_id) references ferramenta(id); 
ALTER TABLE pergunta ADD CONSTRAINT fk_perguntas_2 FOREIGN KEY (categoria_id) references categoria(id); 
ALTER TABLE relatorio ADD CONSTRAINT fk_reports_1 FOREIGN KEY (user_id) references system_users(id); 
ALTER TABLE resultado ADD CONSTRAINT fk_resultados_1 FOREIGN KEY (categoria_id) references categoria(id); 
ALTER TABLE resultado ADD CONSTRAINT fk_resultados_2 FOREIGN KEY (relatorio_id) references relatorio(id); 
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

  
