#!/bin/bash

source .env

url="${GITLAB_API_URL}/projects/${FRONTEND_PROJECT_ID}/packages/generic/production_build/${FRONTEND_VERSION}/build.tar.gz"
echo "$url"
mkdir -p build 
curl --header "PRIVATE-TOKEN: ${FRONTEND_PAT}" "$url" | tar zxf - || (echo "Did you provide a valid FRONTEND_PAT"; exit 1)

if [ $? -eq 0 ]; then
    cp build/index.html ../templates/react-init.html.php
fi
