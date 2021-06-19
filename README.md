# Desafio Full Stack Quikdev

## Instruções
Conforme solicitado foi utilizada a plataforma PHP (Lumen 8.* + MySql).

O primeiro passo para rodar a api é, após clonar este repositório, copiar o arquivo `.env.example` e salve como `.env`.

Devem ser adicionadas/modificadas as seguintes informações:
- "TMDB_APIKEY", que é a chave utilizada para autenticação na api tmdb
- "TMDB_ENDPOINT", inicialmente pode ser utilizado o valor: 'https://api.themoviedb.org'
- "TMDB_IMAGES", que é o endpoint de imagens, inicialmente pode ser utilizado o valor:  'https://image.tmdb.org/t/p/'
- "DB_HOST"=db (container mysql dentro do docker)
- "DB_PORT"=3306 (porta padrão dentro do docker)
- "DB_DATABASE"=quikdev_api (nome do banco de dados inicial)
- "DB_USERNAME"=root
- "DB_PASSWORD"=root

Para verificar se a sua solução está funcionando, utilize o comando `docker-compose up --build` a partir do diretório raiz do projeto. 
A API estará mapeada para a porta `8001` do seu host local. Uma requisição `GET localhost:8001/` vai retornar a versão do Lumen em execução.

**IMPORTANTE:** após a execução do `docker-compose up -d`, na pasta do projeto, execute o comando `docker-compose run web composer install` e em seguida `docker-compose run web php artisan key:generate`.
Quando o volume atual é mapeado para dentro do container, ele sobrescreve a pasta com as dependências instaladas pelo composer, por isso o comando é necessário. 

**DEVE SER EXECUTADO O COMANDO MIGRAÇÃO** antes de testar o funcionamento da aplicação, para isso execute o comando `docker-compose run web php artisan migrate --seed`. Após a execução serão criadas as tabelas e dados básicos dos filmes.

