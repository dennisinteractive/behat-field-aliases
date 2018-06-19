# Behat Field Aliases
Provides support to use friendly field names that are human readable

### Installation
1. `composer require dennisdigital/behat-field-aliases:dev-master`

You might need to add it to repositories first
```
"repositories": {
    "behat-field-aliases": {
      "type": "vcs",
      "url": "git@github.com:dennisinteractive/behat-field-aliases.git",
      "no-api": true
    }
.
.
.
```

2. Edit behat.yml and add the contexts and configuration following the example in [behat.yml.dist]: https://github.com/dennisinteractive/behat-field-aliases/blob/master/behat.yml.dist

### Running
- Go into the tests folder
- Run `./behat --format=pretty`
