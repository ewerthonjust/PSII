PRAGMA foreign_keys=OFF; 

CREATE TABLE tbl_cidade( 
      id  INTEGER    NOT NULL  , 
      nome varchar  (50)   NOT NULL  , 
      estado int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(estado) REFERENCES tbl_estado(id)) ; 

CREATE TABLE tbl_estado( 
      id  INTEGER    NOT NULL  , 
      nome int  (50)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tbl_usuario( 
      id  INTEGER    NOT NULL  , 
      nome varchar  (50)   NOT NULL  , 
      sobrenome varchar  (20)   NOT NULL  , 
      empresa varchar  (50)   NOT NULL  , 
      cidade int   NOT NULL  , 
      telefone varchar  (20)   , 
      email varchar  (100)   , 
 PRIMARY KEY (id),
FOREIGN KEY(cidade) REFERENCES tbl_cidade(id)) ; 

 
 
  
