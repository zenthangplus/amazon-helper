# Amazon order Helper
Simple library help customer to calculate gross price for each orders.

Formulas:
+ Gross price = `item price 1 + item price 2 + ...`
+ Item price = `amazon price + shipping fee`
+ Shipping fee = `max (fee by weight, fee by dimensions)`
+ Fee by weight = `product weight * weight coefficient`
+ Fee by dimension = `width * height * depth * dimension coefficient`

Example coefficients:
+ Weight coefficient: `$11/kg`
+ Dimension coefficient: `$5/m3`

## Install
First, make sure your machine or server are installed PHP with minimum version `7.0`.

An important tool to building the project is [Composer](https://getcomposer.org/).

Follow the steps below to install:
1. Clone this project to your machine or server.
2. Run `composer install` to install all packages required.
3. Access `/examples` to view examples.
4. Done!
