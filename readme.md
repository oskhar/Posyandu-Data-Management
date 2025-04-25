# 🚀 init-repo-template

A complete, professional, and opinionated GitHub repository template designed to boost **consistency**, enhance **collaboration**, and support **scalable open-source** or private projects.

> 📦 Ready-to-clone setup for teams who care about quality, clarity, and developer experience.

## 🔥 Why use `init-repo-template`?

If you're tired of:

- inconsistent commit messages,
- undocumented contribution flow,
- messy collaboration practices,
- or setting up the same configs over and over again...

This repo is for you.

✅ **Built to be reused** — Just clone, customize, and start coding.

✅ **Optimized for collaboration** — Complete with interactive commit flow via Commitizen and a powerful `collaboration_guide.md`.

✅ **Zero Node.js dependency requirement** — Works well even if your project isn’t JavaScript-based.

## ✨ Features

- 📄 Predefined `.czrc` for consistent commit messages via Commitizen
- 🧭 Clear [Collaboration Guide](collaboration_guide.md)
- 📝 Semantic versioning & commit conventions (Conventional Commits)
- 🛠️ GitHub-friendly structure with `.github` support
- ⚡ Clean and modular template to scale with your team

## 🧑‍💻 Getting Started

### 1. Clone this template

```bash
git clone https://github.com/your-username/init-repo-template.git your-project-name
cd your-project-name
```

### 2. Configure Git & Collaboration Tools

- Make sure you read the [📘 `collaboration_guide.md`](collaboration_guide.md).
- It includes how to:
  - Set up and use Commitizen with `.czrc`
  - Follow the branching and PR workflow
  - Keep documentation and changelogs clean

### 3. Initialize your repo

```bash
git init
git remote add origin <your-new-repo-url>
npm install -g commitizen cz-git  # or cz-conventional-changelog if preferred
```

> 💡 Already includes `.czrc` — you're ready to use `git cz` right away.

## 🧠 What is `.czrc`?

`.czrc` is a configuration file for [Commitizen](https://commitizen-tools.github.io/commitizen/). It defines how commit messages are written and which adapter to use.

We use it to:

- Maintain a **clean Git history**
- Enable **automated changelog generation**
- Improve **team communication** via clear commits

To commit using Commitizen:

```bash
git add .
git cz
```

And follow the interactive prompt.

## 🤝 How to Collaborate

Please **always refer to** [`collaboration_guide.md`](collaboration_guide.md) before pushing or opening a pull request. It explains:

- How we write commits
- How to open PRs
- Branch naming
- Code review etiquette

> ⛔ Don't commit directly to `main` unless you're doing initial setup.

## 💡 Recommended Use Cases

- Open-source project templates
- Internal company repositories
- Bootstrapping monorepos
- Teaching good Git practices to teams

## 🔍 SEO Tags & Keywords

> _init repo template_, _github repo starter_, _professional collaboration guide_, _conventional commit template_, _czrc guide without nodejs_, _interactive git commit convention_, _developer friendly repo structure_, _semantic commit bootstrap_

## 📬 Questions or Feedback?

Feel free to open an issue or start a discussion. This template evolves as more teams and individuals use it. Contributions are welcome!

## 🪪 License

MIT — use it freely, modify it proudly.

## 🧩 Tip

Want to see it in action? Clone this template into your own repo and make your first contribution using:

```bash
git cz
```

You'll **feel the difference** in how structured and efficient your repo becomes 💡
