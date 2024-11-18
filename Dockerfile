# Usa la imagen base con PHP y Apache
FROM php:8.2-apache

# Establece el directorio de trabajo en el contenedor
WORKDIR /var/www/html

# Copia todos los archivos desde tu directorio actual al contenedor
COPY . /var/www/html/

# Da permisos adecuados a los archivos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Asegúrate de que Apache busque index.php y index.html por defecto
RUN echo "DirectoryIndex index.php index.html" >> /etc/apache2/apache2.conf

# Habilita los modulos de Apache necesarios (en caso de que no estén habilitados)
RUN a2enmod rewrite

# Reinicia Apache para aplicar la configuración
RUN service apache2 restart

# Expone el puerto 80 para HTTP
EXPOSE 80

# Inicia el servidor Apache
CMD ["apache2-foreground"]
