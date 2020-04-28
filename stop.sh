# stop.sh

# Останавливаем все сервисы Docker

docker container stop $(docker container ls -aq)