FROM node:18

WORKDIR /app

COPY package*.json ./

RUN npm install

COPY . .

RUN rm -rf node_modules package-lock.json && npm install

EXPOSE 3000

CMD ["npm", "run", "dev"]