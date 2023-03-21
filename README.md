# sandwich-api
Projet Bon Sandwich

## Technologies

- Slim (framework PHP)
- Docker
- MongoDB

### TODO

- Voir [Trello](https://trello.com/b/XjXoUlnJ/%F0%9F%A5%AAsandwich-api%F0%9F%A5%AA)

## Protocol de release

- Faire un merge de la branche `dev` vers la branche `main`
- Faire une release sur GitHub en remplissant correctement le changelog
- Vérifier le Trello pour déplacer les tâches dans les bonnes colonnes

----
Akrem 
Bertrand
Théo
Dorian
----

## url

Cours:
https://arche.univ-lorraine.fr/course/view.php?id=13845

### api.order
http://api.order.local:19080/

### adminer
http://api.order.local:8080/

http://api.order.local:8080/?server=order.db&username=order_lbs&db=order_lbs

## Serveur
order.db

## Le reste
order_lbs

# vHost
sudo nano /etc/hosts

## CLI:

sudo docker start -ia {nom-docker}

sudo docker exec -it {nom-docker} sh

sudo docker-compose up --no-start

sudo docker-compose start

sudo docker-compose down

sudo docker-compose ps

composer dump-autoload