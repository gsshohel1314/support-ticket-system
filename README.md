## Support Ticket System

Project running instruction:

- Install Composer Dependencies => composer install.
- Create a copy of your .env file => cp .env.example .env
- Create an empty database and connect it with .env file.
- set QUEUE_CONNECTION=database because I used the Laravel job to send mail.
- Set up mail information in .env file like mailtrap or others.
- Migrate the database => php artisan migrate

Credentials:

- Admin login URL: base_url/admin
- Admin login credentials: Email: admin@gmail.com and Password: 12345678
- Customer login URL: base_url/login
- Customer register URL: base_url/register

Keep the Queue running:

- php artisan queue:listen

Thank You.
