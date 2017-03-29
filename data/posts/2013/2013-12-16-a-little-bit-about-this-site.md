---
title: A Little Bit About This Site
tags: [php]
---
If you're a regular "follower" of whatever I do, firstly, thanks. Secondly, you might've noticed that my old site at [asgrim.com](http://www.asgrim.com/) has completely vanished, and now forwards to this site. I had been wanting to do it for quite some time, but I just never got around to doing it. However, a couple of weeks ago, I finally did it, in a rather haphazard and careless way, mainly because I did it in just an evening whilst I was watching TV or something.

My new website is really quite simple. It is based on [Silex](http://silex.sensiolabs.org/), with [herrera-io/silex-template](https://packagist.org/packages/herrera-io/silex-template) (a PHP templating engine for Silex), and the blog is not WordPress any more - it's just Markdown files rendered using [michelf/php-markdown](https://github.com/michelf/php-markdown). I've since added [Disqus](http://disqus.com/) comments to allow a bit of discussion, should anyone feel the need to.

*Why have I done this?* You might ask. Well, I got fed up with the insecurity of WordPress. I discovered that multiple WordPress sites (all regularly kept up to date) had been hacked on my server. None of my other applications had been hacked, just the WordPress sites. So I did away with it. Gone! Right now, I can edit my whole website using [GitHub](https://github.com/). I just write a [Markdown](http://daringfireball.net/projects/markdown/) file in the posts folder of my site, and add it to the `posts.php` file, and *poof!* it appears on the website. I'm using databases less and less to do things, and this is just one example; why deal with the overheads and hassle of a database just to store text blobs, when you could easily just load them up from a `.md` flat file?

I'm sure there's plenty of improvements that I could make, and I'm sure when I find time I'll make them. For example, I know there is no RSS feed available of posts, something which I plan to do in the future. Any comments or ideas would be more than welcome in the comments below :)
