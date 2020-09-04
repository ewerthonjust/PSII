CREATE TABLE tbl_cidade( 
      id  SERIAL    NOT NULL  , 
      nome varchar  (50)   NOT NULL  , 
      estado integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tbl_estado( 
      id  SERIAL    NOT NULL  , 
      nome integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tbl_usuario( 
      id  SERIAL    NOT NULL  , 
      nome varchar  (50)   NOT NULL  , 
      sobrenome varchar  (20)   NOT NULL  , 
      empresa varchar  (50)   NOT NULL  , 
      cidade integer   NOT NULL  , 
      telefone varchar  (20)   , 
      email varchar  (100)   , 
 PRIMARY KEY (id)) ; 

 
  
 ALTER TABLE tbl_cidade ADD CONSTRAINT fk_tbl_cidade_1 FOREIGN KEY (estado) references tbl_estado(id); 
ALTER TABLE tbl_usuario ADD CONSTRAINT fk_tbl_usuario_1 FOREIGN KEY (cidade) references tbl_cidade(id); 

  
