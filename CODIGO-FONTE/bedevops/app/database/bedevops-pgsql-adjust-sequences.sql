SELECT setval('categorias_id_seq', coalesce(max(id),0) + 1, false) FROM categorias;
SELECT setval('ferramentas_id_seq', coalesce(max(id),0) + 1, false) FROM ferramentas;
SELECT setval('itens_relatorio_id_seq', coalesce(max(id),0) + 1, false) FROM itens_relatorio;
SELECT setval('perguntas_id_seq', coalesce(max(id),0) + 1, false) FROM perguntas;
SELECT setval('relatorios_id_seq', coalesce(max(id),0) + 1, false) FROM relatorios;