FROM dunglas/frankenphp:alpine

# install the PHP extensions we need (https://make.wordpress.org/hosting/handbook/handbook/server-environment/#php-extensions)

# Installer ssmtp
RUN apk add --no-cache ssmtp

RUN install-php-extensions \
    bcmath \
    exif \
    gd \
    intl \
    pdo_mysql \
    mysqli \
    zip \
    opcache \
    xdebug

# Configure ssmtp pour utiliser MailHog
RUN echo "mailhub=mailhog:1025" > /etc/ssmtp/ssmtp.conf && \
    echo "hostname=localhost" >> /etc/ssmtp/ssmtp.conf

# (Optionnel) Ajoute un chemin pour sendmail
#RUN ln -s /usr/sbin/ssmtp /usr/sbin/sendmail

CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]