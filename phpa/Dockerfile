FROM php:apache

#RUN ulimit -a
#Обновляем репозитории
RUN apt-get update
# Устанавливаем MC
RUN apt-get -y install mc


RUN docker-php-ext-install mysqli


RUN docker-php-ext-install pdo pdo_mysql 
RUN a2enmod rewrite

RUN mkdir -p  /etc/apache2/from-host

RUN echo "" >> /etc/apache2/apache2.conf \
    && echo "# Include the configurations from the host machine" >> /etc/apache2/apache2.conf \
    && echo "IncludeOptional from-host/*.conf" >> /etc/apache2/apache2.conf


RUN echo "" >> /etc/apache2/apache2.conf \
    && echo "# Исправляем ошибку apache2: Could not reliably determine the server's fully qualified domain name" >> /etc/apache2/apache2.conf \
    && echo "ServerName localhost   " >> /etc/apache2/apache2.conf






RUN service apache2 restart
