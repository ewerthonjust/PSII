CREATE TABLE categoria( 
      id  SERIAL    NOT NULL  , 
      categoria varchar  (20)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE ferramenta( 
      id  SERIAL    NOT NULL  , 
      nome varchar  (50)   NOT NULL  , 
      descricao varchar  (300)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE item_relatorio( 
      id  SERIAL    NOT NULL  , 
      pergunta_id integer   NOT NULL  , 
      resposta boolean   NOT NULL  , 
      comentario text   NOT NULL  , 
      relatorio_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pergunta( 
      id  SERIAL    NOT NULL  , 
      pergunta varchar  (200)   NOT NULL  , 
      descricao varchar  (300)   , 
      ferramenta_id integer   NOT NULL  , 
      categoria_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE relatorio( 
      id  SERIAL    NOT NULL  , 
      user_id integer   , 
      titulo varchar  (100)   NOT NULL  , 
      descricao text   NOT NULL  , 
      criacao timestamp   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE resultado( 
      id  SERIAL    NOT NULL  , 
      categoria_id integer   NOT NULL  , 
      relatorio_id integer   NOT NULL  , 
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

  
