# Test Assignment MDC
#### Introduction
I didn't quite understand how to implement all this without a database. 
The application turned out to be completely stateless. 
I tried to focus on OOP.
Since the description indicated that experience in Laravel was needed, 
I tried to do everything on Lumen, instead of plain php code.

#### Structure
All src code located in ``src/app/Model`` directory.
Some kinds of contracts, repository, and service patterns used.

#### Base
All you need to do just up Docker container by:
```bash
docker-compose up -d
```
Jump into ``bash``:
```bash
docker-compose exec app bash
```
Or using php 7.4 directly :)
And run following ``phpunit`` exec:
```bash
php vendor/bin/phpunit --testdox
```