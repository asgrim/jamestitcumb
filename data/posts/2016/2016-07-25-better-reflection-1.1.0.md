---
title: Better Reflection 1.1.0 released
tags: [php, reflection]
---

After a bit more hacking away, tinkering and violating all good programming practices, I'm pleased to announce the
release of [Better Reflection 1.1.0](https://github.com/Roave/BetterReflection/releases/tag/1.1.0), with *shiny new
features* including the highly anticipated monkey patching abilities I've promised at my talk at the
[Dutch PHP Conference](https://joind.in/talk/eb95d) this year. Here's a taster of the main things we've added:

 - Ability to modify function, method and class structure (basic monkey patching)
 - Ability to replace the body of a function or method
 - Updated documentation
 - PHP 7 compatibility
 - Some PHP 7.1 compatibility (more features will come in a future version!)
 - Implemented ::class constant resolution
 - `FindReflectionOnLine` helper (look up code unit by filename and line number)
 - Various other improvements and bugfixes

**The future...**

We'd really like to see some feedback on how you folks are using the library, what you find useful, what you think would
be a great addition and so on. Right now, the 1.2.0 release is planned to have:

 * PHP 7.1 compatibility (will require PhpParser 3.0 which is currently in beta)
 * Possibly some dynamic autoload handling for easier monkey patching
 * More bug fixes and reflection compatibility
 * Other stuff you request!

**Thank you...**

Thank you to the contributors for this release!

 * [ocramius](https://github.com/ocramius)
 * [AydinHassan](https://github.com/AydinHassan)
 * [MarkRedeman](https://github.com/MarkRedeman)
 * [dantleech](https://github.com/dantleech)
 * [AndrewCarterUK](https://github.com/AndrewCarterUK)

Go forth and enjoy the new Roave offering of [Better Reflection](https://github.com/Roave/BetterReflection)!
