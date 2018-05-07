SilverStripe Age Gate
=====================

Simple Age Gate module for SilverStripe, ensures that users entering site are 21+.

## Requirements

* SilverStripe 4.0.0+, for 3.x checkout 3.x branch


## Installation & Documentation

1. Clone Repository to your SilverStripe Project or -

        composer require moosylvania/silverstripe-age-gate

2. This will add a route /age-gate to your project and all users will be presented with a yes/no button to validate of age.  If you would like the user to type in their date of birth you can set the config option of 'askForAge'

        Moosylvania\AgeGate\Controllers\AgeGateController:
          askForAge: true

    To set the format of the dates you can change the config values 'dateFormat' (for the form intro text) and 'dateFieldFormat' for the actual SilverStripe Date Field.

        Moosylvania\AgeGate\Controllers\AgeGateController:
          dateFormat: 'm/d/Y'
          dateFieldFormat: 'MM/dd/yyyy'

3. You can set up where you want a user redirected to if they select 'No' (not of age) by adding the following config value to your site -

        Moosylvania\AgeGate\Controllers\AgeGateController:
          notOfAgeRedirect: 'https://moosylvania.com'

4. You can also setup how old someone needs to be to enter your site (default is 21 by editing the setting)

Moosylvania\AgeGate\Controllers\AgeGateController:
  yearsOld: 21

5. Run a dev/build?flush=1 and your site will now be agegated.
