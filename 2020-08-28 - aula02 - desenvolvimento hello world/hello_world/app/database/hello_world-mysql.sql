CREATE TABLE tbl_cidade( 
      id  INT  AUTO_INCREMENT    NOT NULL  , 
      nome varchar  (50)   NOT NULL  , 
      estado int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE tbl_estado( 
      id  INT  AUTO_INCREMENT    NOT NULL  , 
      nome int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE tbl_usuario( 
      id  INT  AUTO_INCREMENT    NOT NULL  , 
      nome varchar  (50)   NOT NULL  , 
      sobrenome varchar  (20)   NOT NULL  , 
      empresa varchar  (50)   NOT NULL  , 
      cidade int   NOT NULL  , 
      telefone varchar  (20)   , 
      email varchar  (100)   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

 
  
 ALTER TABLE tbl_cidade ADD CONSTRAINT fk_tbl_cidade_1 FOREIGN KEY (estado) references tbl_estado(id); 
ALTER TABLE tbl_usuario ADD CONSTRAINT fk_tbl_usuario_1 FOREIGN KEY (cidade) references tbl_cidade(id); 

  
