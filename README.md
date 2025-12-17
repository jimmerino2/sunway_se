Last Updated At: 17/12/2025

_How to setup the project_

1. Ensure that the root folder's name is software_engineering, and that it is placed inside the /htdocs
2. Go to phpMyAdmin, create the database se_project
3. Go to /backend/scripts, find the latest script (20251207.sql) and run it in the created database
4. In the project root, update the .env file's DB_USER and DB_PASSWORD to your own settings (We know we shouldn't push .env to repo, but there's nothing sensitive there)

_How to access pages_

1. Customer Page: http://localhost/software_engineering/frontend/customer?table_no=1
   Note: Update the table number by changing the table_no GET parameter (We should probably encrypt that)

2. Staff Portlal: http://localhost/software_engineering/frontend/admin/
   Note: Admin credentials are admin@gmail.com, admin

_Extra Notes_

1. If any other questions regarding the setup, feel free to contact +60162211236 (Lam Way Hou) for help, thank you!
