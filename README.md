```
$ docker build -t venture .  

## Prebuild
$ docker run --rm -p 8080:8080 venture

## For development purposes
$ docker run --rm -v ${PWD}:/app -p 8080:8080 venture -c "composer install"
$ docker run --rm -v ${PWD}:/app -p 8080:8080 venture
```

[localhost:8080](http://localhost:8080)


Add cheats(add item, restore health)
