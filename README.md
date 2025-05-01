# Restaurant Website

A multilingual restaurant website featuring menus and ordering information. The website is built using PHP with a custom templating engine and integrates with an external WordPress API for content management.

## Table of Contents

- [Restaurant Website](#restaurant-website)
  - [Table of Contents](#table-of-contents)
  - [Overview](#overview)
  - [Directory Structure](#directory-structure)
  - [Setting Up Locally](#setting-up-locally)
    - [Prerequisites](#prerequisites)
    - [Installation](#installation)
    - [Running Locally](#running-locally)
  - [Template System](#template-system)
  - [API Integration](#api-integration)
    - [API Endpoints](#api-endpoints)
    - [Data Structures](#data-structures)
      - [Menu Items](#menu-items)
      - [Languages](#languages)
      - [Menu Categories](#menu-categories)
    - [Implementing a Custom Backend](#implementing-a-custom-backend)
  - [Multilingual Support](#multilingual-support)
  - [Deployment](#deployment)
  - [License](#license)
  - [Contact](#contact)

## Overview

This project is a client-side implementation for a restaurant website. It features:

- Multilingual support (Estonian, English, Russian, French)
- Menu display organized by categories
- Ordering information
- Mobile-responsive design

## Directory Structure

```
augustresto-client-php/
├── css/                  # CSS stylesheets
├── image/                # Image assets
├── templates/            # HTML templates
│   ├── main.html         # Main template wrapper
│   ├── menu.html         # Menu display template
│   ├── navigation.html   # Navigation template
│   ├── en/               # English templates
│   ├── et/               # Estonian templates
│   ├── fr/               # French templates
│   └── ru/               # Russian templates
├── vendor/               # Third-party code
│   └── tpl.php           # Custom templating engine
├── constants.php         # Configuration constants
├── functions.php         # Helper functions
├── index.php             # Main application entry point
├── MenuItem.php          # Menu item class
└── Request.php           # Request handling class
```

## Setting Up Locally

### Prerequisites

- PHP 8.0 or higher
- cURL extension for PHP

### Installation

1. Clone the repository:
   ```
   git clone https://github.com/yourusername/restaurant-website.git
   cd restaurant-website
   ```

2. Configure the API endpoint in `constants.php`:
   ```php
   const BASE_URL = "https://your-api-endpoint.com/wp-json/restaurant/v1";
   ```

### Running Locally

You can run the website using PHP's built-in server:

```
php -S localhost:8000
```

Then open your browser and visit: http://localhost:8000

Alternatively, you can use MAMP, XAMPP, or any other PHP development environment.

## Template System

The project uses a custom templating engine defined in `vendor/tpl.php`. The template system supports:

- Template inclusion with `tpl-include`
- Conditional rendering with `tpl-if`
- Loops with `tpl-foreach`
- Variable substitution with `{{ $variable }}`

Example:
```html
<ul class="menu">
    <li tpl-foreach="$menuCategories as $category">
        <a href="/{{ $lng }}/{{ $category['uri'] }}">{{ $category['name'] }}</a>
    </li>
</ul>
```

## API Integration

### API Endpoints

The application uses the following API endpoints from the WordPress backend:

- `menu?lng={language}&cat={category}` - Returns menu items for a specific language and category
- `active-languages` - Returns the list of active languages
- `categories?lng={language}` - Returns menu categories for a specific language

### Data Structures

#### Menu Items

```json
{
  "title": "Category Name",
  "items": [
    {
      "name": "Item Name",
      "description": "Item Description",
      "price": "€10.00"
    }
  ]
}
```

#### Languages

```json
[
  {
    "short": "et",
    "long": "Eesti"
  },
  {
    "short": "en",
    "long": "English"
  }
]
```

#### Menu Categories

```json
[
  {
    "name": "Category Name",
    "uri": "category-uri"
  }
]
```

### Implementing a Custom Backend

To implement a custom backend API:

1. Create a WordPress plugin or alternative API that provides the endpoints mentioned above
2. Ensure your API returns JSON data in the expected format
3. Update the `BASE_URL` constant in `constants.php`

If you're not using WordPress, you can create any backend that implements these endpoints with the correct data structure.

## Multilingual Support

The application supports multiple languages through language-specific templates and API content:

1. Templates for each language are stored in their respective folders (`et/`, `en/`, `ru/`, `fr/`)
2. The API provides language-specific content based on the language parameter
3. URL structure includes language code (e.g., `/en/pizzas`)

To add a new language:

1. Create a new folder in `templates/` with the language code
2. Add necessary template files (e.g., `ordering.html`)
3. Ensure the API provides content for the new language
4. Add the language to the active languages list in the backend

## Deployment

The project uses PM2 for deployment, configured in `ecosystem.config.js`. To deploy:

```
pm2 deploy production
```

Test deployment - May 1, 2025

The deployment configuration targets a specific host and deploys from the GitHub repository.

## License

[Specify your license information here]

## Contact

[Your contact information]