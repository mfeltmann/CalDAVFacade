#!/bin/bash

# Call unit tests 
xcodebuild -sdk macosx10.11 -project /Develop/Exercises/caldavserver/caldavserver.xcodeproj -scheme "caldavserver" clean test > /dev/null
