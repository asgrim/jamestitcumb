---
title: "Replacing My Comments section with Webmentions"
tags: [blog, comments, webmention, mastodon, bridgy]
---

I went down a bit of a rabbit recently. I've been slowly gaining control of my
own content, and one of the list to tackle was my old comments section. I
wanted something more open, and I'd heard from the community about
[Webmentions](https://www.w3.org/TR/webmention/), a W3C standard for mentioning
sites. I had heard this makes it possible for people to interact with my blog
via Mastodon, which makes things super simple.

It's in theory possible to make your own setup for this, but in the interest of
brevity, I signed up at [webmention.io](https://webmention.io/) to manage the
mentions. First up, adding an extra meta tag to indicate where metions should
be sent to:

```html
<link rel="webmention" href="https://webmention.io/www.jamestitcumb.com/webmention">
```

The next part was to integrate with the
[webmention.io API](https://github.com/aaronpk/webmention.io#api) to
periodically pull mentions and store them in Postgres, and display them on my
blog; that was the fairly straightforward bit.

Next bit was to set up [Bridgy](https://brid.gy/), a bridge that takes Mastodon
activity - replies, likes, and shares - and turns them into webmentions. In
order for Bridgy to pick up the activity, there's a bit of a chicken-and-egg
situation, so the order (whilst not ideal is):

 - publish the post on my site
 - write a Mastodon post
 - grab the Mastodon post URL, and add it to the blog with a `u-syndication`
   link that associates the Mastodon post to the blog post, and update the blog.

So, you end up with a link somewhere, e.g.:

```html
Like, share, or comment on this post via <a class="u-syndication" href="https://phpc.social/@asgrim/116849787641057613">Mastodon</a>.
```

Then once all published, Bridgy will find the Mastodon post and schedule it for
periodic crawls for likes, replies, and shares, and send them to the configured
webmentions endpoint (in my case, as I said, to webmention.io).

This was quite a learning journey, but has allowed me to use more open
technology, so definitely worth it IMO 😁️
