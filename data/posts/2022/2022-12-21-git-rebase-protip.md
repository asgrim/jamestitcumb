---
title: "Git rebase pro-tip"
tags: [git, rebase]
---

I have lost count of the number of times I have referred myself to
[my own Tweet](https://twitter.com/asgrim/status/1524379580366266368) to remind myself how to "lift and shift" a
feature branch from one trunk to another. Therefore, I have decided to immortalise this content on my own blog!

Some organisations I see have multiple trunks, and for this example, I'll use a `production` and a `development`
branch. Let's say you have a branch called `feature`, which is based off `development`.

![diagram showing current git branch tree](/images/blog/git-rebase-current.jpg)

Given this current tree, you are asked to move your feature branch to the `production` branch, so the new tree should
look like this:

![diagram showing desired git branch tree](/images/blog/git-rebase-desired.jpg)

The right Git command for this is (with an optional `-i` to make an interactive rebase, which I highly recommend!):

```bash
git rebase -i --onto <new-trunk> <old-trunk> <your-branch>
```

So, in our example above, the command to run would be:

```bash
git rebase -i --onto production development feature
```

<!-- MARKETING -->
