# api_php
projeto criaçao de api com php

Você foi convidado para desenvolver a API de um projeto. Para isso, foi escrito uma
pequena documentação das funcionalidades necessárias no projeto. Os desenvolvedores
frontend usarão a sua API para criar um aplicativo pessoal para monitorar quantas vezes o
usuário bebeu água.

Requisitos de implementação:
- O projeto deve ser desenvolvido em PHP;
- Não deve ser utilizado nenhum framework (Laravel, Slim framework, Doctrine, etc.);
- Todas as entradas e saídas devem ser no formato JSON;
- Se possível, a API deve seguir o padrão REST.


Tratamentos desejáveis:
- Na criação de um usuário, retornar um erro se o usuário já existe;
- No login, alertar que o usuário não existe ou que a senha está inválida;
- Na edição e na remoção do usuário, limitar-se apenas ao usuário autenticado.
Tratamentos opcionais:
- Paginação na lista de usuários;
- Criar um serviço que liste o histórico de registros de um usuário (retornando a data e
a quantidade em mL de cada registro);
- Criar um serviço que liste o ranking do usuário que mais bebeu água hoje
(considerando os ml e não a quantidade de vezes), retornando o nome e a
quantidade em mililitros (mL);
