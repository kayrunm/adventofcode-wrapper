# Advent of Code wrapper

This is an Advent of Code solution wrapper built on Laravel Zero.

## Getting Started

### Valid years
You can change which years are valid challenge years by changing the `LOWEST_YEAR` and
`CURRENT_YEAR` environment variables. The `CURRENT_YEAR` is used as a fallback for any commands
that are run without a given year.

### API session
You will need to grab your `session` ID from the Advent of Code website. This
is used for downloading your unique input for each day's challenge. 

You can do this by logging into the [Advent of Code](https://adventofcode.com) website and then
copying the string stored in the cookie called `session`. Once you've got that copied, paste it
in your `.env` file under the `AOC_SESSION` key.

## Commands

### Make Solution

The `adventofcode make {day}` command creates a solution file and downloads your unique input for the
specified day's challenge. By default, it will retrieve challenges from the year you specified
in your `CURRENT_YEAR` environment variable. This can be set at runtime with the `--year` option.

For example, the following will create a solution for the 7th day in 2021:

```bash
$ php adventofcode make 7 --year=2021 
```

### Solutions

You can run the solutions for a given day or year with the `day` or `year` commands.

For example, the following will run the solution for the 7th day in 2021:

```bash
$ php adventofcode day 7 --year=2021
```

And the following will run all the available solutions for 2021.

```base
$ php adventofcode year 2021
```

## Refactoring

To aid with refactoring, you can set the answers for any solution by setting the `$answers`
property on any of your Solution classes.

Let's say the answers for part A and part B of a solution are `383` and `493`, you can set them
with the following code:

```php
protected array $answers = [
    'partOne' => 383,
    'partTwo' => 493,
];
```

By doing this, running any of your solution commands will display whether your solution has
the correct answer or not.
