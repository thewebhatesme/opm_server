OPM Server
==========================
OPM means:

# Features

# Compatibility

# Installation

## Integration, Stage, Live

You can have several environments like dev, integration, stage and live.
For each of them you can create property-files containing for example database configs.
Just put them into build/config/properties/<environment>/default.properties and invoke the
build process with option -Denvironment=<env>. The default is dev.

1. Start building your app by calling
> ./phing.phar build -Denvironment=<env>

OR

1. > sh bin/install.sh

## Development & Testing
To start development on the project, just build the environment with the defaults.

1. Start building your app by calling
> ./phing.phar build
2. Execute the test by calling
> ./phing.phar test

# phing targets

## build

## rebuild

## test

## toggleXdebug