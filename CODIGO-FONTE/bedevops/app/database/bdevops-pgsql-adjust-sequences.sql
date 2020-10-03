SELECT setval('questions_id_seq', coalesce(max(id),0) + 1, false) FROM questions;
SELECT setval('report_items_id_seq', coalesce(max(id),0) + 1, false) FROM report_items;
SELECT setval('reports_id_seq', coalesce(max(id),0) + 1, false) FROM reports;
SELECT setval('tools_id_seq', coalesce(max(id),0) + 1, false) FROM tools;