# DriftPHP Skeleton

Welcome to the skeleton of DriftPHP. In this small repository you will find an
extraordinary way of starting using DriftPHP and ReactPHP in your projects. Just
install it, load dependencies, and you will be ready to start building fast and
insane applications on top of Symfony and ReactPHP components.

> You can check our [DriftPHP Demo](https://github.com/driftphp/demo) based in
> this skeleton.

Are you ready?  
Let's start!

- [Motivations](#motivations)
- [Installing the skeleton](#installing-the-skeleton)
- [Previous concepts](#previous-concepts)
    - [Symfony Kernel](#symfony-kernel)
    - [HTTP Server](#http-server)
    - [ReactPHP](#reactphp)
- [About the architecture](#about-the-architecture)
    - [The HTTP Server](#about-the-architecture)
    - [The HTTP Kernel](#about-the-architecture)
- [Your first controller](#your-first-controller)
- [Your first domain service](#your-first-domain-service)
- [Your first console command](#your-first-console-command)
- [Libraries](#libraries)

## Motivations

This framework is an exercise of mixing the best of two excellent worlds if we
talk about PHP. On one hand we have Symfony, a collection of PHP components with
a large usage around the PHP ecosystem. On top of them, the Symfony framework,
with a well known project architecture. On the other hand, we find ReactPHP, a
PHP library on top of Promises and an EventLoop, that provides a really easy
non-blocking way of managing Requests using a single PHP thread.

DriftPHP framework follow the Symfony structure, the same Request/Response 
paradigm and the same Kernel bases, but turning all the process non-blocking by
using ReactPHP promises and event loop.

If you're used to working with Symfony skeleton, DriftPHP will seem a bit
familiar then. You will recognise the kernel (a different one, but in fact,
almost the same), the way Controllers and Commands are defined, called and used,
and the way we define services using Dependency Injection (yes, you can still
use autowiring here...).

## Installing the skeleton

In order to install a new skeleton for the project, just clone this repository
in your localhost. Of course, you will need `composer` installed in
your host

```bash
composer create-project -sdev drift/skeleton 
```

In this skeleton you will find all the necessary to create a basic ReactPHP
based service, excluding infrastructure libraries like Redis or Mysql, and
excluding all third party libraries you'd need. Make sure you add these
dependencies in the `composer.json` file.

## Previous concepts

Before start digging into DriftPHP, is important to understand a little bit what
concepts are you going to use, or even discover, in this package. Each topic is
strongly related to the development of any application on top of DriftPHP, so
make sure you understand each one of them. In the future, all these topics will
be packed into a new and important chapter of the documentation is being built
at this moment.

### Symfony Kernel

Have you ever thought what the Symfony Kernel is really about? In fact, we could
say that is one of the most important elements of the whole Symfony ecosystem,
and we would be wrong if we say that is not the most core one. But what is it
really about? Let's reduce its complexity into 1 simple bullet.

- Given a Request, give me a Response

That's it. Having a Request object, properly hydrated from the magic PHP
variables (`$_GET`, `$_POST`, `$_SERVER` ...), the kernel has one single (and
important) job. Guess everything is needed to return a Response. In order to
make that job, the Kernel uses an event dispatcher to dispatch some events. All
these events are properly documented in the Symfony documentation. And because
of these events and some subscribers included in the `FrameworkBundle` package,
we can match a route, guess the proper Controller instance and call the
Controller method, depending on our configuration.

Once we are in the controller, and if we don't have injected the Container
under any circumstance, then we can say that the Framework job is properly
finished. This is what we can call our domain  

**Welcome to your domain**

So on one side of the framework (probably in your Symfony `/public/index.php`
file) you will find a line where the Kernel handles a Request and expects a
Response.

```php
$response = $kernel->handle($request);
```

Each time you see something like that, take in account that your server will be
blocked from the function call, until the result is returned. This is what we
can define as a blocking operation. If the whole operations lasts 10 seconds,
during 10 seconds nothing will be doable in this PHP thread (yes. 10 seconds.
A slow Elasticsearch operation or MYSql operation could last something like
that, at least, could be possible, right?)

We will change that.
Keep reading.

### HTTP Server

Now remember one of your Symfony projects. Remember about the Apache or Nginx
configuration, then remember about the PHP-FPM, about how to link all together,
about deploying it on docker...

Have you ever thought about what happens there? I'm going to show you a small
bullet list about what's going on.

- Your Nginx takes the HTTP Request.
- The Http Request is passed to PHP-FPM and is interpreted by PHP-FPM.
- Interpreted means, basically, that your `public/index.php` file will be
executed.
- One kernel is instanced and a new Symfony Request is created..
- The Symfony Request is handled and a new Response is generated
- The Response is passed through the Nginx and returned to the final user.

Now, let's ask ourselves a simple question. How many requests do we have per day
in our project? Or even more important. How long it takes to generate a kernel, 
build all the needed services (**all**) once and again, and return the result?

Well. The answer is pretty easy. Depends on how much performance do you really
need. If you have a 1000 requests/day blog, then you will be probably okay with
this stack, but what if you have millions per hour? How important in that case
can be a simple millisecond?

Can we solve this?
Yes. We will solve this.
Keep reading.

### ReactPHP

Since some years ago, PHP turned a bit more interesting with the implementation
of Promises from ReactPHP. The language is exactly the same, PHP, but the unique
difference between the regular PHP usage and the ReactPHP is that each time your
project uses the infrastructure layer (Filesystem, Redis, Mysql) everything is
returned eventually.

About the fundamental problem of using ReactPHP Promises in your regular Symfony
application you can find a little bit more information on these links.

- https://medium.com/@apisearch/symfony-and-reactphp-series-82082167f6fb
- https://es.slideshare.net/MarcMorera/when-symfony-met-promises-167235900

And some links about ReactPHP

- https://reactphp.org
- https://github.com/reactphp

In few words. You cannot use Promises in Symfony, basically because the kernel
is blocking. Having a Request, wait for the Response. Nothing can be `eventual`
here, so even if you use Promises, at the end, you will have to wait for the
response because the Controller **have to** return a Response instance.

Can we solve this?
Again. Yes.
Keep reading.

## About the Architecture

So, having 3 small problems in front of us, and with the big promise to solve
this situation, here you have the two main packages that this framework offers
to the user. All of them can be used separately, but all together work as is
expected.

- [HTTP Kernel](https://github.com/driftphp/http-kernel)

Simple. Overwrites the regular and blocking Symfony Kernel to a new one, 
inspired by the original, but adapted to work on top of Promises. So everything
here will be non-blocking, and everything will happen *eventually*.

Check the documentation about the small changes you need in your project to use
this kernel. Are pretty small, but completely necessary if you want to start
using Promises in your domain.

- In your Controller, now you will have to return a Promise instead of a
Response
- Your event listeners will have to be packed inside a Promise as well.
Remember, all will happen eventually.

First solved problem

- [HTTP Server](https://github.com/driftphp/server)

Forget about PHP-FPM, about Nginx, Apache or any other external servers. Forget
about them because you will not need them anymore. With this new server, you
will be able to connect your application to a socket directly with no
intermediaries.

And guess what.  
Your kernel will be created once, and only once.  
That means that the first requests will last as long as all your current
requests, but the next ones... well, you won't believe the numbers.

- [Skeleton](https://github.com/driftphp/skeleton)

The skeleton is very simple and basic. Instead of having multiple and different
ways of doing a simple thing, we have defined a unique way of doing everything.
First of all, the main app configuration (Kernel, routes, services and 
bootstrap) is included in the main `Drift/` folder.

You can place all your services wherever you want, but we encourage you to use a
simple and useful architecture based on layers.

```yaml
Drift/ - All your Drift configuration
Controller/ - Your controllers. No logic here
Console/ - Your console commands. No logic here
Domain/ - Your domain. Only your domain
Redis/ - Your Redis adapters
Mysql/ - Your Mysql adapters
```

## Your first Controller

Now that we have this skeleton installed, let's make our first Controller. This
controller will be pretty simple. Just return a 
