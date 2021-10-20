# Frontend Build Process
## Building
The repository with the frontend code (currently needs to be on gitlab) needs to have a pipeline that uploads the build directory to the package registry as a `build.tar.gz` file.
This needs to be done on every tag push.

## Fetching

The following steps are needed to get the nessesary frontend files.
1. cd to this folder (`/frontend`)
1. `cp .env.dist .env`
1. Enter the values in the .env file:
    1. `FRONTEND_PAT` - A access token for the repository with the frontend code.
    1. `FRONTEND_PROJECT_ID` - The gitlab project id.
    1. `GITLAB_API_URL` - Usually does not need to be changed.
    1. `FRONTEND_VERSION` - The name of the tag in the frontend repository you want to fetch.
1. `./make-frontend.sh` to get all the files in the correct place and you are done. 
1. Change the `FRONTEND_VERSION` in the .env file and call `make-frontend.sh` every time you want to update your frontend code
