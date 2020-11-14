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
      user_id int   , 
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

 
 ALTER TABLE categoria ADD UNIQUE (categoria);
 ALTER TABLE ferramenta ADD UNIQUE (nome);
 ALTER TABLE pergunta ADD UNIQUE (pergunta);
 ALTER TABLE relatorio ADD UNIQUE (titulo);
  
 ALTER TABLE item_relatorio ADD CONSTRAINT fk_report_answer_item_1 FOREIGN KEY (pergunta_id) references pergunta(id); 
ALTER TABLE item_relatorio ADD CONSTRAINT fk_report_answer_item_2 FOREIGN KEY (relatorio_id) references relatorio(id); 
ALTER TABLE pergunta ADD CONSTRAINT fk_Questions_1 FOREIGN KEY (ferramenta_id) references ferramenta(id); 
ALTER TABLE pergunta ADD CONSTRAINT fk_perguntas_2 FOREIGN KEY (categoria_id) references categoria(id); 
ALTER TABLE resultado ADD CONSTRAINT fk_resultados_1 FOREIGN KEY (categoria_id) references categoria(id); 
ALTER TABLE resultado ADD CONSTRAINT fk_resultados_2 FOREIGN KEY (relatorio_id) references relatorio(id); 

  
