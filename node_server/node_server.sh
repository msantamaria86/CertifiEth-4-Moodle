#!/bin/bash

echo "================================================================"
echo "Installing node local server..."
echo "================================================================"

sudo apt-get -y update
curl -sL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs
sudo apt-get install -y npm
sudo apt-get install -y git
sudo npm install --global yarn

git clone https://github.com/salviega/certifieth-4-moodle-backend-nestjs.git
cd certifieth-4-moodle-backend-nestjs/
cp ../.env .env

curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.35.3/install.sh | bash

nvm install 18.17
nvm use 18.17
source ~/.bashrc

eport NVM_DIR="$HOME/.nvm"

yarn install
yarn start:dev

sleep 20

echo "================================================================"
echo "Node server online in port 3030"
echo "================================================================"

response=$(curl -X 'GET' 'http://localhost:3000/' -H 'accept: application/json')
echo $response

if [ "$response" = "Attestation backend is running! 🎈" ]; then
    echo "Server online in port 3030"
else
    echo "ERROR: Fail install node server"
fi
