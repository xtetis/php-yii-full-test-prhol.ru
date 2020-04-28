# run.sh
clear

# Меняем права
echo -e "\e[43m*************************************\e[0m"
echo -e "\e[92mМеняем права\e[0m"
echo -e "\e[43m*************************************\e[0m"
sudo chmod 777 ./db/config.user.inc.php -v
sudo chmod 777 ./db/data -Rv
sudo chmod 777 ./web/log -v
echo ""
echo ""

echo -e "\e[43m*************************************\e[0m"
echo -e "\e[92mУбиваем процессы на 3306 порту\e[0m"
echo -e "\e[43m*************************************\e[0m"
sudo -S kill -9 `sudo lsof -t -i:3306`
echo ""
echo ""

echo -e "\e[43m*************************************\e[0m"
echo -e "\e[92mПерезапускаем сервис докера\e[0m"
echo -e "\e[43m*************************************\e[0m"
echo j3qq4h7h2v | sudo service docker restart
echo ""
echo ""


# Дописываем "ulimit -n 32000" в конец /etc/init.d/docker для 
# для исправления ошибки "apache2ctl ulimit error setting limit (operation not permitted)"
#echo j3qq4h7h2v | sudo echo "" >> /etc/init.d/docker 
#echo j3qq4h7h2v | sudo echo "ulimit -n 32000" >> /etc/init.d/docker 
#echo j3qq4h7h2v | sudo echo "" >> /etc/init.d/docker 
# Перезапускаем сервис докера
#echo j3qq4h7h2v | sudo service docker restart



# Запускаем наш локальный сервер
echo -e "\e[43m*************************************\e[0m"
echo -e "\e[92mЗапускаем наш локальный сервер docker-compose\e[0m"
echo -e "\e[43m*************************************\e[0m"
sudo docker-compose up
