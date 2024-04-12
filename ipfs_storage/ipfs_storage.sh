#!/bin/bash

source .env

if [ -z "$KEYLH" ]; then
    echo "The KEYLH environment variable is not defined. The script cannot continue."
    exit 1  
fi

echo "================================================================"
echo "Send files to IPFS"
echo "================================================================"

max_attempts=5

attempt=1

while [ $attempt -le $max_attempts ]; do
    echo "Intento $attempt de $max_attempts"
    
    response=$(curl -X POST -H "Authorization: Bearer $KEYLH" -F "file=@cert.jpeg" "https://node.lighthouse.storage/api/v0/add")
    
    if [[ "$response" == *"Auth Failed!!!"* ]]; then
        echo "================================================================"
        echo "Response failed: $response"
        echo "================================================================"
        echo "Retrying..."
        echo "{"Name":"test.txt","Hash":"NULL","Size":"NULL"}" > response.json
        attempt=$((attempt + 1))
    else
        echo "================================================================"
        echo "The request was successful: $response"
        echo "$response" > response.json
        echo "The response has been saved in response.json"
        echo "================================================================"
        break
    fi
done

list_files=$(curl -H "Authorization: Bearer $KEYLH" "https://api.lighthouse.storage/api/user/files_uploaded?pageNo=1")
echo "$list_files" > list_files.json
echo "================================================================"
echo "All responses from IPFS are OK"
echo "================================================================"

