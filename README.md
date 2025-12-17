<!-- 

Last Updated At: 17/12/2025

_How to setup the project_

1. Ensure that the root folder's name is software_engineering, and that it is placed inside the /htdocs
2. Go to phpMyAdmin, create the database se_project
3. Go to /backend/scripts, find the latest script and run it in the created database
4. In the project root, update the .env file's DB_USER and DB_PASSWORD to your own settings (We know we shouldn't push .env to repo, but there's nothing sensitive there)

_How to access pages_

1. Customer Page: http://localhost/software_engineering/frontend/customer 
   Note: Default is table 1 or scan the qr code on local device to open other tables ,Qr codes for each table is provided in the qr_code folder 

2. Staff Portal: http://localhost/software_engineering/frontend/admin/
   Note: Admin credentials listed below for login

3. Default accounts = [
  {
    role: "Admin",
    Username: "admin",
    email: "admin@gmail.com",
    Password: "admin1234"
  },
  {
    role: "Cook",
    Username: "cook",
    email: "cook@gmail.com",
    Password: "cook1234"
  },
  {
    role: "Cashier",
    Username: "cashier",
    email: "cashier@gmail.com",
    Password: "cashier1234"
  }

  Deactivated accounts [
  {
    role: "Cook",
    Username: "tester",
    email: "tester@gmail.com",
    Password: "cashier1234"
   }
  ]

4. Create new account for Staff portal, please use admin credentials as authentication.

_Extra Notes_

1. If any other questions regarding the setup, feel free to contact +60162211236 (Lam Way Hou) or +60146422045 (ujjayraj) for help, thank you!
2. If anything breaks ,it may be error during setup such so please check configuration of files

-->
