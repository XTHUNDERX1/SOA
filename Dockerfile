# Usa la imagen base con PHP y Apache
FROM php:8.2-apache

# Actualiza el sistema e instala dependencias necesarias (PostgreSQL y Apache)
RUN apt-get update && apt-get install -y \
    libpq-dev \  # Necesario para la conexión con PostgreSQL
    && docker-php-ext-install pgsql pdo_pgsql \  # Instalar las extensiones PostgreSQL
    && a2enmod rewrite  # Habilita la reescritura de URL de Apache si es necesario

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos de tu aplicación al contenedor
COPY . /var/www/html/

# Da permisos adecuados a los archivos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Asegúrate de que Apache busque index.php por defecto
RUN echo "DirectoryIndex index.php" >> /etc/apache2/apache2.conf

# Expone el puerto 80 para HTTP
EXPOSE 80

# Inicia Apache en primer plano
CMD ["apache2-foreground"]
