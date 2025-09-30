<?php


# Include the Autoloader (see "Libraries" for install instructions)
require 'vendor/autoload.php';
use Mailgun\Mailgun;

# First, instantiate the SDK with your API credentials
$mg = Mailgun::create('73ae490d-c4c78d18');

# Now, compose and send your message.
# $mg->messages()->send($domain, $params);
$mg->messages()->send('sandbox210f276469a043db9d3c540bdff6c94a.mailgun.org', [
  'from'    => 'Excited User <mailgun@sandbox210f276469a043db9d3c540bdff6c94a.mailgun.org>',
  'to'      => 'Baz <itincharge@vgn.in>',
  'subject' => 'Hello',
  'text'    => 'Testing some Mailgun awesomness!'
]);

?>