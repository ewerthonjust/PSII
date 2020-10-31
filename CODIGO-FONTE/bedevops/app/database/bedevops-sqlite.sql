PRAGMA foreign_keys=OFF; 

CREATE TABLE categoria( 
      id  INTEGER    NOT NULL  , 
      categoria varchar  (20)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE ferramenta( 
      id  INTEGER    NOT NULL  , 
      nome varchar  (50)   NOT NULL  , 
      descricao varchar  (300)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE item_relatorio( 
      id  INTEGER    NOT NULL  , 
      pergunta_id int   NOT NULL  , 
      resposta text   NOT NULL  , 
      comentario text   NOT NULL  , 
      relatorio_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(pergunta_id) REFERENCES pergunta(id),
FOREIGN KEY(relatorio_id) REFERENCES relatorio(id)) ; 

CREATE TABLE pergunta( 
      id  INTEGER    NOT NULL  , 
      pergunta varchar  (200)   NOT NULL  , 
      descricao varchar  (300)   , 
      ferramenta_id int   NOT NULL  , 
      categoria_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(ferramenta_id) REFERENCES ferramenta(id),
FOREIGN KEY(categoria_id) REFERENCES categoria(id)) ; 

CREATE TABLE relatorio( 
      id  INTEGER    NOT NULL  , 
      user_id int   NOT NULL  , 
      titulo varchar  (100)   NOT NULL  , 
      descricao text   NOT NULL  , 
      criacao datetime   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(user_id) REFERENCES system_users(id)) ; 

CREATE TABLE resultado( 
      id  INTEGER    NOT NULL  , 
      categoria_id int   NOT NULL  , 
      relatorio_id int   NOT NULL  , 
      valor double   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(categoria_id) REFERENCES categoria(id),
FOREIGN KEY(relatorio_id) REFERENCES relatorio(id)) ; 

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

 
 CREATE UNIQUE INDEX idx_categoria_categoria ON categoria(categoria);
 CREATE UNIQUE INDEX idx_ferramenta_nome ON ferramenta(nome);
 CREATE UNIQUE INDEX idx_pergunta_pergunta ON pergunta(pergunta);
 CREATE UNIQUE INDEX idx_relatorio_titulo ON relatorio(titulo);
 
  
