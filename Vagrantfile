
# -*- mode: ruby -*-
# vi: set ft=ruby :

# Define the variables
BOX_BASE = "debian/buster64"
BOX_RAM_MB = "2048"
BOX_CPU_COUNT = "2"
BOX_IP = "192.168.33.10"
NETWORK_NAME = "app-network"
REPORTS_CONTAINER = "reports"
QUIZ_CONTAINER = "quiz"
SMS_CONTAINER = "sms"
PHPMYADMIN_CONTAINER = "phpmyadmin"
MYSQL_CONTAINER = "mysql"
MYSQL_PASSWORD = "root"

Vagrant.configure("2") do |config|
  # Define the master node
  config.vm.define "master" do |master|
    master.vm.box = BOX_BASE
    master.vm.hostname = "master"
    master.vm.network :forwarded_port, guest: 24, host: 2224, auto_correct: true
    master.vm.network "private_network", ip: BOX_IP
    master.vm.provider "virtualbox" do |vb|
      vb.memory = BOX_RAM_MB
      vb.cpus = BOX_CPU_COUNT
    end
    master.vm.provision "shell", inline: <<-SHELL
      curl -sfL https://get.k3s.io | sh -
      sudo cp /etc/rancher/k3s/k3s.yaml /vagrant/kubeconfig
      sed -i "s/127\.0\.0\.1/#{BOX_IP}/" /vagrant/kubeconfig
      # Install Docker
      sudo apt-get update
      sudo apt-get install -y apt-transport-https ca-certificates curl gnupg2 software-properties-common
      curl -fsSL https://download.docker.com/linux/debian/gpg | sudo apt-key add -
      sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/debian buster stable"
      sudo apt-get update
      sudo apt-get install -y docker-ce docker-ce-cli containerd.io
      # Create a Docker network
      sudo docker network create #{NETWORK_NAME}
      # Run the containers
      sudo docker run -d -p 80:80 --name #{REPORTS_CONTAINER} --network #{NETWORK_NAME} -e REPORTS_DB_HOST=#{MYSQL_CONTAINER} -e REPORTS_DB_USER=root -e REPORTS_DB_PASSWORD=#{MYSQL_PASSWORD} -e REPORTS_DB_NAME=reports reports-1.0-prod
      sudo docker run -d -p 81:80 --name #{QUIZ_CONTAINER} --network #{NETWORK_NAME} -e QUIZ_DB_HOST=#{MYSQL_CONTAINER} -e QUIZ_DB_USER=root -e QUIZ_DB_PASSWORD=#{MYSQL_PASSWORD} -e QUIZ_DB_NAME=quiz quiz-1.0-prod
      sudo docker run -d -p 82:80 --name #{SMS_CONTAINER} --network #{NETWORK_NAME} -e SMS_DB_HOST=#{MYSQL_CONTAINER} -e SMS_DB_USER=root -e SMS_DB_PASSWORD=#{MYSQL_PASSWORD} -e SMS_DB_NAME=sms sms-1.0-prod
      # Import the phpmyadmin and mysql containers from Docker Hub
      sudo docker pull phpmyadmin/phpmyadmin
      sudo docker pull mysql/mysql-server
      # Run the phpmyadmin and mysql containers
      sudo docker run -d -p 83:80 --name #{PHPMYADMIN_CONTAINER} --network #{NETWORK_NAME} -e PMA_HOST=#{MYSQL_CONTAINER} phpmyadmin/phpmyadmin
      sudo docker run -d -p 3306:3306 --name #{MYSQL_CONTAINER} --network #{NETWORK_NAME} -e MYSQL_ROOT_PASSWORD=#{MYSQL_PASSWORD} mysql/mysql-server
      # Create the databases and tables for each application
      sudo docker exec #{MYSQL_CONTAINER} mysql -u root -p#{MYSQL_PASSWORD} -e "CREATE DATABASE reports; CREATE DATABASE quiz; CREATE DATABASE sms;"
      sudo docker cp /vagrant/reports/Database/reports.sql #{MYSQL_CONTAINER}:/reports.sql
      sudo docker cp /vagrant/quiz/database/quiz.sql #{MYSQL_CONTAINER}:/quiz.sql
      sudo docker cp /vagrant/sms/Database/sms.sql #{MYSQL_CONTAINER}:/sms.sql
      sudo docker exec #{MYSQL_CONTAINER} mysql -u root -p#{MYSQL_PASSWORD} -e "USE reports; SOURCE reports.sql; USE quiz; SOURCE quiz.sql; USE sms; SOURCE sms.sql;"
    SHELL
    # Sync the app folders with the master node
    config.vm.synced_folder "reports", "/home/vagrant/reports"
    config.vm.synced_folder "quiz", "/home/vagrant/quiz"
    config.vm.synced_folder "sms", "/home/vagrant/sms"
    # Copy the kubeconfig file to the current directory
    master.vm.provision "file", source: "/etc/rancher/k3s/k3s.yaml", destination: "kubeconfig"
  end
end
