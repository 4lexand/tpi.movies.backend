## PROYECTO DE PELICULAS TPI 2021

#### COMANDOS:
```
composer install
crear el archivo .env (Copiar el .env.example y renombrarlo)
php artisan key:generate
php artisan migrate 
php artisan db:seed (Si no les funciona, tendran que meter manualmente el rol de usuario Admin y Client en la tabla de roles)
php artisan serve 
```

#### Los archivos que se usan son:
```
- /App/Http/Controllers/... Ahi estan todos los controladores
- /App/Models/... Ahi estan ciertas clases necesarias que almacenan unas variables
- /App/... Ahi estan todos los modelos 
- /routes/api Ahi esta todas las rutas y seteadas a que controlador y a que metodo ira
- /database/migrations/... Ahi estan todas las migraciones que son la estructura de la base de datos
-/database/seeds/... Ahi estan los seeders que son los datos predeterminados que se ingresaran a la base de datos despues de hacer la migracion (A veces no sirve y tendran que meter manualmente el rol de usuario Admin y Client en la tabla de roles)
```

