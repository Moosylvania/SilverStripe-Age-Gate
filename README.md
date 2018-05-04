SilverStripe-Age-Gate
=====================

Simple Age Gate module for SilverStripe, ensures that users entering site are 21+.

## Requirements

 * SilverStripe 3.1.0+

## Installation & Documentation

 1. Clone Repository to your SilverStripe Project
 2. To change the Date you want to validate for edit javascript/agegate.js and edit line 5

        var age = 21;

 3. To make a page Age Gated, simply have your Custom Page Type extend AgeGatedPage. ex.

        class MyPage extends AgeGatedPage
        class MyPage_Controller extends AgeGatedPage_Controller

 4. In the CMS create an AgeGatePage with the url /age-gate/
