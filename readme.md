# Livestock - backend API
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)

Backend API for https://github.com/jankott123/Livestock-fe

## Project description

Backend solution for livestock managing. Developed with PHP and Nette framework. 


## How to run API 

To run this api: 

1. Create file **credentialsDb.neon** in folder **config**.
2. Insert following code with your PostgreSQL database **credentials**: 

```
nettrine.dbal:
	debug:
		panel: %debugMode%
	configuration:
	
	connection:
		driver: pdo_pgsql
		host: <host_name>
		user: <user>
		password: <password>
		dbname: <db_name>
		port: <port>
```

5. Create **.env** file in root directory
6. Insert **SECRET_KEY,SECRET_KEY2** for JWT authentication

```
PROJECT_ID = <project_id>
BUCKET_NAME = <bucket_name>
SECRET_KEY = <refresh_key>
SECRET_KEY2 = <access_key>
```
7. Database dump is in **db_livestock.txt**

