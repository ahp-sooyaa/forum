# Forum

This is a laravel project built by following the screencast series of laracasts. This is for my learning purpose. Learning by doing is good :).

If you want to know about the screencast, it is [Lets build a forum with laravel and TDD](https://laracasts.com/series/lets-build-a-forum-with-laravel). It is good serie but it is published at 2017 and now it is archieved. So my repository come up with different things - laravel 8, tailwind, vue instantSearch V3 etc.

And if you wondering about my ui is similar with laracasts, i referenced laracasts ui but not all the same.

## Built with

- [Laravel](https://laravel.com/docs/routing) -  version 8.

- [Vue](https://laravel.com/docs/container) - version 2.

- [Tailwind](https://laravel.com/docs/session) - version 2.

- [Redis](https://laravel.com/docs/session) - is for remembering the view count and trending threads.

- [Algolia](https://laravel.com/docs/session) - is for search function (vue instantSearch V3).

- [Recaptcha]() - is for spam protection.

- [Gravatar]()

## Features

- create threads.
- edit threads.
- create reply.
- edit reply.
- thread subscription
- dark mode.
- filtering by popularity, unanswered and user own threads.
- locking every threads by administrator.
- instantSearch by algolia

## Screenshots

Light mode
![light mode](/Doc/lightmode.png)

Dark mode
![dark mode](/Doc/darkmode.png)

You can see all of the screenshots at https://imgur.com/a/Jbnwj

## Installation

Setting up in local environment:

```
git clone https://github.com/ahp-sooyaa/forum.git
cd forum
cp .env.example .env
composer install
php artisan serve
```

Now basic setup is finished. You can go to welcome page via link in ```php artisan serve```. If you already set up valet, clone repo inside your valet park dir and access via https://forum.test.

### Algolia & Recaptcha
Set up algolia & recaptcha in .env file

```
RECAPTCHA_SITEKEY=6LcEHLYaAAAAAGLAYvJ_TeGR3y0FjT0AbLjGIHvj
RECAPTCHA_SECRET=6LcEHLYaAAAAAO6YUT_46b8tgWKRwmHWR2oBeS1Q

ALGOLIA_APP_ID=yourAlgoliaAppID
ALGOLIA_SECRET=yourAlgoliaAppSecretKey
```

### Database
Set up database in .env file

```
DB_DATABASE=forum
DB_USERNAME=root
DB_PASSWORD=
```

and then seed the data into database. For testing & seeding, i use model factory.
```
php artisan migrate
php aritsan tinker
>>>Thread::factory(30)->create();
```

### Email verification
This project uses email verification as a protection of spam so you need to set up mailing configuration in the .env file. If you use mailtrap, set the your mailtrap keys.
```
MAIL_USERNAME=yourMailtrapInboxCrendentials
MAIL_PASSWORD=yourMailtrapInboxCrendentials
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=forum@email.com (or asyoulike)
```

## Tests

Running All Tests:
```
php artisan test
```

Running Specific Tests:
```
php artisan test --filter testName
```

You can make alias in terminal for short command such as 
```
alias p="php artisan test"
alias pf="php artisan test --filter testName"
```

## Contributing

Do not hesitate to contribute to the project by adapting or adding features ! Bug reports or pull requests are welcome.

## Security Vulnerabilities, Bugs or something else

If you discover a security vulnerability, bugs or something wrong within Forum, please send an e-mail to me via apaing894@gmail.com . 

## License

This project is released under the MIT license.
