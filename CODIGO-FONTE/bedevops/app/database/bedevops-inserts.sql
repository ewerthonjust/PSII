INSERT INTO categoria (id,categoria) VALUES (1,'Delivery'); 

INSERT INTO categoria (id,categoria) VALUES (2,'Deployment'); 

INSERT INTO categoria (id,categoria) VALUES (3,'Operation'); 

INSERT INTO ferramenta (id,nome,descricao) VALUES (1,'Ansible','Ansible é uma ferramenta de TI de código aberto para gerenciar, automatizar, configurar servidores e, implantar aplicativos, a partir de uma localização central.'); 

INSERT INTO ferramenta (id,nome,descricao) VALUES (2,'AWS','AWS é uma plataforma de serviços de computação em nuvem oferecida pela Amazon.'); 

INSERT INTO ferramenta (id,nome,descricao) VALUES (3,'Confluence','Confluence é uma wiki corporativa baseada em web onde conhecimento e colaboração de uma equipe pode ser centralizada.'); 

INSERT INTO ferramenta (id,nome,descricao) VALUES (4,'Docker','Docker é um conjunto de produtos de plataforma como serviço que usam virtualização de nível de sistema operacional para entregar software em pacotes chamados contêineres.'); 

INSERT INTO ferramenta (id,nome,descricao) VALUES (5,'ELK','O ELK Stack é uma coleção de três produtos de código aberto - Elasticsearch, Logstash e Kibana, onde E significa ElasticSearch: usado para armazenar logs, L significa LogStash: usado para envio, bem como processamento e armazenamento de logs e K significa Kibana: é uma ferramenta de visualização (uma interface web) que é hospedada através do Nginx ou Apache.'); 

INSERT INTO ferramenta (id,nome,descricao) VALUES (6,'GitLab','O GitLab é um gerenciador de repositório de software baseado em git, com suporte a Wiki, gerenciamento de tarefas e CI/CD.'); 

INSERT INTO ferramenta (id,nome,descricao) VALUES (7,'Gradle','Gradle é um sistema de automação de compilação open source que se baseia nos conceitos de Apache Ant e Apache Maven e introduz uma linguagem de domínio específico baseada em Groovy em vez do XML usado pelo Apache Maven para declarar a configuração do projeto.'); 

INSERT INTO ferramenta (id,nome,descricao) VALUES (8,'Grafana','Grafana é uma aplicação web de análise de código aberto multiplataforma e visualização interativa da web. Ele fornece tabelas, gráficos e alertas para a Web quando conectado a fontes de dados suportadas.'); 

INSERT INTO ferramenta (id,nome,descricao) VALUES (9,'Jenkins','Jenkins é um servidor de automação gratuito e de código aberto. Ele ajuda a automatizar as partes do desenvolvimento de software relacionadas à construção, teste e implantação, facilitando a integração e entrega contínuas.'); 

INSERT INTO ferramenta (id,nome,descricao) VALUES (10,'Jira','Jira é um software comercial que permite o monitoramento de tarefas e acompanhamento de projetos garantindo o gerenciamento de todas as suas atividades em único lugar.'); 

INSERT INTO ferramenta (id,nome,descricao) VALUES (11,'Nagios','Nagios é uma popular aplicação de monitoramento de rede de código aberto distribuída sob a licença GPL. Ele pode monitorar tanto hosts quanto serviços, alertando quando ocorrerem problemas e também quando os problemas são resolvidos.'); 

INSERT INTO ferramenta (id,nome,descricao) VALUES (12,'Nexus','Nexus é um repositório de código aberto que oferece suporte a muitos formatos de artefatos, incluindo Docker, Java e npm. Com a integração da ferramenta Nexus, as pipelines em seu conjunto de ferramentas podem publicar e recuperar aplicativos com versão e suas dependências usando repositórios centrais que podem ser acessados em outros ambientes.'); 

INSERT INTO ferramenta (id,nome,descricao) VALUES (13,'Rundeck','Rundeck é uma automação de runbook para gerenciamento de incidentes, continuidade de negócios e operações de autoatendimento.'); 

INSERT INTO ferramenta (id,nome,descricao) VALUES (14,'Slack','Slack é uma plataforma proprietária de comunicação comercial que oferece muitos recursos no estilo IRC, incluindo salas de bate-papo persistentes organizadas por tópico, grupos privados e mensagens diretas.'); 

INSERT INTO pergunta (id,pergunta,descricao,ferramenta_id,categoria_id) VALUES (1,'As documentações do projeto estão acessíveis a qualquer membro da equipe de forma transparente e colaborativa?','Colaboração entre os membros da equipe para que possam compartilhar conhecimento e experiências.',3,1); 

INSERT INTO pergunta (id,pergunta,descricao,ferramenta_id,categoria_id) VALUES (2,'Uma documentação detalhada sobre os artefatos entregues e seu uso durante o CI/CD e processos de implantação (instalação, execução, atualização, downgrade, migração) é fornecida?','Balanceamento do nível de compreensão técnica da equipe de toda a cadeia de entrega.',3,1); 

INSERT INTO pergunta (id,pergunta,descricao,ferramenta_id,categoria_id) VALUES (3,'Uma ilustração mostrando as dependências de todos os componentes é fornecida?','Balanceamento do nível de compreensão de dependências do negocio.',3,1); 

INSERT INTO pergunta (id,pergunta,descricao,ferramenta_id,categoria_id) VALUES (4,'Os artefatos de software da aplicação são entregues como pacotes com base em um formato de embalagem padrão (como .rpm ou contêiner)?','Restabelecimento de um serviço em um curto espaço de tempo.',4,1); 

INSERT INTO pergunta (id,pergunta,descricao,ferramenta_id,categoria_id) VALUES (5,'O código-fonte é centralizado em repositórios, versionado e compartilhado?','Colaboração entre membros das equipes e versionamento de arquivos.',6,1); 

INSERT INTO pergunta (id,pergunta,descricao,ferramenta_id,categoria_id) VALUES (6,'Todos os artefatos de software e configurações fornecidos são versionados?','Garantir a rastreabilidade das mudanças; evitar mudanças, que contornam a rastreabilidade e o controle de versão; reestabelecimento de serviços.',6,1); 

INSERT INTO pergunta (id,pergunta,descricao,ferramenta_id,categoria_id) VALUES (7,'As rotinas de build são padronizadas e automatizadas?','Agilizar o fornecimento de pacotes e garantir a integridade das entregas.',7,1); 

INSERT INTO pergunta (id,pergunta,descricao,ferramenta_id,categoria_id) VALUES (8,'Existem rotinas de build programadas para fornecer os pacotes para a entrega contínua?','Garantir a entrega; agilizar o fornecimento de pacotes e automatização de entregas.',9,1); 

INSERT INTO pergunta (id,pergunta,descricao,ferramenta_id,categoria_id) VALUES (9,'O processo de integração contínua usado é capaz de disponibilizar pelo menos uma versão por dia?','Garantir a entrega; agilizar o fornecimento de pacotes e automatização de entregas.',9,1); 

INSERT INTO pergunta (id,pergunta,descricao,ferramenta_id,categoria_id) VALUES (10,'A gestão de demandas, alterações e ciclos de vida de projetos e aplicações são feitas de forma transparente e compartilhada?','Garantir a centralização de informações e agilizar os ciclos de entrega de correção e funcionalidades.',10,1); 

INSERT INTO pergunta (id,pergunta,descricao,ferramenta_id,categoria_id) VALUES (11,'Os artefatos são fornecidos em um repositório de artefatos no servidor de entrega? ','Garantir a entrega; Alta disponibilidade de dependências; Agilidade no fornecimento de pacotes e automatização de entregas.',12,1); 

INSERT INTO pergunta (id,pergunta,descricao,ferramenta_id,categoria_id) VALUES (12,'A comunicação da equipe é colaborativa e integrada com toda a cadeia de entrega?','Compartilhamento de informações.',14,1); 

INSERT INTO pergunta (id,pergunta,descricao,ferramenta_id,categoria_id) VALUES (13,'O desenvolvimento automatizado e baseado em modelo e gerenciamento de configuração do sistema são controlados com a ajuda de uma rotina de implantação?','Controle de mudanças; automatização da gestão de implantação de configurações.',1,2); 

INSERT INTO pergunta (id,pergunta,descricao,ferramenta_id,categoria_id) VALUES (14,'O processo de implantação é feito automaticamente sem nenhuma configuração manual?','Controle de mudanças; automatização da gestão de implantação de configurações.',1,2); 

INSERT INTO pergunta (id,pergunta,descricao,ferramenta_id,categoria_id) VALUES (15,'A rotina de implantação do sistema é instalada automaticamente e de forma padronizada a partir do arquivo de entrega provisionado?','Garantir a entrega; Alta disponibilidade de dependências; Agilidade no fornecimento de pacotes e automatização de entregas.',13,2); 

INSERT INTO pergunta (id,pergunta,descricao,ferramenta_id,categoria_id) VALUES (16,'A implantação de novas releases e feita forma automatizada ou por meio de interface gráfica?','Continuous Delivery.',13,2); 

INSERT INTO pergunta (id,pergunta,descricao,ferramenta_id,categoria_id) VALUES (17,'A gestão da alteração de configurações é realizada de uma forma automatizada?','Controle de mudanças; automatização da gestão de implantação de configurações.',1,3); 

INSERT INTO pergunta (id,pergunta,descricao,ferramenta_id,categoria_id) VALUES (18,'O provisionamento da infraestrutura é tratada como serviço?','Escalabilidade.',2,3); 

INSERT INTO pergunta (id,pergunta,descricao,ferramenta_id,categoria_id) VALUES (19,'A rotina de manutenção reage automaticamente na orquestração da nuvem e do sistema para lidar adequadamente com a reconfiguração necessária?','Restabelecimento de um serviço em um curto espaço de tempo.',4,3); 

INSERT INTO pergunta (id,pergunta,descricao,ferramenta_id,categoria_id) VALUES (20,'A analise de logs é feita por meio de interface gráfica com métricas pré-definidas?','Agilidade na analise para a solução de problemas.',5,3); 

INSERT INTO pergunta (id,pergunta,descricao,ferramenta_id,categoria_id) VALUES (21,'É possível controlar registro de logs por meio de interface gráfica?','Compartilhamento de informações para analise em time em possíveis problemas.',5,3); 

INSERT INTO pergunta (id,pergunta,descricao,ferramenta_id,categoria_id) VALUES (22,'O nível de log do sistema é configurável?','Agilidade na alteração do modo de analise de logs.',5,3); 

INSERT INTO pergunta (id,pergunta,descricao,ferramenta_id,categoria_id) VALUES (23,'É possível medir a disponibilidade de serviços e componentes?','Identificação de utilização de recursos para mensuração de escalabilidade.',8,3); 

INSERT INTO pergunta (id,pergunta,descricao,ferramenta_id,categoria_id) VALUES (24,'As mensagens de erro do sistema são classificadas por tipo e categorizadas em classes de alarme e gravidade?','Identificação de indisponibilidades; Transparência em priorização de ações.',11,3); 

INSERT INTO pergunta (id,pergunta,descricao,ferramenta_id,categoria_id) VALUES (25,'A disponibilidade dos serviços e componentes de negócios definidos é monitorada continuamente?','Identificação de indisponibilidades.',11,3); 
