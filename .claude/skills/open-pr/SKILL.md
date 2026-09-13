---
name: open-pr
description: Turn the current uncommitted diff into a pull request in one shot -- create a new branch off a base branch (default main), commit, push, and open a PR. Use this whenever the user says things like "open a PR for this", "ship this", "put this on a branch and PR it", "create a PR from these changes", "branch this off develop and PR it", or otherwise asks to turn the working-tree changes into a pull request.
---

# Open PR

Package the current working-tree diff into a pull request: branch, commit, push, open PR.

## 1. Read the invocation for overrides

The user's message invoking this skill may specify:

- **A base branch** (e.g. "off develop", "base: release/2.0"). If none is given, default to `main`.
- **Skip commit** (e.g. "don't commit", "just create the branch"). Default: commit.
- **Skip push** (e.g. "don't push", "keep it local"). Default: push.

If skip-commit is requested, there is nothing meaningful to push or open a PR for -- create the branch, stop there, and tell the user why the remaining steps were skipped.

## 2. Inspect the current state

Run in parallel:

- `git status` (uncommitted/untracked files)
- `git diff` and `git diff --staged` (the actual changes going into the PR)
- `git branch --show-current` (don't branch off a stale WIP branch by accident -- confirm with the user if the current branch already looks like a feature branch rather than the base)
- `git log <base>..HEAD --oneline` if the base branch differs from current, to see what's already ahead

If there is no diff at all (clean tree, nothing staged/unstaged, nothing ahead of base), stop and tell the user there's nothing to turn into a PR.

## 3. Create the branch

Branch from the resolved base branch (fetch/pull it first if a remote-tracking branch exists, so you're not branching from a stale local copy):

```
git checkout -b <branch-name> <base-branch>
```

Pick a short, descriptive kebab-case branch name from the diff's content (e.g. `fix/checkout-validation`, `feat/sail-docs`), prefixed by conventional type when it's clear (`feat/`, `fix/`, `chore/`, `refactor/`).

## 4. Commit (unless told not to)

Follow this repo's commit conventions -- check CLAUDE.md for language/format rules (e.g. this repo requires commit messages in English regardless of the conversation's language). Stage specific files by name (never a blanket `git add -A`/`git add .`); review `git status` after staging for anything that looks like a secret before committing. Write a concise message focused on _why_, and append whatever attribution line the current session's system reminder specifies for commits.

## 5. Push (unless told not to)

```
git push -u origin <branch-name>
```

## 6. Open the PR

Use `gh pr create` with a HEREDOC body (title under ~70 chars, a short Summary and Test plan section), targeting the resolved base branch, appending whatever attribution line the current session's system reminder specifies for PR descriptions. Return the PR URL to the user.

## Notes

- This performs visible, hard-to-reverse actions (pushing a branch, opening a PR). The user invoking this skill is the confirmation for _this_ run -- proceed through all requested steps without re-asking, but do stop and flag anything surprising (e.g. the resolved base branch doesn't exist, the working tree is dirty in a way that suggests unrelated in-progress work, or there's genuinely nothing to commit).
- If `main` (the default base) doesn't exist in this repo, say so and ask what base to use instead of silently guessing.
