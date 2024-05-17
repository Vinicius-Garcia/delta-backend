# Backend - Desafio Delta

## Pré-requisitos
Composer 2.7.6

PHP versão 8.1 ou maior , com as extensões:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

Extensões necessárias do PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library


## Como executar o projeto

- Mudar no app/Config/Database o username, password e database
- usar o comando php spark migrate para criação das tabelas
- php spark serve para executar a api
