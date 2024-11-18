# Usa la imagen base con PHP y Apache
FROM php:8.2-apache

# Instalar dependencias para que el contenedor funcione correctamente, incluso si no usas pg_connect
RUN apt-get update && apt-get install -y \
    libpq-dev \  # Dependencia para el cliente PostgreSQL (sin PDO)
    && docker-php-ext-install pgsql  # Instalar la extensión pgsql si es compatible

# Establece el directorio de trabajo en el contenedor
WORKDIR /var/www/html

# Copia todos los archivos desde tu directorio actual al contenedor
COPY . /var/www/html/

# Da permisos adecuados a los archivos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Asegúrate de que Apache busque index.php por defecto
RUN echo "DirectoryIndex index.php" >> /etc/apache2/apache2.conf

# Habilita el módulo de Apache para reescritura de URL (si lo necesitas)
RUN a2enmod rewrite

# Expone el puerto 80 para HTTP
EXPOSE 80

# Inicia el servidor Apache
CMD ["apache2-foreground"]
