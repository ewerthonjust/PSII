PRAGMA foreign_keys=OFF; 

CREATE TABLE categorias( 
      id  INTEGER    NOT NULL  , 
      categoria varchar  (20)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE ferramentas( 
      id  INTEGER    NOT NULL  , 
      nome varchar  (50)   NOT NULL  , 
      descricao varchar  (300)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE itens_relatorio( 
      id  INTEGER    NOT NULL  , 
      pergunta_id int   NOT NULL  , 
      resposta text   NOT NULL  , 
      comentario text   NOT NULL  , 
      relatorio_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(pergunta_id) REFERENCES perguntas(id),
FOREIGN KEY(relatorio_id) REFERENCES relatorios(id)) ; 

CREATE TABLE perguntas( 
      id  INTEGER    NOT NULL  , 
      pergunta varchar  (200)   NOT NULL  , 
      descricao varchar  (300)   , 
      ferramenta_id int   NOT NULL  , 
      categorias_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(ferramenta_id) REFERENCES ferramentas(id),
FOREIGN KEY(categorias_id) REFERENCES categorias(id)) ; 

CREATE TABLE relatorios( 
      id  INTEGER    NOT NULL  , 
      user_id int   NOT NULL  , 
      titulo varchar  (100)   NOT NULL  , 
      descricao text   NOT NULL  , 
      criacao datetime   NOT NULL  , 
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
      id varchar  (255)   NOT NULL  , 
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
      phone text   , 
      email text   , 
      frontpage_id int   , 
      system_unit_id int   , 
      active char  (1)   , 
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

 
 CREATE UNIQUE INDEX idx_categorias_categoria ON categorias(categoria);
 CREATE UNIQUE INDEX idx_ferramentas_nome ON ferramentas(nome);
 CREATE UNIQUE INDEX idx_perguntas_pergunta ON perguntas(pergunta);
 CREATE UNIQUE INDEX idx_relatorios_titulo ON relatorios(titulo);
 
  
