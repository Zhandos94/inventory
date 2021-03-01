FROM node:lts-alpine
WORKDIR /var/www/frontend

ENV PATH /var/www/frontend/node_modules/.bin:$PATH

COPY /frontend/package.json ./
RUN npm install

EXPOSE 8080
CMD ["npm", "run", "serve"]


# docker-composer up # to start the compilation process
# to install npm package run
# docker-compose exec web npm i bootstrap