# WP Cli 
This CLI Package Provides WP Developers To Replace Text Easily

## Installation
The preferred way to install this extension is through [Composer](http://getcomposer.org/download/).

To install **WP-Cli library**, simply:

    $ composer require gcommeuneidee/wp-cli-replacetext
    
## Replace Text Usage

### Replace text for all files inside a folder
```
$ ./vendor/bin/replacetext.bat -i text-to-search text-to-replace your-folder-path
```

### Update text for a file
```
$ ./vendor/bin/replacetext.bat -i text-to-search text-to-replace ./your-path/your-file.php
```

## CLI Arguments
| Argument | Description |
| -------- | ----------- |
| `-i` | if provided then changes will be saved in the same file where its updated if not it will provide the file output | 

---


<!-- START common-footer.mustache  -->
## 📝 Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

[Checkout CHANGELOG.md](https://github.com/gcommeuneidee/wp-cli-replacetext/blob/main/CHANGELOG.md)


## 🤝 Contributing
If you would like to help, please take a look at the list of [issues](https://github.com/gcommeuneidee/wp-cli-replacetext/issues/).


## 📜  License & Conduct
- [**GNU General Public License v3.0**](https://github.com/gcommeuneidee/wp-cli-replacetext/blob/main/LICENSE) © [G Comme Une Idée](https://www.gcommeuneidee.com)


## 📣 Feedback
- ⭐ This repository if this project helped you! :wink:
- Create An [🔧 Issue](https://github.com/gcommeuneidee/wp-cli-replacetext/issues/) if you need help / found a bug

---

<p align="center">
<i>Built With ♥ By <a href="https://twitter.com/relisiuol"  target="_blank" rel="noopener noreferrer">Louis Vedel</a> from <img src="https://upload.wikimedia.org/wikipedia/en/thumb/c/c3/Flag_of_France.svg/250px-Flag_of_France.svg.png" width="20px"/></i><br/>
</p>

---
