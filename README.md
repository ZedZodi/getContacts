# Test assignment


## Explanation

The code provides a minimal solution to the given task.

Further development:
- Adding a user interface and settings

- Splitting the code into classes/methods

- Integrating the code into the project as a component or in another way, depending on the project architecture

## Installation

1) Install the PhpSpreadsheet library for working with XLSX. To do this, use Composer:


	composer require phpoffice/phpspreadsheet

2) If your `vendor` directory is not located in the root of the project,
   you need to specify the correct path to it in the script on line 4:

   `require 'vendor/autoload.php';`.

## Usage

The script needs to be placed in the root of the site, preferably in the local folder.
After navigating to the link, the contact list will automatically download in the requested format (CSV/XLSX).

To export to CSV, go to: http://your_site/getContact.php?export=csv

To export to XLSX, go to: http://your_site/getContact.php?export=xlsx