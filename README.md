### git clone https://github.com/jpkamdem/tp-symfony.git

### cd tp-symfony

### docker compose up -d db

### docker exec -it "conteneur-symfony" bash

### php bon/console doctrine:migrations:migrate

### symfony serve (en dehors du conteneur)

### http://localhost:8000/reservation, http://localhost:8000/user
