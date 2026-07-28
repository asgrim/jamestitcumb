---
title: Visualise your Git tree on the CLI
tags: [git, git-log, tree, graph]
#mastodon: ...
---

I cut my teeth on source control with CVS, then Sourceforge, then Subversion,
until Git came along and absolutely took over source control. Over the years
I've tried various graphical Git tools, but I always felt more comfortable
using `git` commands directly on the CLI.

One of my favourite, and most powerful Git commands is this:

```shell
git log --graph --pretty=oneline --abbrev-commit --branches --decorate
```

I have this set up as an alias as I certainly can't remember those flags, but
what does it do? It renders the Git log of a repository, but as a graph with
lines showing ancestry. A very basic example might look like this:

```
*   b72d3ec (HEAD -> main) Merge branch 'another-test-branch'
|\  
| * da3cc72 (another-test-branch) Added a licence
* |   3b628ef Merge branch 'test-branch'
|\ \  
| |/  
|/|   
| * 008533e (test-branch) Added some punctuation
| * ba56be8 Added the letter A
|/  
* 1a15387 initial commit
```

This helps you visualise exactly what branches exist(ed), what was merged,
where they were merged from, and more. We can see here that both `test-branch`
and `another-test-branch` were both branched from `1a15387` (the "initial
commit"). We can see that `test-branch` was merged, and `another-test-branch`
was merged after.

As you can imagine, if you have lots of feature/bug branches, or multiple
trunks (e.g. `production` and `dev` - or even more if you use Git Flow). There
are a few key things that help towards keeping this visualisation - and
thus your Git history in general - nice and tidy, though:

### Rebase branches

A quite common strategy I see employed is to merge trunks into feature branches.
In my opinion, this can make a really messy Git history. Sure - it's quick and
easy, and you don't have to deal with potentially complex conflicts quite as
much. But using `git rebase` is really the gold standard here. It takes a bit
more care and attention about what changes are happening in the trunk, and how
your branch interacts with the changes, but I will frequently rebase my
branches to ensure as clean a merge as possible. Not everyone is confident with
`git rebase` though; and I can recommend [Pauline Vos' Git Legit](https://gitlegit.dev/)
training course for this, or that's certainly something I can help with training.

### Be more thoughtful with commit messages

Commit messages tell a story. Don't just commit "WIP" or "Fixed PR comments",
or "fixed CS". Your goal is to add context to the change; but not necessarily
to explain the change itself. `git show <commit>` will show the commit changes,
but decorating the commit with some context, for example, adding links to bug
reports, contextual research, or explaninig rationale behind changes, really
helps. When you commit, it doesn't just have to be a single line. You can add a
whole write-up if you really want! Take, for example,
[PIE commit 5c917354](https://github.com/php/pie/commit/5c917354a15479bd03984764565bdd16c4a777e3):

```
609: Re-enable windows pie.exe builds with VS22

Use windows-2022 which has VS22 still (windows-2025 moved to VC26)

https://github.blog/changelog/2026-02-05-github-actions-early-february-2026-updates/#windows-server-2025-with-visual-studio-2026-image-now-available-for-github-hosted-runners
```

I explained briefly what the change was in the first line (which shows up in
the history), but also added some context, and a link to a relevant resource to
the change.

### Merge branches with merge commits

GitHub offers three strategies for merges; merge commits, squash merges, or
rebase merging. Squash merges will take all the commits from the branch, and
squash them into a single commit which is applied onto the trunk. This - in my
opinion - is by far the worst. The key reason being; you lose all history.
Rebase merging is not so bad; you keep the history there, but you still lose
the sense of "this was branched here, and merged here" once it is merged.
Additionally, both rebase merging and squash merging completely lose the
original author's GPG commit signatures, which is becoming more important in
ensuring a healthy supply chain. For me, merge commits are the only way. This
is the traditional and default behaviour in GitHub, and if you're not using
GitHub, the equivalent is `git checkout <trunk> && git merge --no-ff <feature-branch>`.
This approach preserves carefully crafted commit history, preserves the author's
original approach and GPG signatures, and preserves the branch split and merge
history too.

## It's not compulsory, though...

All in all, the stuff above is indeed opinionated, but can help to be able to
visualise what has happened. I've helped countless teammates in the past, for
example to work out what happens when they lost track of a rebase and ended up
with duplicate commits, by using this `git log` alias. That's my superpower,
and now it's yours too :)
