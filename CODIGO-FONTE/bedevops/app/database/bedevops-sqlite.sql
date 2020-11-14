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
      user_id int   , 
      titulo varchar  (100)   NOT NULL  , 
      descricao text   NOT NULL  , 
      criacao datetime   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE resultado( 
      id  INTEGER    NOT NULL  , 
      categoria_id int   NOT NULL  , 
      relatorio_id int   NOT NULL  , 
      valor double   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(categoria_id) REFERENCES categoria(id),
FOREIGN KEY(relatorio_id) REFERENCES relatorio(id)) ; 

 
 CREATE UNIQUE INDEX idx_categoria_categoria ON categoria(categoria);
 CREATE UNIQUE INDEX idx_ferramenta_nome ON ferramenta(nome);
 CREATE UNIQUE INDEX idx_pergunta_pergunta ON pergunta(pergunta);
 CREATE UNIQUE INDEX idx_relatorio_titulo ON relatorio(titulo);
 
  
