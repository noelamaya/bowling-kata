# Bowling Game Kata
## Description

Kata based on [Bowling Game Kata](https://kata-log.rocks/bowling-game-kata)

## Installation

The kata uses:

- [PHP 8.1+](https://www.php.net/downloads.php)
- [Composer](https://getcomposer.org)

Recommended:

- [Git](https://git-scm.com/downloads)

Clone the repository:

```sh
git clone git@github.com:noelamaya/bowling-kata.git
```

or

```shell script
git clone https://github.com/noelamaya/bowling-kata.git
```

Install all the dependencies using composer:

```shell script
composer install
```

## Dependencies

The kata uses composer to install:

- [PHPUnit](https://phpunit.de/) v10, which requires PHP 8.1+


## Testing

PHPUnit is pre-configured to run tests. PHPUnit can be run using a composer script. To run the unit tests, from the
root of the kata run:

```shell script
composer test
```

## Run from docker

A shell script to start docker has been provided:

```shell
test.sh
```

## Bowling Game
### Rules
The game consists of 10 frames. In each frame the player has two rolls to knock down 10 pins. The score for the frame is the total number of pins knocked down, plus bonuses for strikes and spares.

A spare is when the player knocks down all 10 pins in two rolls. The bonus for that frame is the number of pins knocked down by the next roll.

A strike is when the player knocks down all 10 pins on his first roll. The frame is then completed with a single roll. The bonus for that frame is the value of the next two rolls.

In the tenth frame a player who rolls a spare or strike is allowed to roll the extra balls to complete the frame. However no more than three balls can be rolled in tenth frame.

### Requirements
Write a class `Game` that has two methods:

1. `void roll(int)` is called each time the player rolls a ball. The argument is the number of pins knocked down.
2. `int score()` returns the total score for that game.
