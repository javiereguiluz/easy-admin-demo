#!/usr/bin/env php
<?php

// Looks for and reports any missing translation in the EasyAdmin bundle
// translation files (it uses the English translation as the reference because
// it's always complete).

// Configuration options
// ----------------------------------------------------------------------------
$translationsDir = __DIR__.'/../vendor/javiereguiluz/easyadmin-bundle/Resources/translations';

// Don't change anything below this line
// ----------------------------------------------------------------------------
$englishTranslations = array(
    'EasyAdminBundle' => getTranslationKeys($translationsDir.'/EasyAdminBundle.en.xlf'),
    'messages' => getTranslationKeys($translationsDir.'/messages.en.xlf'),
);

$missingTranslations = findMissingTranslations($englishTranslations, $translationsDir);
displayResult($missingTranslations);

function findMissingTranslations($referenceTranslation, $translationsDir)
{
    $missingTranslations = array();

    foreach (array('EasyAdminBundle', 'messages') as $domain) {
        $availableTranslations = glob(sprintf('%s/%s.*.xlf', $translationsDir, $domain));
        foreach ($availableTranslations as $translationFile) {
            $extension = ltrim(strstr(basename($translationFile), '.'), '.');
            if ('en.xlf' === $extension) {
                continue;
            }

            $translatedKeys = getTranslationKeys($translationFile);
            $missingTranslationKeys = array_diff($referenceTranslation[$domain], $translatedKeys);

            if (!empty($missingTranslationKeys)) {
                $locale = substr($extension, 0, 2);
                $missingTranslations[$locale][$domain] = $missingTranslationKeys;
            }
        }
    }

    return $missingTranslations;
}

function getTranslationKeys($filePath)
{
    $translations = array();
    $xmlContents = simplexml_load_file($filePath);

    foreach($xmlContents->file->body->{'trans-unit'} as $translation) {
        $translations[] = (string) $translation->source;
    }

    return $translations;
}

function displayResult($missingTranslations)
{
    foreach ($missingTranslations as $locale => $domains) {
        foreach ($domains as $domain => $missingTranslationKeys) {
            echo sprintf("Missing translations in `Resources/translations/%s.%s.xlf`\n", $domain, $locale);
            foreach ($missingTranslationKeys as $translationKey) {
                echo sprintf(" * `%s`\n", $translationKey);
            }

            echo "\n";
        }

        echo 'Checkout the original translations in `Resources/translations/EasyAdminBundle.en.xlf` and `Resources/translations/messages.en.xlf`';

        echo "\n\n".str_repeat('-', 80)."\n\n";
    }
}
