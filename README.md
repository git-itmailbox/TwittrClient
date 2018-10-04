# rss_viewer

Project requires docker-composer

1. Clone the project.
2. Go into `PROJECT/docker` directory and enter in terminal `docker-compose up`
3. Then open another terminal and go to the same directory  `PROJECT/docker` and run `docker-compose exec app_rss composer install`.
4. Next, enter in terminal `docker-compose exec app_rss memcached -u nobody -d` to start memcached server inside the container
5. Next, go to the root of `PROJECT`
 and type in terminal `npm install`
 6. Next, starting fronted (Vue) `npm run dev`
 
 Backend runs on port 8000, and frontend on 8080
 

 
> A Vue.js project

## Build Setup

``` bash
# install dependencies
npm install

# serve with hot reload at localhost:8080
npm run dev

# build for production with minification
npm run build
```

For detailed explanation on how things work, consult the [docs for vue-loader](http://vuejs.github.io/vue-loader).
