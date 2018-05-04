SilverStripe Age Gate
=====================

Simple Age Gate module for SilverStripe, ensures that users entering site are 21+.

## Requirements

 * SilverStripe 4.0.0+, for 3.x checkout 3.x branch

## Installation & Documentation

 1. Clone Repository to your SilverStripe Project
 2. Add the following your sites app config.yml/mysite.yml etc...

        SilverStripe\CMS\Controllers\ContentController:
          extensions:
            - Moosylvania\AgeGate\Extensions\AgeGateExtension

 3. This will add a route /age-gate to your project and all users will be presented with a yes/no button to validate of age.
 4. You can set up where you want a user redirected to if they select no by adding the following config value to your site -

        Moosylvania\AgeGate\Controllers\AgeGateController:
          notOfAgeRedirect: 'https://moosylvania.com'

5. Run a dev/build?flush=1 and your site will now be agegated.
