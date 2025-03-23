<?php

/**
 * Categorize an entry based on the name by matching it with the provided keywords.
 *
 * @param string $name
 * @param array  $categories
 * @return string
 */
function categorizeEntry($name, $categories)
{
    foreach ($categories as $category => $keywords) {
        foreach ($keywords as $keyword) {
            if (stripos($name, $keyword) !== false) {
                return $category;
            }
        }
    }
    return 'Uncategorized';
}

/**
 * Process a CSV file and return an array of processed entries.
 *
 * @param string $filePath
 * @param array  $categories
 * @return array
 */
function processCSV($filePath, $categories)
{
    $processedEntries = [];

    if (!file_exists($filePath)) {
        error_log("File not found: " . $filePath);
        return $processedEntries;
    }

    if (($handle = fopen($filePath, 'r')) !== false) {
        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < 3) {
                continue;
            }
            $date   = trim($row[0]);
            $name   = trim($row[1]);
            $amount = trim($row[2]);

            $category = categorizeEntry($name, $categories);

            $processedEntries[] = [
                'date'     => $date,
                'name'     => $name,
                'amount'   => $amount,
                'category' => $category
            ];
        }
        fclose($handle);
    } else {
        error_log("Unable to open file: " . $filePath);
    }
    return $processedEntries;
}

/**
 * Output the category counters and values for a file.
 *
 * @param string $filePath
 * @param array  $categoryCounters
 * @param array  $categoryValue
 * @param int    $uncatCount       Count of Uncategorized entries.
 * @param float  $uncatValue       Total value for Uncategorized entries.
 */
function outputResults($filePath, $categoryCounters, $categoryValue, $uncatCount, $uncatValue)
{
    echo "<h3>File: " . htmlspecialchars($filePath) . "</h3>";

    echo "<strong>Category Totals (Count):</strong><br>";
    foreach ($categoryCounters as $category => $count) {
        echo htmlspecialchars($category) . ": " . htmlspecialchars($count) . "<br>";
    }

    if ($uncatCount > 0) {
        echo "Uncategorized: " . htmlspecialchars($uncatCount) . "<br>";
    }

    echo "<br><strong>Category Totals (Value):</strong><br>";
    foreach ($categoryValue as $category => $totalAmount) {
        echo htmlspecialchars($category) . ": " . htmlspecialchars($totalAmount) . "<br>";
    }

    if ($uncatValue > 0) {
        echo "Uncategorized: " . htmlspecialchars($uncatValue) . "<br>";
    }

    $grandTotal = 0;
    foreach ($categoryValue as $category => $totalAmount) {
        $grandTotal += $totalAmount;
    }
    $grandTotal += $uncatValue;
    echo "<br><strong>Grand Total: " . htmlspecialchars($grandTotal) . "</strong><br>";
    echo "<hr>";
}

$categories = [
    'Shopping'     => ['ASDA', 'TESCO'],
    'Fast Food'    => ['GREGGS', 'ingredient'],
    'Phone'        => ['TOPUP'],
    'Bills'        => ['TV LICENCE', 'GAS', 'INTERNET'],
    'Gambling'     => ['NATIONAL LOTTERY'],
    'NOT_INCLUDED' => ['FAMILY_PAYMENT']
];

$csvFiles = ['example.csv'];

foreach ($csvFiles as $filePath) {
    $entries = processCSV($filePath, $categories);

    $categoryCounters = [];
    $categoryValue = [];
    $uncatCount = 0;
    $uncatValue = 0;

    foreach ($entries as $entry) {
        $category = $entry['category'];
        $amountFloat = abs((float)$entry['amount']);
.
        if ($category === 'NOT_INCLUDED') {
            continue;
        }

        if (!isset($categoryCounters[$category])) {
            $categoryCounters[$category] = 0;
        }
        $categoryCounters[$category]++;

        if (!isset($categoryValue[$category])) {
            $categoryValue[$category] = 0;
        }
        $categoryValue[$category] += $amountFloat;
    }

    outputResults($filePath, $categoryCounters, $categoryValue, $uncatCount, $uncatValue);
}
?>
