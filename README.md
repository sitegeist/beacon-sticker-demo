# estimote Nearable Demonstration

This project consists of two parts:

1. An iPhone App which runs in Evothings Viewer and lists all estimote stickers in range.
   In this app you can assign an URL to each found sticker.
   If one of the stickers is moved then the app calls a server side component with the
   assigned URL.
2. The server side part which initially shows an introductional page and after clicking the
   run button it waits for URLs to show in browsers full screen mode (kiosk).
   The URLs are sent by smartphones running the application.

## Installation on server

You can run the server part with docker: ```docker-compose up```.
The web server runs on port 8085. You can change this in docker-compose.yml.

## Installation on iPhone

First install the Evothings Viewer. You can get it via the app store for free.
After that open a browser in your phone and call the URL of your server part. Your webserver has to be
accessable (DNS or static IP) from your smart phone.

16.09.2016
(c) sitegeist media solutions GmbH
Alexander Bohndorf <bohndorf@sitegeist.de>