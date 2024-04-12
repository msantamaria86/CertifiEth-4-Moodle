#!/bin/bash
source .env:
echo "================================================================";
echo "Send files to IPFS";
echo "================================================================";
echo $KEYLH;
response=$(curl -X POST -H "Authorization: Bearer $KEYLH" -F "file=@test.txt" "https://node.lighthouse.storage/api/v0/add");
if [[ "$response" == *"Auth Failed!!!"* ]]; then
    echo "================================================================";
    echo "Response failed: $response";
    echo "================================================================";
else
    echo "================================================================";
    echo "La petición fue exitosa: $response";
    echo "================================================================";
fi;