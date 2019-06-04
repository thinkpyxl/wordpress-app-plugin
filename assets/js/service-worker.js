importScripts("https://storage.googleapis.com/workbox-cdn/releases/3.6.3/workbox-sw.js");
importScripts("/pre-cache?route=<.route.>");

workbox.skipWaiting();
workbox.clientsClaim();

self.__precacheManifest = [].concat(self.__precacheManifest || []);
workbox.precaching.suppressWarnings();
workbox.precaching.precacheAndRoute(self.__precacheManifest, {});

workbox.routing.registerRoute(
  /\.(?:png|gif|jpe?g|svg)$/,
  workbox.strategies.cacheFirst({
    cacheName: 'images-cache'
  })
);

workbox.routing.registerRoute(
  /\.js/,
  workbox.strategies.cacheFirst({
    cacheName: 'scripts-cache'
  })
);

workbox.routing.registerRoute(
  /\.css/,
  workbox.strategies.cacheFirst({
    cacheName: 'styles-cache'
  })
);

workbox.routing.registerRoute(
  /\/.+\//,
  workbox.strategies.cacheFirst({
    cacheName: 'page-cache'
  })
);
