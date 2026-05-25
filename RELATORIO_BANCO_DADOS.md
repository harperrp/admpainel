# Relatório Banco de Dados
- Arquivo de estrutura: `database/schema.sql`.
- Seed inicial: `database/seed.sql`.
- Importação no Plesk/phpMyAdmin: selecionar banco `camaravp` > Importar > enviar `schema.sql` e depois `seed.sql`.
- Configuração segura: definir `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS` e `SESSION_NAME` no ambiente do servidor (Apache/Nginx/Plesk).
- Nunca versionar senha real.

- A API em `api/config.php` agora aceita as variáveis de ambiente `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS` e `SESSION_NAME` com fallback local.
