# Domain Parking

## Prerequisites
* The domain IP to be parked must point to the server.
* If the server only has one virtual host, you can probably get a way with adding the new domain name as a serverAlias since all domains that point to the server, but do not have a virtual directory set up will default to the the default virtual directory. Otherwise, you will need to either edit the file that maps the virtual hosts, or park the domain if using shared hosting.

A easy check to see if the domain name is ready to be parked is to navigate to the domain and if the default wordpress site comes up, you are good to go.

## Installation

This is a wordpress plugin. Create a folder called domain-parking in your WordPress plugin directory and move all the files into that directory. Then activate the plugin. Go to settings in wp-admin to configure new domain names

