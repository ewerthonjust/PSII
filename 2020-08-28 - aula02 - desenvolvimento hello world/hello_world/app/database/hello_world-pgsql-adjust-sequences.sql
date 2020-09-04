SELECT setval('tbl_cidade_id_seq', coalesce(max(id),0) + 1, false) FROM tbl_cidade;
SELECT setval('tbl_estado_id_seq', coalesce(max(id),0) + 1, false) FROM tbl_estado;
SELECT setval('tbl_usuario_id_seq', coalesce(max(id),0) + 1, false) FROM tbl_usuario;