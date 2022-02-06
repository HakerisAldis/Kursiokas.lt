#Docker
##Pasikurt sql docker konteineri:
docker run -e MYSQL_ROOT_PASSWORD='slaptazodis' --name='kursiokas-db' mysql:latest  

##Patikrint ar runnina docker konteineris:
docker container ls  

#Laravel
##Is docker puses
Pasikurt sql docker konteineri  
Lokaliai prisijungt: mysql -u root -h *Tavo docker konteinerio ip(Gali tikti ir 'kursiokas-db')*  
mysql komandinej eilutej runnint: create database kursiokas; (; privalomas)  

##Is laravelio puses
Kad susikelt db pirma reikia pasetupint .env faila, kad ji pasetupint pasikopini .env.example faila i .env ir ten pakeisk  
DB_CONNECTION=mysql  
DB_HOST=*Tavo docker konteinerio ip(Gali tikti ir 'kursiokas-db')*  
DB_PORT=3306  
DB_DATABASE=kursiokas  
DB_USERNAME=root  
DB_PASSWORD=slaptazodis  

Tada runnint komandas:  
composer install  
php artisan migrate  
