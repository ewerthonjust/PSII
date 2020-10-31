SELECT setval('categoria_id_seq', coalesce(max(id),0) + 1, false) FROM categoria;
SELECT setval('ferramenta_id_seq', coalesce(max(id),0) + 1, false) FROM ferramenta;
SELECT setval('item_relatorio_id_seq', coalesce(max(id),0) + 1, false) FROM item_relatorio;
SELECT setval('pergunta_id_seq', coalesce(max(id),0) + 1, false) FROM pergunta;
SELECT setval('relatorio_id_seq', coalesce(max(id),0) + 1, false) FROM relatorio;
SELECT setval('resultado_id_seq', coalesce(max(id),0) + 1, false) FROM resultado;