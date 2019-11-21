# DriftPHP Skeleton

Welcome to the skeleton of DriftPHP. In this small repository you will find an
extraordinary way of starting using DriftPHP and ReactPHP in your projects. Just
install it, load dependencies, and you will be ready to start building fast and
insane applications on top of Symfony and ReactPHP components.

Are you ready?  
Let's start!

- [Motivations](#motivations)
- [Installing the skeleton](#installing-the-skeleton)
- [About the architecture](#about-the-architecture)
- [The server](#the-server)
- [The kernel](#the-kernel)
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
composer create-project drift/skeleton 
```