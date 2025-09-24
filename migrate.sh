echo "CREATE DATABASE coffine;"| docker exec -i pg-coffine psql -U postgres
cat ./database.sql | docker exec -i pg-coffine psql -U postgres -d coffine