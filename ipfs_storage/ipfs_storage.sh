#!/bin/bash

KEYLH='d9a844e4.7330e8aac6c943779b4f036467dff4b7'

if [ -z "$KEYLH" ]; then
echo "The KEYLH environment variable is no:t defined. The script cannot continue."
exit 1
fi

# Verificar si se proporcionó un nombre de archivo como argumento
if [ $# -ne 1 ]; then
echo "Usage: $0 <file_name>"
exit 1
fi

file_name=$1
file_name_without_extension=$(echo "$file_name" | sed 's/\.[^.]*$//')

echo "================================================================"
echo "Send files to IPFS"
echo "================================================================"

max_attempts=5

attempt=1

while [ $attempt -le $max_attempts ]; do
echo "Attempt $attempt of $max_attempts"
response=$(curl -X POST -H "Authorization: Bearer $KEYLH" -F "file=@/var/www/html/moodle/mod/certifieth/ipfs_storage/$file_name" "https://node.lighthouse.storage/api/v0/add")
if [[ "$response" == *"Auth Failed!!!"* ]]; then
echo "================================================================"
echo "Response failed: $response"
echo "================================================================"
echo "Retrying..."
echo "{"Name":"test.txt","Hash":"NULL","Size":"NULL"}" > /var/www/html/moodle/mod/certifieth/ipfs_storage/response.json
attempt=$((attempt + 1))
else
echo "================================================================"
echo "The request was successful: $response"
echo "$response" > /var/www/html/moodle/mod/certifieth/ipfs_storage/$file_name_without_extension.json
echo "The response has been saved in response.json"
echo "================================================================"
break
fi
done

list_files=$(curl -H "Authorization: Bearer $KEYLH" "https://api.lighthouse.storage/api/user/files_uploaded?pageNo=1")
echo "$list_files" > /var/www/html/moodle/mod/certifieth/ipfs_storage/list_files.json
echo "================================================================"
echo "All responses from IPFS are OK"
echo "================================================================"

