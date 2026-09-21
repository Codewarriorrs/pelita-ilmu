# Tahap 1: Build asset frontend (Tailwind/Vite)
FROM node:20-alpine AS build-assets
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# Tahap 2: Image final PHP + Nginx
FROM richarvey/nginx-php-fpm:3.1.6

RUN sed -i 's|try_files \$uri \$uri/ =404;|try_files \$uri \$uri/ /index.php?\$query_string;|g' /etc/nginx/sites-enabled/default.conf 2>/dev/null || true
RUN sed -i 's|root /var/www/html;|root /var/www/html/public;|g' /etc/nginx/sites-enabled/default.conf 2>/dev/null || true
RUN sed -i 's|expires           5d;|try_files $uri /index.php?$query_string;\n                expires           5d;|g' /etc/nginx/sites-enabled/default.conf 2>/dev/null || true

COPY . .

# Salin hasil build asset dari tahap 1 ke folder public
COPY --from=build-assets /app/public/build /var/www/html/public/build

EXPOSE 80

ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr

CMD ["/start.sh"]