# Acme Widget Co Sales System

This is a proof of concept for Acme Widget Co's new sales system implemented in PHP using the Strategy Design Pattern.

## Table of Contents

- [Overview](#overview)
- [Requirements](#requirements)
- [Project Structure](#project-structure)
- [Installation](#installation)
- [Running Tests](#running-tests)
- [Static Analysis](#static-analysis)
- [Docker](#docker)
- [Usage](#usage)
- [Example Outputs](#example-outputs)

## Overview

The project is designed to simulate a sales system for Acme Widget Co. It includes:
- Product catalog management
- Basket management with pricing strategies
- Delivery charge calculations
- Special offers

## Requirements

- PHP 8.3
- Composer
- Docker
- Docker Compose

## Project Structure
    widget/
    ├── src/
    │ ├── Basket.php
    │ ├── Contracts/
    │ │ ├── DeliveryStrategy.php
    │ │ └── PricingStrategy.php
    │ ├── Models/
    │ │ ├── Catalog.php
    │ │ └── Product.php
    │ ├── StandardDeliveryStrategy.php
    │ └── StandardPricingStrategy.php
    ├── tests/
    │ └── BasketTest.php
    ├── Dockerfile
    ├── docker-compose.yml
    ├── composer.json
    └── phpunit.xml


## Installation

1. **Clone the repository**:
    ```bash
    git@github.com:donphelix/basketwidget.git
    cd widget
    ```

2. **Install dependencies**:
    ```bash
    composer install
    ```

## Running Tests

1. **Run PHPUnit tests**:
    ```bash
    vendor/bin/phpunit --configuration phpunit.xml
    ```

## Static Analysis

1. **Run PHPStan**:
    ```bash
    vendor/bin/phpstan analyse
    ```

## Docker

1. **Build and run Docker containers**:
    ```bash
    docker-compose up --build
    ```

## Usage

The project includes the following classes:

- **Product**: Represents a product in the catalog.
- **Catalog**: Manages a collection of products.
- **Basket**: Manages products added to the basket and calculates the total cost.
- **StandardPricingStrategy**: Implements pricing rules.
- **StandardDeliveryStrategy**: Implements delivery charge rules.

### Example Usage

```php
use Donphelix\Widget\Models\Product;
use Donphelix\Widget\Models\Catalog;
use Donphelix\Widget\Basket;
use Donphelix\Widget\StandardPricingStrategy;
use Donphelix\Widget\StandardDeliveryStrategy;

$catalog = new Catalog();
$catalog->addProduct(new Product('R01', 'Red Widget', 32.95));
$catalog->addProduct(new Product('G01', 'Green Widget', 24.95));
$catalog->addProduct(new Product('B01', 'Blue Widget', 7.95));

$pricingStrategy = new StandardPricingStrategy($catalog);
$deliveryStrategy = new StandardDeliveryStrategy();
$basket = new Basket($pricingStrategy, $deliveryStrategy);

$basket->add($catalog->getProduct('B01'));
$basket->add($catalog->getProduct('G01'));

echo "Total: " . $basket->getTotal();


