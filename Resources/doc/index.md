# Getting Started With Team Bundle

## Prerequisites

## Installation

Installation is a quick 4 steps process:

1. Download QuefTeamBundle
2. Enable the Bundle
3. Configure your Teams
4. Configure the QuefTeamBundle

### 1. Install QuefTeamBundle
The preferred way to install this bundle is to rely on [Composer](http://getcomposer.org).
Just check on [Packagist](http://packagist.org/packages/quef/team-bundle) the version you want to install (in the following example, we used "dev-master") and add it to your `composer.json`:

``` js
{
    "require": {
        // ...
        "quef/team-bundle": "dev-master"
    }
}
```


### 2. Enable the bundle

Finally, enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Quef\TeamBundle\QuefTeamBundle(),
    );
}
```

### 3. Create your Teams

Now you need to configure your first team. Let’s assume you have a Store entity in your application and it has simple fields:

#### TeamInterface

#### TeamMemberInterface

#### TeamInviteInterface
