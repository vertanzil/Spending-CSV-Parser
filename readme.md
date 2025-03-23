
# Spending - CSV Parser

This project is a simple PHP application that processes CSV files to categorize entries according to predefined keywords and calculates totals for each category. It is designed to help with basic financial data analysis or expense categorization.

## Overview

The main functionalities of the project include:

- **CSV Processing:** Reads CSV files line by line.
- **Data Parsing:** Extracts key fields such as date, name, and amount from each row.
- **Categorization:** Uses a list of categories with associated keywords to determine the category for each entry.
- **Aggregation:** Totals the count and value for categorized entries.
- **Output:** Displays the results in an HTML-friendly format.

## How It Works

1. **Categorize Entry:**  
   The function `categorizeEntry()` scans the name of each entry and matches it with keywords in a provided categories array. If a keyword is found, the corresponding category is returned. If no match is found, the entry is assigned to the category `Uncategorized`.

2. **Process CSV File:**  
   The function `processCSV()` opens a given CSV file, validates its content, and parses each row. For each valid line (a minimum of 3 columns), it extracts the date, name, and amount, categorizes the entry, and stores the processed data.

3. **Aggregate Results:**  
   In the main execution block, the script loops through one or more CSV files (e.g. `example.csv`) and aggregates the data:
   - Counts the number of entries per category.
   - Sums the monetary values per category.
   - Skips entries that fall under the `NOT_INCLUDED` category and wont add to the totals or final output.
   
4. **Output Results:**  
   The function `outputResults()` renders the aggregated data as HTML, showing:
   - Category-wise counts.
   - Category-wise total values.
   - A grand total combined from all categories.

## Usage

1. **Setup:**  
   - Ensure you have a working PHP environment.
   - Place your CSV files (e.g., `example.csv`) in the project root directory or update the file paths in the code as necessary.

2. **Categories Configuration:**  
   Edit the `$categories` array in `index.php` to suit your needs. Each category maps to an array of keywords. An entry's name that contains any of these keywords will be categorized accordingly.

3. **Running the Script:**  
   From the command line or a web server, run the `index.php` script. For example, if using a web server, access the script via your browser:
   ```
   http://localhost/path/to/index.php
   ```
   The script will then process the CSV files, calculate totals, and display the results in HTML format.

## Customization

- **Adding/Modifying Categories:**  
  To modify categories or add new ones, update the `$categories` array in `index.php`.

- **CSV Structure:**  
  The current CSV format assumes that each row contains at least three columns:
  1. Date
  2. Name
  3. Amount

- **Error Handling:**  
  The script logs an error if the CSV file is not found or cannot be opened. Modify error handling as needed for your environment.

## Example
An example of how this data would be presentedw would be in the attached example.csv file.