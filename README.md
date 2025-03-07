### Hexlet tests and linter status:
[![Actions Status](https://github.com/rnik82/php-project-48/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/rnik82/php-project-48/actions)
[![hexlet-check](https://github.com/rnik82/php-project-48/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/rnik82/php-project-48/actions/workflows/hexlet-check.yml)
<a href="https://codeclimate.com/github/rnik82/php-project-48/maintainability"><img src="https://api.codeclimate.com/v1/badges/d784e95c4054c8f86da4/maintainability" /></a>
<a href="https://codeclimate.com/github/rnik82/php-project-48/test_coverage"><img src="https://api.codeclimate.com/v1/badges/d784e95c4054c8f86da4/test_coverage" /></a>

## Gendiff (Difference Calculator)

### About the Project:
    composer require global hexlet/code
 
Difference Calculator is a program that determines the difference between two data structures. This is a popular problem,
and there are many online services available to solve it, such as: http://www.jsondiff.com/. A similar mechanism is used
when displaying test results or automatically tracking changes in configuration files.

Features of the Utility:
- Support for different input formats: YAML and JSON
- Report generation in plain text, stylish, and JSON formats

## Requirements

- Linux
- PHP 8.3
- Composer

## Installation Instructions

Follow these steps sequentially:

1. Clone the repository:

    ```bash
    git clone git@github.com:rnik82/gendiff.git difference-calculator
    ```

2. Navigate to the project directory:
    
    ```bash
    cd difference-calculator
    ```
    
3. Install dependencies:
    
    ```bash
    make install
    ```
    
4. Grant execute permissions to the files in the bin directory:
    
    ```bash
    chmod +x ./bin/*
    ```

## Running the Program

Commands to run the program:

- `./bin/gendiff -h` — display help.
- `./bin/gendiff --format stylish file1.json file2.json` — compare JSON files in stylish format
- `./bin/gendiff --format stylish file1.yml file2.yml` — compare YAML files in stylish format
- `./bin/gendiff --format plain file1.json file2.json` — compare JSON files in plain format
- `./bin/gendiff --format plain file1.yml file2.yml` — compare YAML files in plain format
- `./bin/gendiff --format json file1.json file2.json` — compare JSON files in JSON format
- `./bin/gendiff --format json file1.yml file2.yml` — compare YAML files in JSON format
- `./bin/gendiff file1.json file2.json` — if no format is specified, stylish will be used by default

## Demonstration

#### Example of comparing JSON files
[![asciicast](https://asciinema.org/a/674675.svg)](https://asciinema.org/a/674675)

#### Example of comparing YAML (YML) files
[![asciicast](https://asciinema.org/a/675011.svg)](https://asciinema.org/a/675011)

#### Example of comparing JSON and YAML files with default stylish format
[![asciicast](https://asciinema.org/a/675493.svg)](https://asciinema.org/a/675493)

#### Example of comparing JSON and YAML files with plain format
[![asciicast](https://asciinema.org/a/675642.svg)](https://asciinema.org/a/675642)

#### Example of comparing JSON and YAML files with json format
[![asciicast](https://asciinema.org/a/675901.svg)](https://asciinema.org/a/675901)
